<?php

declare(strict_types=1);

namespace App\Domains\Analytics\Models;

use App\Domains\Url\Models\Url;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlVisit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['url_id', 'ip_address', 'visited_at'];

    protected $casts = ['visited_at' => 'datetime'];

    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
