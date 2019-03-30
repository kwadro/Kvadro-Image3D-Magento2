<?php

namespace Kvadro\Image3D\Block\Adminhtml\Button;


class SendToken extends \Magento\Backend\Block\Template
{
    protected $_template = '/button/send_token.phtml';
    public $_urlBuilder;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $data = []

    )
    {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    public function getSendDataUrl()
    {

        return $this->_urlBuilder->getUrl('kvadro/index/settingsave');

    }
}