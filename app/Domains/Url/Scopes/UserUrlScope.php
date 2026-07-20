<?php

declare(strict_types=1);

namespace App\Domains\Url\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserUrlScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            /** @var int $userId */
            $userId = Auth::id();
            $builder->where('user_id', $userId);
        }
    }
}
