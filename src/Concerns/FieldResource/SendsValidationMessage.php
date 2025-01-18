<?php

namespace HungryBus\CustomFields\Concerns\FieldResource;

use Filament\Notifications\Notification;

trait SendsValidationMessage
{
    protected function addErrorToForm(string $field, string $message): void
    {
        $this->addError($field, $message);

        $this->addNotification($message);

        $this->halt();
    }

    protected function addNotification(string $message): void
    {
        Notification::make()
            ->title($message)
            ->danger()
            ->send();
    }
}
