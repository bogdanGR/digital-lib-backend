<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use App\Models\File;
use App\Models\Publication;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePublication extends CreateRecord
{
    protected static string $resource = PublicationResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $fileId = $data['file'];
        unset($data['file']);

        $publication = static::getModel()::create($data);

        $publication->file_id = $fileId;
        $publication->save();

        return $publication;
    }
}
