<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course';

    protected $fillable = [
        'title_en',
        'title_gr',
        'type',
    ];

    const UNDERGRADUATE = 1;
    const GRADUATE = 2;

    public $timestamps = true;

    /**
     * @return string[]
     */
    public static function types(): array
    {
        return [
            self::UNDERGRADUATE => 'Undergraduate',
            self::GRADUATE => 'Graduate',
        ];
    }

}
