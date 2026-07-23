<?php

namespace App\Http\Requests;

use App\Rules\SafeGrowthMetadata;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGrowthEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) config('growth.enabled');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::in(array_keys(config('growth.events', [])))],
            'anonymous_id' => ['nullable', 'uuid'],
            'path' => ['nullable', 'string', 'max:2048'],
            'referrer' => ['nullable', 'url', 'max:2048'],
            'metadata' => ['nullable', 'array', 'max:'.config('growth.metadata_limit'), new SafeGrowthMetadata($this->input('name'))],
        ];
    }
}
