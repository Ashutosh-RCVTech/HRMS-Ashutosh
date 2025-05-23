<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Create a new role
     *
     * @param string $name
     * @param string|null $description
     * @return self
     */
    public static function createRole(string $name, ?string $description = null): self
    {
        return self::create([
            'name' => $name,
            'slug' => strtolower(str_replace(' ', '_', $name)),
            'description' => $description
        ]);
    }
}
