<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use NumberFormatter;
use OpenSpout\Writer\XLSX\Helper\DateHelper;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $formatter = new NumberFormatter('el_GR', NumberFormatter::CURRENCY);

        return [
            'id' => $this->id,
            'project_name' => $this->project_name,
            'framework' => $this->framework,
            'contract_number' => $this->contract_number,
            'status' => !empty($this->status) ? Project::getStatuses()[$this->status] : null,
            'type' => !empty($this->type) ? Project::getTypes()[$this->type] : null,
            'full_title' => $this->full_title,
            'participants' => $this->participants,
            'budget' => $formatter->formatCurrency($this->budget, 'EUR'),
            'description' => $this->description,
            'project_url' => $this->project_url,
            'duration' => Project::calculateMonthsDifference($this->date_start, $this->date_end),
        ];
    }
}
