<?php

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'original_url' => $this->original_url,
            'short_link' => url("/{$this->short_code}"),
            'created_at' => $this->created_at,
        ];
    }
}
