<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
// use Modules\Recruitment\Database\Factories\ClientFactory;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'slug',
        'company_type',
        'industry',
        'website_url',
        'description',
        'primary_email',
        'secondary_email',
        'phone_number',
        'alternative_phone',
        'linkedin_url',
        'facebook_url',
        'twitter_url',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'postal_code',
        'company_size',
        'founded_year',
        'registration_number',
        'tax_id',
        'is_active',
        'is_featured',
        'subscription_tier',
        'subscription_expiry',
        'jobs_posted_count',
        'hiring_capacity',
        'contact_person_name',
        'contact_person_position',
        'contact_person_email',
        'contact_person_phone',
        'client_logo_path',
        'banner_image_path',
        'recruitment_preferences',
        'custom_fields',
        'last_login_at',
        'login_count'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'recruitment_preferences' => 'array',
        'custom_fields' => 'array',
        'subscription_expiry' => 'datetime',
        'last_login_at' => 'datetime',
        'founded_year' => 'integer',
        'jobs_posted_count' => 'integer',
        'login_count' => 'integer',
        'hiring_capacity' => 'integer',
        'subscription_tier' => 'integer',
    ];

    /**
     * Get the jobs associated with the client.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(JobOpening::class);
    }

    /**
     * Generate a slug from the name.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ];

        return implode(', ', array_filter($parts));
    }

    /**
     * Scope a query to only include active clients.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured clients.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Check if the client's subscription is still valid.
     */
    public function hasValidSubscription()
    {
        return $this->subscription_expiry === null || now()->lt($this->subscription_expiry);
    }

    /**
     * Get the subscription tier name.
     */
    public function getSubscriptionTierNameAttribute()
    {
        $tiers = [
            1 => 'Basic',
            2 => 'Pro',
            3 => 'Enterprise'
        ];
        
        return $tiers[$this->subscription_tier] ?? 'Unknown';
    }

    /**
     * Get the contact person's full details.
     */
    public function getContactPersonDetailsAttribute()
    {
        return [
            'name' => $this->contact_person_name,
            'position' => $this->contact_person_position,
            'email' => $this->contact_person_email,
            'phone' => $this->contact_person_phone
        ];
    }

    /**
     * Get the social media links.
     */
    public function getSocialLinksAttribute()
    {
        return [
            'linkedin' => $this->linkedin_url,
            'facebook' => $this->facebook_url,
            'twitter' => $this->twitter_url
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    // protected static function newFactory()
    // {
    //     return ClientFactory::new();
    // }
}
