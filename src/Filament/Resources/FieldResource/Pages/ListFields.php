<?php

namespace HungryBus\CustomFields\Filament\Resources\FieldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use HungryBus\CustomFields\Filament\Resources\FieldResource;

class ListFields extends ListRecords
{
    protected static string $resource = FieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()->can('View Any Field');
    }
}
