<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactAttachment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

    /**
     * Get the contact that owns the attachment.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
