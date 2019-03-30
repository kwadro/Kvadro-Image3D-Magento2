<?php

namespace Kvadro\Image3D\Controller\Adminhtml\Index;


class ResetDataSave extends \Magento\Backend\App\Action
{
    protected $_syncJob;
    protected $_syncData;
    protected $_setting;
    protected $_imageParams;
    protected $_syncJobParams;
    protected $_urlBuilder;
    protected $_messageManager;


    /** delete table synch job  and syncProducts  */
    public function __construct(
        \Kvadro\Image3D\Model\KvadroSyncJobParamsFactory $KvadroSyncJobParams,
        \Kvadro\Image3D\Model\KvadroImageParamsFactory $KvadroImageParams,
        \Kvadro\Image3D\Model\KvadroSettingFactory $KvadroSetting,
        \Kvadro\Image3D\Model\KvadroSyncJobFactory $KvadroSyncJob,
        \Kvadro\Image3D\Model\KvadroSyncDataFactory $KvadroSyncData,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_messageManager = $messageManager;
        $this->_syncJob = $KvadroSyncJob;
        $this->_syncData = $KvadroSyncData;
        $this->_syncJobParams = $KvadroSyncJobParams;
        $this->_imageParams = $KvadroImageParams;
        $this->_setting = $KvadroSetting;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context);
    }

    public function execute()
    {

        try {
            $this->clearData();
            $this->_messageManager->addSuccess(__('All data deleted success'));

        } catch (\Exception $e) {

            $this->_messageManager->addError(__('Error delete data-' . $e->getMessage()));

        }
        $url = $this->_urlBuilder->getUrl('kvadro/index/action');
        $this->_response->setRedirect($url);
    }

    protected function clearData()
    {

        $model = $this->_syncJob->create();
        $this->deleteTableyModel($model);

        $model = $this->_syncData->create();
        $this->deleteTableyModel($model);

        $model = $this->_setting->create();
        $this->deleteTableyModel($model);

        $model = $this->_imageParams->create();
        $this->deleteTableyModel($model);

        $model = $this->_syncJobParams->create();
        $this->deleteTableyModel($model);

    }

    protected function deleteTableyModel($model)
    {
        if($model->getResource()){
            $connection = $model->getResource()->getConnection();
            $tableName = $model->getResource()->getMainTable();
            $connection->truncateTable($tableName);
        }


    }
}