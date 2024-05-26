<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Models\File;
use App\Models\Publication;
use App\Filament\Resources\PublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPublication extends EditRecord
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $fileId = $data['file'];
        unset($data['file']);

        if (!empty($fileId)) {
            $record->file_id = $fileId;
            $record->save();
        }

        $record->update($data);

        return $record;
    }
}
