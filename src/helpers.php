<?php

if (! function_exists('getIcon')) {
    function getIcon(bool $condition): string
    {
        return $condition ? getAffirmIcon() : getNegativeIcon();
    }
}

if (! function_exists('getAffirmIcon')) {
    function getAffirmIcon(): string
    {
        return 'heroicon-s-check';
    }
}

if (! function_exists('getNegativeIcon')) {
    function getNegativeIcon(): string
    {
        return 'heroicon-o-x-circle';
    }
}

if (! function_exists('getIconColor')) {
    function getIconColor(bool $condition): string
    {
        return $condition ? 'success' : 'gray';
    }
}
