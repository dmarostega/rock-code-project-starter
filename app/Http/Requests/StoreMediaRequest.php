<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'file' => ['required', File::types(config('media.allowed_mimes'))->max(config('media.max_size_kb'))],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ];
    }
}
