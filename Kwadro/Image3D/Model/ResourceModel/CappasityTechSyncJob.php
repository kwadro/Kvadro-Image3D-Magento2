<?php

namespace Kvadro\Image3D\Model\ResourceModel;

class KvadroSyncJob extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $resourcePrefix = null
    )
    {
        parent::__construct($context, $resourcePrefix);
    }

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init('kvadro_tech_kvadro3D_sync_job', 'entity_id');
    }
}
