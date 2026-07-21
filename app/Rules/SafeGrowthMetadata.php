<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class SafeGrowthMetadata implements ValidationRule
{
    public function __construct(private readonly ?string $eventName = null) {}

    /** @param array<string, mixed> $value */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            return;
        }

        $blockedKeys = collect(config('growth.blocked_metadata_keys', []))
            ->map(fn (string $key): string => Str::lower($key))
            ->all();
        $allowedKeys = config('growth.events', [])[$this->eventName] ?? [];

        foreach ($value as $key => $metadataValue) {
            if (! is_string($key) || in_array(Str::lower($key), $blockedKeys, true)) {
                $fail('The :attribute field contains a blocked key.');

                return;
            }

            if (! in_array($key, $allowedKeys, true)) {
                $fail('The :attribute field contains a key that is not allowed for this event.');

                return;
            }

            if (! is_null($metadataValue) && ! is_scalar($metadataValue)) {
                $fail('The :attribute field only accepts string, number, boolean, or null values.');

                return;
            }

            if (is_string($metadataValue) && mb_strlen($metadataValue) > (int) config('growth.metadata_string_limit', 255)) {
                $fail('The :attribute field contains a value that is too long.');

                return;
            }
        }
    }
}
