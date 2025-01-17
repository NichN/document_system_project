<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{


    use HasFactory;

    protected $table = 'documents';
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'type',
        'uploaded_by',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by')->select('username');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
