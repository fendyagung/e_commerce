<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    protected $table = 'slideshows';

    protected $fillable = [
        'user_id',
        'foto',
        'caption_title',
        'caption_content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}