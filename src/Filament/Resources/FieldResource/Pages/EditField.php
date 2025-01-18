<?php

namespace HungryBus\CustomFields\Filament\Resources\FieldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use HungryBus\CustomFields\Concerns\FieldResource\HandlesFieldFormData;
use HungryBus\CustomFields\Concerns\FieldResource\SendsValidationMessage;
use HungryBus\CustomFields\Filament\Resources\FieldResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class EditField extends EditRecord
{
    use HandlesFieldFormData;
    use SendsValidationMessage;

    protected static string $resource = FieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['designation']) && !empty($this->record?->designation)) {
            $data['designation'] = $this->record?->designation;
        }

        if (!empty($this->record->field_type)) {
            $data['has_options'] = $this->record->field_type->hasOptions();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->prepareData($data);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            $this->validateFieldData($data, $record);
            $record->update($data);

            return $record;
        } catch (ValidationException $ex) {
            $this->addErrorToForm('name', $ex->validator->errors()->first('name'));

            throw $ex;
        }
    }
}
