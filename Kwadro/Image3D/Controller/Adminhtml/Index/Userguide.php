<?php

namespace Kvadro\Image3D\Controller\Adminhtml\Index;

/**
 * Class Userguide
 * @package Kvadro\Image3D\Controller\Index
 */
class Userguide extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Kvadro_Magento3D::userguide';
    /**
     * @var \Kvadro\Image3D\Helper\Data
     */
    protected $_kvadroHelper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Kvadro\Image3D\Helper\Data $KvadroHelper
    )
    {
        $this->_kvadroHelper = $KvadroHelper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $user_guide_url = $this->_kvadroHelper->getConfigValue('kvadroadmin/general/userguide_url');

        $this->_response->setRedirect($user_guide_url);
    }

}