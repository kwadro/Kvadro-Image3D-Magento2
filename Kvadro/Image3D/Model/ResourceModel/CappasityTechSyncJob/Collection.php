<?php
namespace Kvadro\Image3D\Model\ResourceModel\KvadroSyncJob;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Kvadro\Image3D\Model\ResourceModel\KvadroSetting
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\KvadroSyncJob', 'Kvadro\Image3D\Model\ResourceModel\KvadroSyncJob');

    }
}