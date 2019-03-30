<?php
namespace Kvadro\Image3D\Model\ResourceModel\KvadroSyncData;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\KvadroSyncData', 'Kvadro\Image3D\Model\ResourceModel\KvadroSyncData');

    }
}