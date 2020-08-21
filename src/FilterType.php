<?php

namespace Heyday\ModelAdminFilter;

use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\TextField;

/**
 * ModelAdminFilter filter types set
 */
class FilterType
{
    /**
     * Add date range filter
     */
    public static function getDateRangeFilter(string $dateField, string $beginTitle = '', string $endTitle = ''): array
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
     * Add date time range filter
     */
    public static function getDateTimeRangeFilter(string $dateTimeField, string $beginTitle = '', string $endTitle = ''): array
    {
        $dateTimeTitle = self::getFieldLabel($dateTimeField);
        $beginTitle = !empty($beginTitle) ? $beginTitle : $dateTimeTitle . ' Begin';
        $endTitle = !empty($endTitle) ? $endTitle : $dateTimeTitle . ' End';

        return [
            'beginDateTime' => DatetimeField::create($dateTimeField . ':GreaterThanOrEqual', $beginTitle),
            'endDateTime' => DatetimeField::create($dateTimeField . ':LessThanOrEqual', $endTitle)
        ];
    }

    /**
     * Add keyword search filter
     */
    public static function getKeywordSearchFilter(string $title = ''): TextField
    {
        $title = !empty($title) ? $title : "Search By Keyword";

        return TextField::create('SearchByKeyword', $title);
    }

    /**
     * Return field name to human readable label
     */
    public static function getFieldLabel(string $name): string
    {
        return implode(' ', preg_split('/(?=[A-Z])/', $name));
    }
}
