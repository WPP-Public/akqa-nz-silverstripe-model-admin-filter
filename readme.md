# Model Admin Filter for SilverStripe

Custom filters collection for Silverstripe Model Admin GridField.

## Installation

- SilverStripe 4 `composer require heyday/model-admin-filter`

## Quick Usage

- Extend model admin:
    ```
    MyProject\ModelAdmin\MyAdmin:
        extensions:
            - Heyday\ModelAdminFilter\FilterExtension
    ```
- In your model admin, add this function:
    ```
    /**
     * {@inheritdoc}
     */
    public function getList()
    {
        $list = parent::getList();
        $list = $this->getFilteredList($list);

        return $list;
    }
    ```
    
    `getFilteredList` will return filtered list from custom filter.

- Also in your model admin, add this function to add custom filter fields:
    ```
    /**
     * List of ModelAdminFilter custom fields
     */
    public function extraFilterFields(): array
    {
        return [
            [
                'fieldName' => 'Created',
                'fieldType' => 'dateTimeRange',
                'options' => [
                    'beginTitle' => 'Create Date Begin',
                    'endTitle' => 'Create Date End'
                ]
            ]
        ];
    }
    ```

    The example above will add custom filter of `dateTimeRange` which is a date time range filter of `Created` field.
    This filter will display record where `Created` dates and times are between selected range.

## Common Field Attribute

- `fieldName`: the DB field which will be filtered
- `fieldType` : current available fields, see [Available Filter Fields Type](#available-filter-fields-type)

## Available Filter Fields Type

### dateRange

Filter record by date range of selected date field.

```
[
    'fieldName' => 'Created',
    'fieldType' => 'dateRange',
    'options' => [
        'beginTitle' => 'Create Date From',
        'endTitle' => 'Create Date To'
    ]
]
```

Options:
- `beginTitle`: custom begin label
- `endTitle`: custom end label

### dateTimeRange

Filter record by date and time range of selected date field.

```
[
    'fieldName' => 'Created',
    'fieldType' => 'dateTimeRange',
    'options' => [
        'beginTitle' => 'Create Time From',
        'endTitle' => 'Create Time To'
    ]
]
```

Options:
- `beginTitle`: custom begin label
- `endTitle`: custom end label

### numericRange

Filter record by numeric range of selected date field.

```
[
    'fieldName' => 'Weight',
    'fieldType' => 'numericRange',
    'options' => [
        'beginTitle' => 'Weight From',
        'endTitle' => 'Weight To'
    ]
]
```

Options:
- `beginTitle`: custom begin label
- `endTitle`: custom end label

## Search By Keyword

Filter record by keyword, add this function in model admin:

```
/**
 * List of fields filtered by keyword
 */
public function keywordSearchFilter(): array
{
    return [
        'fieldsToMatch' => [
            'FirstName' => 'PartialMatch',
            'LastName' => 'PartialMatch',
        ],
        'options' => [
            'title' => 'Search Exactly',
        ],
    ];
}
```

Fields To Match: `'[DBFieldName]' => '[MatchType]'`. If `MatchType` is not `PartialMatch`, Exact Match will be assumed.

Options:
- `title`: custom label

## Hide Default Filters

Sometimes we need to hide auto-generated filters, such as `$summary_fields` in `DataObject`. Add this function in model admin: 

```
/**
 * Hide default filters of data objects
 */
public function hideDefaultFilters(): bool
{
    return true;
}
```