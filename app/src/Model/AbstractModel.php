<?php

namespace Mock\Api\Model;

use Pop\Db\Parser\Predicate;

abstract class AbstractModel extends \Pop\Model\AbstractModel
{

    /**
     * Search fields to select
     * @var array
     */
    protected $searchFields = [];

    /**
     * Method to get search fields
     *
     * @param  mixed $fields
     * @return array
     */
    public function getSearchFields($fields = null)
    {
        if (!empty($fields) && !is_array($fields)) {
            $fields = (strpos($fields, ',') !== false) ? explode(',', $fields) : [$fields];
        }

        return (!empty($fields)) ?
            array_diff($this->searchFields, array_diff($this->searchFields, $fields)) : $this->searchFields;
    }

    /**
     * Method to get filter
     *
     * @param  mixed  $filter
     * @return array
     */
    public function getFilter($filter)
    {
        return Predicate::convertToArray($filter);
    }

}
