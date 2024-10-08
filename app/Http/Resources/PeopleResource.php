<?php

namespace App\Http\Resources;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeopleResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name .' '. $this->last_name,
            'role' => $this->role,
            'title' => $this->title,
            'type_id' => $this->type,
            'type' => People::getTypes()[$this->type]
        ];
    }
}
