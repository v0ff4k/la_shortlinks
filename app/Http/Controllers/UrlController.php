<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use App\Infrastructure\Http\Requests\CreateUrlRequest;
use App\Infrastructure\Http\Resources\UrlResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UrlController extends Controller
{
    public function __invoke(
        CreateUrlRequest $request,
        CreateShortUrlHandler $handler
    ): JsonResponse {
        $dto = CreateUrlDTO::fromRequest($request);
        $command = new CreateShortUrlCommand($dto);
        $url = $handler->handle($command);

        return response()->json(new UrlResource($url), 201);
    }
}
