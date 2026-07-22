<?php

use App\Models\AuditLog;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Schema;

it('records an allowed audit action with technical identifiers only', function (): void {
    $actor = User::factory()->create();
    $target = User::factory()->create();

    app(AuditLogger::class)->record('user.role.changed', $actor, $target);

    $auditLog = AuditLog::query()->sole();

    expect($auditLog->actor_id)->toBe($actor->id)
        ->and($auditLog->action)->toBe('user.role.changed')
        ->and($auditLog->target_type)->toBe(User::class)
        ->and($auditLog->target_id)->toBe($target->id);
});

it('does not create a metadata column that could store sensitive data', function (): void {
    expect(Schema::hasColumn('audit_logs', 'metadata'))->toBeFalse();
});

it('refuses actions outside the approved audit scope', function (): void {
    expect(fn () => app(AuditLogger::class)->record('profile.viewed'))
        ->toThrow(InvalidArgumentException::class);
});
