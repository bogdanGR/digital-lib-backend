<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $timestamps = true;

    const TYPE_EU = 1;
    const TYPE_GR = 2;

    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED = 2;


    protected $fillable = [
        'project_name',
        'framework',
        'contract_number',
        'status',
        'type',
        'full_title',
        'participants',
        'budget',
        'description',
        'project_url',
        'date_start',
        'date_end',
    ];

    /**
     * @return string[]
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_EU => 'EU Funding',
            self::TYPE_GR => 'Greek Funding',
        ];
    }

    /**
     * @return string[]
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }
}
