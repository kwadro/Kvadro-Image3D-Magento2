<?php

namespace Kvadro\Image3D\Model\ResourceModel\KvadroParamsRule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Kvadro\Image3D\Model\ResourceModel\KvadroParamsRule
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'cappacity_rule_event';
    protected $_eventObject = 'cappacity_rule_object';

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\KvadroParamsRule', 'Kvadro\Image3D\Model\ResourceModel\KvadroParamsRule');

    }
}