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
                'fieldType' => 'dateRange',
                'options' => [
                    'beginTitle' => 'Create Date Begin',
                    'endTitle' => 'Create Date End'
                ]
            ]
        ];
    }
    ```

    The example above will add custom filter of `dateRange` which is a date range filter of `Created` field.
    This filter will display record where `Created` dates are between selected range.

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
        'beginTitle' => 'Create Date Begin',
        'endTitle' => 'Create Date End'
    ]
]
```

Options:
- `beginTitle`: custom begin label
- `endTitle`: custom end label