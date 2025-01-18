<?php

namespace HungryBus\CustomFields\Resolvers\CustomData;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field as FieldComponent;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use HungryBus\CustomFields\Enum\FieldType;
use HungryBus\CustomFields\Models\Field;
use Vicmans\FilamentNumberInput\NumberInput;

class CustomFieldResolver extends BaseCustomDataResolver
{
    protected Field $field;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    public static function make(Field $field): CustomFieldResolver
    {
        return new CustomFieldResolver($field);
    }

    public function resolve(): FieldComponent
    {
        $fieldComponent = $this->getFieldComponent();

        return $this->applyCommonSettings($fieldComponent);
    }

    private function getFieldComponent(): FieldComponent
    {
        return match ($this->field->field_type) {
            FieldType::TEXTAREA => Textarea::make($this->getFormFieldName())
                ->minLength($this->field->min)
                ->maxLength($this->field->max),

            FieldType::NUMBER => NumberInput::make($this->getFormFieldName())
                ->minValue($this->field->min)
                ->maxValue($this->field->max)
                ->placeholder($this->field->placeholder),

            FieldType::SELECT => Select::make($this->getFormFieldName())
                ->options($this->getOptions()),

            FieldType::CHECKBOX => Checkbox::make($this->getFormFieldName()),

            FieldType::RADIO => Radio::make($this->getFormFieldName())
                ->options($this->getOptions()),

            FieldType::DATE => DatePicker::make($this->getFormFieldName())
                ->native(false),

            FieldType::DATETIME => DateTimePicker::make($this->getFormFieldName())
                ->native(false),

            FieldType::RICH_TEXT => RichEditor::make($this->getFormFieldName()),

            default => TextInput::make($this->getFormFieldName())
                ->minLength($this->field->min)
                ->maxLength($this->field->max)
                ->placeholder($this->field->placeholder),
        };
    }

    private function applyCommonSettings(FieldComponent $fieldComponent): FieldComponent
    {
        return $fieldComponent
            ->label($this->field->label)
            ->helperText($this->field->description)
            ->required($this->field->required);
    }

    private function getOptions(): array
    {
        return $this->field
            ->options
            ?->pluck('label', 'value')
            ->toArray();
    }
}
