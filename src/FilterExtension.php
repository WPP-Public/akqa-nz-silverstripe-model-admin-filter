<?php

namespace Heyday\ModelAdminFilter;

use SilverStripe\Core\Extension;
use Heyday\ModelAdminFilter\FilterType;

/**
 * ModelAdminFilter main extension
 */
class FilterExtension extends Extension
{
    /**
     * Add custom filters
     * 
     * @return \SilverStripe\ORM\Search\SearchContext
     */
    public function updateSearchContext($context)
    {
        $extraFilterFields = $this->owner->hasMethod('extraFilterFields') ? $this->owner->extraFilterFields() : [];

        foreach ($extraFilterFields as $field) {

            $fieldName = $field['fieldName'];

            switch ($field['fieldType']) {
                case 'dateRange':
                    $beginTitle = $field['options']['beginTitle'] ?? '';
                    $endTitle = $field['options']['endTitle'] ?? '';
                    $dateRangeField = FilterType::getDateRangeFilter($fieldName, $beginTitle, $endTitle);

                    $context->getFields()->push($dateRangeField['beginDate']);
                    $context->getFields()->push($dateRangeField['endDate']);

                    break;
            }
        }

        return $context;
    }

    /**
     * Returns array of filter params
     * 1. try to get params from filter state in request body
     * 2. try to get params from GridFieldFilterHeader state in request body
     * 3. try to get params from GridFieldFilterHeader state in request vars
     */
    public function getFilterParams(): array
    {
        $class = str_replace('\\', '-', $this->owner->modelClass); // Cannot call saniteseClassName from Model Admin since it's proteced method
        $body  = $this->owner->getRequest()->getBody();

        parse_str($body, $request);

        $params = [];

        // try to get params from filter state in request body
        if (isset($request['filter'][$class]) && is_array($request['filter'][$class])) {
            $params = $request['filter'][$class];
        }

        // try to get params from GridFieldFilterHeader state in request body
        if (empty($params) && isset($request[$class]['GridState']) && $request[$class]['GridState']) {
            $gridState = json_decode($request[$class]['GridState'], true);

            if (
                isset($gridState['GridFieldFilterHeader']['Columns'])
                && is_array($gridState['GridFieldFilterHeader']['Columns'])
            ) {
                $params = $gridState['GridFieldFilterHeader']['Columns'];
            }
        }

        // try to get params from GridFieldFilterHeader state in request vars
        if (empty($params) && $requestVar = $this->owner->getRequest()->requestVar($class)) {
            if (isset($requestVar['GridState']) && !empty($requestVar['GridState'])) {
                $gridState = json_decode($requestVar['GridState'], true);

                if (
                    isset($gridState['GridFieldFilterHeader']['Columns'])
                    && is_array($gridState['GridFieldFilterHeader']['Columns'])
                ) {
                    $params = $gridState['GridFieldFilterHeader']['Columns'];
                }
            }
        }

        return $params;
    }

    /**
     * {@inheritdoc}
     */
    public function getList()
    {
        $list = $this->owner->getList();

        // get search params
        $params = $this->getFilterParams();

        if ($params) {
            $list = $list->filter($params);
        }

        return $list;
    }
}
