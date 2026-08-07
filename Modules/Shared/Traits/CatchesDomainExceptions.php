<?php

namespace Modules\Shared\Traits;

use Closure;
use Filament\Notifications\Notification;
use Modules\Shared\Exceptions\DomainException;

/**
 * Use inside Filament Resource/Page/Action classes to turn a thrown
 * DomainException into a red notification instead of a 500 page
 * (docs/05-coding-standards.md § 1 — "Filament: notification merah dengan
 * pesan exception, form tidak ke-reset kalau gagal"). The form state is
 * preserved automatically because we return from the closure instead of
 * letting the exception propagate and abort the Livewire request.
 *
 * Usage inside a Filament action:
 *   ->action(fn ($record) => $this->runCatchingDomainExceptions(
 *       fn () => app(ReceivePurchaseOrderService::class)->receive($record, ...)
 *   ))
 */
trait CatchesDomainExceptions
{
    protected function runCatchingDomainExceptions(Closure $callback): mixed
    {
        try {
            return $callback();
        } catch (DomainException $exception) {
            Notification::make()
                ->danger()
                ->title($exception->getMessage())
                ->send();

            return null;
        }
    }
}
