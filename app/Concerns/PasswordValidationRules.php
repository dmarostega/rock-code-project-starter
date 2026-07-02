<?php

namespace App\Concerns;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /** @return array<int, mixed> */
    protected function passwordRules(): array
    {
        return ['required', 'string', Password::defaults(), 'confirmed'];
    }
}
