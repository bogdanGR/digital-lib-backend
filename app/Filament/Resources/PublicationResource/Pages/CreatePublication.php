<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use App\Models\File;
use App\Models\Publication;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

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


        if (!empty($fileId)) {
            $fileModel = File::find($fileId);
            $path = public_path('storage/' . $fileModel->file_path);
            try {
                // Extract text from the PDF
                $pdfText = Pdf::getText($path);
            } catch (\Exception $e) {
                Log::error('PDF text extraction failed: ' . $e->getMessage(), [
                    'file' => $path
                ]);
                $pdfText = null;
            }

            $fileModel->update(['text_content' => $pdfText]);
        }


        return $publication;
    }
}
