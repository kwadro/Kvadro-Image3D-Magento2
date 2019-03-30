<?php
namespace Kvadro\Image3D\Controller\Adminhtml\Index;

class Action extends \Magento\Backend\App\Action
{
    protected $_urlBuilder;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Kvadro\Image3D\Model\KvadroSettingFactory $settingFactory,
        \Kvadro\Image3D\Model\ResourceModel\KvadroSetting\CollectionFactory $settingCollectionFactory
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->settingCollectionFactory = $settingCollectionFactory;
        $this->settingFactory = $settingFactory;
        $this->_urlBuilder = $urlBuilder;
    }

    public function execute()
    {
        $current_user_id = $this->coreRegistry->registry('KvadroUserId');

        if (!$current_user_id) {
            $settingModel = $this->settingFactory->create();
            $current_user = $settingModel->loadActiveUser();
               if($current_user){

                   $current_user_id=$current_user->getEntityId();
                   $this->coreRegistry->register('KvadroUserId', $current_user_id);
               }

        }

        if ($current_user_id) {
            $url = $this->_urlBuilder->getUrl(
                'kvadro/index/setting',
                ['entity_id' => $current_user_id]
            );
        } else {
            $url = $this->_urlBuilder->getUrl('kvadro/index/setting');
        }

        $this->_response->setRedirect($url);
    }

}