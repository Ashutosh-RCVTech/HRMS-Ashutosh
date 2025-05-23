<?php

namespace Modules\Recruitment\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Recruitment\Models\PlacementDrive;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class College extends Authenticatable implements CanResetPasswordContract, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, CanResetPassword;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'website',
        'logo',
        'description',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'contact_person_designation',
        'is_active',
        'is_verified',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'password' => 'hashed',
    ];

    public function placementDrives()
    {
        return $this->hasMany(PlacementDrive::class);
    }

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }

        // Check if the logo exists in storage
        if (!Storage::disk('public')->exists($this->logo)) {
            Log::warning('Logo file not found in storage', [
                'college_id' => $this->id,
                'logo_path' => $this->logo
            ]);
            return null;
        }

        return Storage::disk('public')->url($this->logo);
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     * @see \Illuminate\Contracts\Auth\MustVerifyEmail::hasVerifiedEmail()
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     * @see \Illuminate\Contracts\Auth\MustVerifyEmail::markEmailAsVerified()
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'is_verified' => true,
        ])->save();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     * @see \Illuminate\Contracts\Auth\MustVerifyEmail::sendEmailVerificationNotification()
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \Modules\Recruitment\Notifications\CollegeVerifyEmail);
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'college.verification.verify',
            now()->addMinutes(60),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );
    }
}
