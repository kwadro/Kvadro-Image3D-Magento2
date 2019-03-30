<?php

namespace Kvadro\Image3D\Block\Adminhtml\Button;

class SendSynchronize extends \Magento\Backend\Block\Template
{
    protected $_template = '/button/send_synchronize.phtml';

    public $_urlBuilder;

    protected $_syncSettingFactory;

    protected $_syncJobFactory;

    private $user=null;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Kvadro\Image3D\Model\KvadroSyncJobFactory $KvadroSyncJob,
        \Kvadro\Image3D\Model\KvadroSettingFactory $KvadroSettingFactory,
        array $data = []
    )
    {
        $this->_syncSettingFactory = $KvadroSettingFactory;
        $this->_syncJobFactory = $KvadroSyncJob;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    public function getActiveUser()
    {
        if (empty($this->user)) {
            $this->user = $this->_syncSettingFactory->create()->loadActiveUser();
        }
        return $this->user;

    }

    public function getActiveToken()
    {
       return $this->getActiveUser()->getToken();
    }

    public function loadActiveSyncJob()
    {
        $activeJob = $this->_syncJobFactory->create()->loadActiveSyncJob($this->getActiveUser());
        if (!$activeJob) {
            return false;
        }
        return true;
    }

    public function getSendDataUrl()
    {
        return $this->_urlBuilder->getUrl('kvadro/index/syncjobdatasave');
    }
}