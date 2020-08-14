<?php

namespace Heyday\ModelAdminFilter;

use SilverStripe\Forms\DateField;

/**
 * ModelAdminFilter filter types set
 */
class FilterType
{
    /**
     * Add date range filter
     */
    public static function getDateRangeFilter(string $dateField = 'Created', string $beginTitle = '', string $endTitle = ''): array
    {
        $dateTitle = self::getFieldLabel($dateField);
        $beginTitle = !empty($beginTitle) ? $beginTitle : $dateTitle . ' Begin';
        $endTitle = !empty($endTitle) ? $endTitle : $dateTitle . ' End';

        return [
            'beginDate' => DateField::create($dateField . ':GreaterThanOrEqual', $beginTitle),
            'endDate' => DateField::create($dateField . ':LessThanOrEqual', $endTitle)
        ];
    }

    /**
     * Return field name to human readable label
     */
    public static function getFieldLabel(string $name): string
    {
        return implode(' ', preg_split('/(?=[A-Z])/', $name));
    }
}
