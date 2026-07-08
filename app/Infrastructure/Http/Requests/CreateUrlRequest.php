<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'original_url' => ['required', 'url', 'max:2048'],
            'custom_alias' => ['nullable', 'alpha_dash', 'min:3', 'max:50', 'unique:urls,custom_alias'],
            'expires_at' => ['nullable', 'date', 'after:now'],
        ];
    }

    public function validatedWithMessages(): array
    {
        return [
            'original_url.required' => 'Original URL обязателен.',
            'original_url.url' => 'Original URL должен быть валидным.',
            'original_url.max' => 'Original URL не может превышать 2048 символов.',
            'custom_alias.unique' => 'Эта заглушка уже используется.',
        ];
    }
}
