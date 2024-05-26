<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    use HasFactory;

    protected $table = 'file';

    protected $fillable = [
        'name',
        'file_path',
        'size',
        'type',
    ];

    public $timestamps = true;

    /**
     * @return HasMany
     */
    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }
}
