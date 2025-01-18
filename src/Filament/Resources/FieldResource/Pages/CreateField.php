<?php

namespace HungryBus\CustomFields\Filament\Resources\FieldResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use HungryBus\CustomFields\Concerns\FieldResource\HandlesFieldFormData;
use HungryBus\CustomFields\Concerns\FieldResource\SendsValidationMessage;
use HungryBus\CustomFields\Filament\Resources\FieldResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateField extends CreateRecord
{
    use HandlesFieldFormData;
    use SendsValidationMessage;

    protected static string $resource = FieldResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->prepareData($data);
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            $this->validateFieldData($data);

            return static::getModel()::create($data);
        } catch (ValidationException $ex) {
            $this->addErrorToForm('name', $ex->validator->errors()->first('name'));

            throw $ex;
        }
    }
}
