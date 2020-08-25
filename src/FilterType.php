<?php

namespace Heyday\ModelAdminFilter;

use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;

/**
 * ModelAdminFilter filter types set
 */
class FilterType
{
    /**
     * Add date range filter
     */
    public static function getDateRangeFilter(string $field, string $beginTitle = '', string $endTitle = ''): array
    {
        $title = self::getFieldLabel($field);
        $beginTitle = !empty($beginTitle) ? $beginTitle : $title . ' Begin';
        $endTitle = !empty($endTitle) ? $endTitle : $title . ' End';

        return [
            'begin' => DateField::create($field . ':GreaterThanOrEqual', $beginTitle),
            'end' => DateField::create($field . ':LessThanOrEqual', $endTitle)
        ];
    }

    /**
     * Add date time range filter
     */
    public static function getDateTimeRangeFilter(string $field, string $beginTitle = '', string $endTitle = ''): array
    {
        $title = self::getFieldLabel($field);
        $beginTitle = !empty($beginTitle) ? $beginTitle : $title . ' Begin';
        $endTitle = !empty($endTitle) ? $endTitle : $title . ' End';

        return [
            'begin' => DatetimeField::create($field . ':GreaterThanOrEqual', $beginTitle),
            'end' => DatetimeField::create($field . ':LessThanOrEqual', $endTitle)
        ];
    }

    /**
     * Add numeric range filter
     */
    public static function getNumericRangeFilter(string $field, string $beginTitle = '', string $endTitle = ''): array
    {
        $title = self::getFieldLabel($field);
        $beginTitle = !empty($beginTitle) ? $beginTitle : $title . ' Begin';
        $endTitle = !empty($endTitle) ? $endTitle : $title . ' End';

        return [
            'begin' => NumericField::create($field . ':GreaterThanOrEqual', $beginTitle),
            'end' => NumericField::create($field . ':LessThanOrEqual', $endTitle)
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
