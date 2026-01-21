<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get the initials from the brand name
     */
    public function getInitials(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 2);
    }

    /**
     * Delete the photo from storage when deleted
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($brand) {
            if ($brand->photo && Storage::disk('public')->exists($brand->photo)) {
                Storage::disk('public')->delete($brand->photo);
            }
        });
    }
}
