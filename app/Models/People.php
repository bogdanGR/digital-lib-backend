<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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


    /**
     * @return BelongsToMany
     */
    public function publications(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Publication::class, 'author_publication', 'person_id', 'publication_id');
    }
}
