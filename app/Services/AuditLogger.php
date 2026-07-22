<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AuditLogger
{
    public function record(
        string $action,
        ?Authenticatable $actor = null,
        ?Model $target = null,
    ): AuditLog {
        $this->ensureActionIsAllowed($action);

        return AuditLog::query()->create([
            'actor_id' => $actor?->getAuthIdentifier(),
            'action' => $action,
            'target_type' => $target?->getMorphClass(),
            'target_id' => $target?->getKey(),
            'created_at' => now(),
        ]);
    }

    private function ensureActionIsAllowed(string $action): void
    {
        if (! in_array($action, config('audit.actions', []), true)) {
            throw new InvalidArgumentException('The audit action is not allowed.');
        }
    }
}
