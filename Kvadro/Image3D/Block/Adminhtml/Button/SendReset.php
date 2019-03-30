<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 21.03.2019
 * Time: 23:39
 */

namespace Kvadro\Image3D\Block\Adminhtml\Button;

class SendReset extends \Magento\Backend\Block\Template
{
    protected $_template = '/button/send_reset.phtml';
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

    public function getResetDataUrl()
    {

        return $this->_urlBuilder->getUrl('kvadro/index/resetdatasave');

    }
}