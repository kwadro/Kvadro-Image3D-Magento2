<?php

namespace Kvadro\Image3D\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
//Todo: after change SDK uncomment
//use CappasitySDK\ClientFactory;
//use CappasitySDK\Client\Model\Request;
//use CappasitySDK\Client\Model\Response;
//use Kvadro\Image3D\Api\Data\KvadroDataInterface;
class Setting extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
    /**
     * @var \Kvadro\Image3D\Model\KvadroSettingFactory
     */
    private $settingFactory;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * Setting constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Kvadro\Image3D\Model\KvadroSettingFactory $settingFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Kvadro\Image3D\Model\KvadroSettingFactory $settingFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Kvadro\Image3D\Model\ResourceModel\KvadroSetting\CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->settingFactory = $settingFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|void
     */
    public function execute()
    {
        try {
            $resultPage = $this->resultPageFactory->create();
            $title = __('Kvadro 3D and 360 Product Viewer');
            $resultPage->getConfig()->getTitle()->prepend($title);
            return $resultPage;
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Kvadro_Magento3D::edit_kvadro_tech');
    }


}
