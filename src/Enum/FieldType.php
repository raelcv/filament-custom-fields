<?php

namespace HungryBus\CustomFields\Enum;

enum FieldType: string
{
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case NUMBER = 'number';
    case SELECT = 'select';
    case CHECKBOX = 'checkbox';
    case RADIO = 'radio';
    case DATE = 'date';
    case TIME = 'time';
    case DATETIME = 'datetime';
    case RICH_TEXT = 'rich_text';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toSelect(): array
    {
        return array_combine(
            self::toArray(),
            array_map('ucfirst', self::toArray())
        );
    }

    public function hasOptions(): bool
    {
        return in_array($this, [self::SELECT, self::RADIO]);
    }
}
