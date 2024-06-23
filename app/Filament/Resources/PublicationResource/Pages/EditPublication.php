<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Models\File;
use App\Models\Publication;
use App\Filament\Resources\PublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

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

        if (!empty($fileId)) {
            $fileModel = File::find($fileId);
            $path = public_path('storage/' . $fileModel->file_path);
            Log::info('File path for text extraction: ' . $path);
            try {
                $pdfText = Pdf::getText($path);
            } catch (\Exception $e) {
                Log::error('PDF text extraction failed: ' . $e->getMessage(), [
                    'file' => $path
                ]);
                $pdfText = null;
            }

            $fileModel->update(['text_content' => $pdfText]);
        }

        $record->update($data);

        return $record;
    }
}
