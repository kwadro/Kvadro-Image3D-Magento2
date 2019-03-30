<?php

namespace Kvadro\Image3D\Controller\Adminhtml\Index;

use \Magento\Framework\Controller\ResultFactory;

class SyncJobParamsSave extends \Magento\Backend\App\Action
{
    protected $_urlBuilder;
    protected $_kvadroHelper;
    protected $_syncJobParamsFactory;

    public function __construct(
        \Kvadro\Image3D\Model\KvadroSyncJobParamsFactory $KvadroSyncJobParamsfactory,
        \Kvadro\Image3D\Helper\Data $KvadroHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_kvadroHelper = $KvadroHelper;
        $this->_syncJobParamsFactory = $KvadroSyncJobParamsfactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $responseData = [];

            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

            if (!$this->getRequest()->getPostValue()) {

                $responseData['status'] = 'error';

                $responseData['message'] = __('Save error.Data is  empty');

                $resultJson->setData($responseData);

                return $resultJson;

            }

            $postData = $this->getRequest()->getPostValue();

            $modelJobParams = $this->_syncJobParamsFactory->create();

            $activeUser = $this->_kvadroHelper->getActiveUser();

            $params = $modelJobParams->loadByUserId($activeUser->getEntityId());

            if (!$params->getEntityId()) {

                $params = $this->_syncJobParamsFactory->create();
                $params->setUserId($activeUser->getEntityId());
                $params->setEntityId($activeUser->getEntityId());
            }

            foreach ($postData as $key => $value) {

                $params->setData(trim($key), (int)$value);

            }

            $params->save();

            $responseData['status'] = 'success';

            $responseData['message'] = __('Save data success');

            $resultJson->setData($responseData);

            return $resultJson;

        } catch (\Exception $e) {

            $responseData['status'] = 'success';

            $responseData['message'] = __('Error save  data-') . $e->getMessage();

            $resultJson->setData($responseData);

            return $resultJson;
        }

    }

}