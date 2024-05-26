<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'title',
    ];

    public $timestamps = true;

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'author_publication', 'person_id', 'publication_id');
    }
}
