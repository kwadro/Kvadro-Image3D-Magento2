<?php

namespace Kvadro\Image3D\Block\Adminhtml\Edit;

class AdvanceSetting extends \Magento\Backend\Block\Template
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Kvadro\Image3D\Model\KvadroSettingFactory $settingFactory,
        array $data = []

    )
    {
        $this->_settingFactory = $settingFactory;
        parent::__construct($context, $data);
    }

    public function loadActiveUser()
    {
        return $this->_settingFactory->create()->loadActiveUser();
    }
}