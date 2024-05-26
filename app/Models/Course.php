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

    public static function types()
    {
        return [
            self::UNDERGRADUATE => 'Undergraduate',
            self::GRADUATE => 'Graduate',
        ];
    }

}
