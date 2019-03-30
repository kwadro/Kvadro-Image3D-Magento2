<?php
namespace Kvadro\Image3D\Model\ResourceModel\KvadroSetting;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Kvadro\Image3D\Model\ResourceModel\KvadroSetting
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'cappacity_setting_event';
    protected $_eventObject = 'cappacity_setting_object';

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\KvadroSetting', 'Kvadro\Image3D\Model\ResourceModel\KvadroSetting');

    }
}