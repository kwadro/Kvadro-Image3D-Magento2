<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 22.03.2019
 * Time: 12:33
 */

namespace Kvadro\Image3D\Controller\Result;

use CappasitySDK\ClientFactory;
use CappasitySDK\Client\Model\Request;
use CappasitySDK\Client\Model\Response;
use CappasitySDK\Client\Model\Callback\Process\JobsPushResultPos;
class SyncJobResultSave extends  \Magento\Framework\App\Action\Action
{
    public function __construct(
        \Kvadro\Image3D\Model\KvadroSyncDataFactory $KvadroSyncData,
        \Kvadro\Image3D\Model\KvadroSyncJobFactory $KvadroSyncJob,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Kvadro\Image3D\Helper\Data $KvadroHelper,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_logger = $logger ;
        $this->_request = $request;
        $this->_syncDataFactory = $KvadroSyncData;
        $this->_kvadroHelper = $KvadroHelper;
        $this->_messageManager = $messageManager;
        $this->_syncJobFactory = $KvadroSyncJob;
        parent::__construct($context);
    }
    public function execute()
    {
        try {
            //Todo: delete after
            $con = $this->_request->getContent();
            $con  = json_encode($con,true);
            $this->_logger->addNotice( $con );
            //Todo: delete after
            $par = $this->_request->getParams();
            $par_log  = json_encode($par,true);
            $this->_logger->addNotice( $par_log );

            $requestBody = $par;
            $result = JobsPushResultPost::fromCallbackBody($requestBody);


            //Todo: delete after
            $res =  json_encode($result,true);
            $this->_logger->addNotice( $res );

            if ($this->setStatusJobSync($result)) {
                $this->_messageManager->addSuccess(__('Response data save  success'));
            } else {
                $this->_messageManager->addSuccess(__('Response data don`t save '));
            }

        } catch (\Exception $e) {
            //Todo: delete after
            $this->_logger->addNotice( "error- ".$e->getmessage() );
            return false;
        }
        return true;
    }

    protected function setStatusJobSync($data)
    {
        $model = $this->_syncJobFactory->create();

        $jobId = $data['meta']['jobId'];

        $model->load($jobId);

        $current_data = $this->_kvadroHelper->getCurrentData();
        try {

            if ($this->saveResultDataJob($data,$jobId)) {
                $model->setStatus(2);
                $model->setUpdateAt($current_data);
                $model->save();
                return true;
            } else {
                $model->setUpdateAt($current_data);
                $model->setStatus(3);
                $model->save();
                return false;
            }
            $model->setUpdateAt($current_data);
            $model->setStatus(3);
            $model->save();

        } catch (\Exception $e) {
            $model->setStatus(3);
            $this->_messageManager->addError(__('Error delete data-' . $e->getMessage()));
            return false;
        }

        return true;

    }

    protected function saveResultDataJob($data,$jobId)

    {
        return $this-> _syncDataFactory->create()->saveResultData($data,$jobId);

    }


}
