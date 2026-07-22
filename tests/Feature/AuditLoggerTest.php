<?php

use App\Models\AuditLog;
use App\Models\User;
use App\Services\AuditLogger;

it('records an allowed audit action with technical identifiers only', function (): void {
    $actor = User::factory()->create();
    $target = User::factory()->create();

    app(AuditLogger::class)->record('user.role.changed', $actor, $target);

    $auditLog = AuditLog::query()->sole();

    expect($auditLog->actor_id)->toBe($actor->id)
        ->and($auditLog->action)->toBe('user.role.changed')
        ->and($auditLog->target_type)->toBe(User::class)
        ->and($auditLog->target_id)->toBe($target->id)
        ->and($auditLog->metadata)->toBe([]);
});

it('refuses audit metadata to prevent sensitive data collection', function (): void {
    expect(fn () => app(AuditLogger::class)->record('admin.accessed', metadata: [
        'token' => 'secret-token',
    ]))->toThrow(InvalidArgumentException::class);

    expect(AuditLog::query()->count())->toBe(0);
});

it('refuses actions outside the approved audit scope', function (): void {
    expect(fn () => app(AuditLogger::class)->record('profile.viewed'))
        ->toThrow(InvalidArgumentException::class);
});
