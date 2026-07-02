<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use App\Infrastructure\Http\Requests\CreateUrlRequest;
use App\Infrastructure\Http\Resources\UrlResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

#[\Illuminate\Routing\Middleware\RequireScopes(['api'])] // условное обозначение, для Filament не нужно
class UrlController extends Controller
{
    public function __invoke(
        CreateUrlRequest $request,
        CreateShortUrlHandler $handler
    ): JsonResponse {
        $dto = \App\Application\Url\DTOs\CreateUrlDTO::fromRequest($request);
        $command = new CreateShortUrlCommand($dto);
        $url = $handler->handle($command);

        return response()->json(new UrlResource($url), 201);
    }
}
