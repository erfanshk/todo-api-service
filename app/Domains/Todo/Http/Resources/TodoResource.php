<?php

namespace App\Domains\Todo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->label(),
            'statusPure' => $this->status->value,
            'done_at' => $this->done_at?->format('Y/m/d H:i'),
        ];
    }
}
