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
        'type',
    ];

    public $timestamps = true;

    const TYPE_TEACHER = 1;
    const TYPE_LABORATORY_TEACHING_STAFF = 2;
    const TYPE_AUTHOR = 3;
    const TYPE_STUDENT = 4;

    /**
     * @return BelongsToMany
     */
    public function publications(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Publication::class, 'author_publication', 'person_id', 'publication_id');
    }

    /**
     * @return array[]
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_AUTHOR => 'Author',
            self::TYPE_STUDENT => 'Student',
            self::TYPE_TEACHER => 'Teacher',
            self::TYPE_LABORATORY_TEACHING_STAFF => 'Laboratory Teaching Staff'
        ];
    }
}
