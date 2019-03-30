<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 22.03.2019
 * Time: 23:24
 */

namespace Kvadro\Image3D\Block\Adminhtml\Button;

class SaveSynchrinize extends \Magento\Backend\Block\Template
{
    protected $_template = '/button/save_synchronize.phtml';
    public $_urlBuilder;
    public $_syncSettingFactory;
    private $user;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Kvadro\Image3D\Model\KvadroSettingFactory $KvadroSettingFactory,
        array $data = []
    )
    {
        $this->_syncSettingFactory = $KvadroSettingFactory;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    public function getSendDataUrl()
    {

        return $this->_urlBuilder->getUrl('kvadro/index/syncjobparamssave');

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
}