<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'is_free'=>$this->is_free,
            'workshop'=>[
                'id'=>$this->workshop->id
            ],
            'subchapters' => SubchapterResource::collection($this->whenLoaded('subChapters')),
        ];
    }
}
