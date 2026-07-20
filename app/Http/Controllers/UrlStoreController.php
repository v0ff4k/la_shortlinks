<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UrlStoreController extends Controller
{
    public function __construct(
        private readonly CreateShortUrlHandler $handler
    ) {}

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'original_url' => ['required', 'url', 'max:2048'],
            'custom_alias' => ['nullable', 'string', 'alpha_dash', 'min:3', 'max:50', 'unique:urls,custom_alias'],
            'expires_at' => ['nullable', 'date', 'after:now'],
        ]);

        $dto = new CreateUrlDTO(
            originalUrl: $validated['original_url'],
            customAlias: $validated['custom_alias'] ?? null,
            expiresAt: isset($validated['expires_at']) ? now()->parse($validated['expires_at']) : null,
            userId: Auth::id() !== null ? (int) Auth::id() : null, // true type casting.
        );

        $command = new CreateShortUrlCommand($dto);
        $url = $this->handler->handle($command);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Short URL created',
                'short_url' => url($url->short_code),
                'data' => $url,
            ], 201);
        }

        return redirect()
            ->back()
            ->with('success', 'Ссылка успешно создана!')
            ->with('short_url', url($url->short_code));
    }
}
