<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read int $id
 * @property-read string $original_url
 * @property-read string $short_code
 * @property-read \Carbon\Carbon $created_at
 */
class UrlResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'original_url' => $this->original_url,
            'short_link' => url("/{$this->short_code}"),
            'created_at' => $this->created_at,
        ];
    }
}
