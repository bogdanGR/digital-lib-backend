<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Publication extends Model
{
    use HasFactory;

    protected $table = 'publication';

    protected $fillable = [
        'title',
        'author_id',
        'abstract',
        'publisher',
        'publication_date',
        'publication_type',
        'file_id',
        'created_at',
        'updated_at',
    ];

    const TYPE_JOURNAL = 1;
    const TYPE_BOOK = 2;
    const TYPE_CONFERENCE = 3;
    const TYPE_DIPLOMA = 4;
    const TYPE_PHD = 5;

    public $timestamps = true;

    /**
     * @return BelongsToMany
     */
    public function authors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(People::class, 'author_publication', 'publication_id', 'person_id');
    }

    /**
     * @return BelongsTo
     */
    public function file(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    /**
     * @return string[]
     */
    public static function getPublicationTypes(): array
    {
        return [
            self::TYPE_JOURNAL => 'Journal',
            self::TYPE_BOOK => 'Book',
            self::TYPE_CONFERENCE => 'Conference',
            self::TYPE_DIPLOMA => 'Diploma Thesis',
            self::TYPE_PHD => 'Phd Thesis',
        ];
    }

    public static function getPublicationTypeIdByType($type): ?int
    {
        $types = array_flip(self::getPublicationTypes());
        return $types[$type] ?? null;
    }
}
