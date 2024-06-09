<?php

namespace App\Http\Resources;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'abstract' => $this->abstract,
            'publisher' => $this->publisher,
            'publication_date' => $this->publication_date,
            'publication_type_id' => $this->publication_type,
            'publication_type' => !empty($this->publication_type) ? Publication::getPublicationTypes()[$this->publication_type] : null,
            'file' => $this->file ? url(Storage::url($this->file->file_path)) : null,
            'authors' => PeopleResource::collection($this->whenLoaded('authors')),

        ];
    }
}
