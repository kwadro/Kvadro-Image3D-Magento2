<?php

namespace Kvadro\Image3D\Model\ResourceModel;

/**
 * Class KvadroSetting
 * @package Kvadro\Image3D\Model\ResoucreModel
 */
class KvadroSetting extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Store\Block\Switcher $Switcher,
        \Psr\Log\LoggerInterface $logger,
        $resourcePrefix = null
    )
    {
        parent::__construct($context, $resourcePrefix);
        $this->_switcher = $Switcher;
        $this->logger = $logger;
    }

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init('kvadro_tech_kvadro3D_user', 'entity_id');
    }
}