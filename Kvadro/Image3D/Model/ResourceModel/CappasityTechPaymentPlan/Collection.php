<?php

namespace Kvadro\Image3D\Model\ResourceModel\KvadroPaymentPlan;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Kvadro\Image3D\Model\ResourceModel\KvadroPaymentPlan
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'cappacity_plan_event';
    protected $_eventObject = 'cappacity_plan_object';

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\KvadroPaymentPlan', 'Kvadro\Image3D\Model\ResourceModel\KvadroPaymentPlan');

    }
}