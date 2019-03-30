<?php

namespace Kvadro\Image3D\Controller\Adminhtml\Index;

use CappasitySDK\Client\Model\Request;
use CappasitySDK\ClientFactory;

class SyncJobDataSave extends \Magento\Backend\App\Action
{
    protected $_syncJobFactory;
    protected $_urlBuilder;
    protected $_messageManagerr;
    protected $_kvadroHelper;

    /** delete table synch job  and syncProducts  */
    public function __construct(
        \Kvadro\Image3D\Model\KvadroSyncJobFactory $KvadroSyncJob,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Kvadro\Image3D\Helper\Data $KvadroHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_kvadroHelper = $KvadroHelper;
        $this->_messageManager = $messageManager;
        $this->_syncJobFactory = $KvadroSyncJob;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $token = $this->getRequest()->getParam('token', false);
            $active_user = $this->_kvadroHelper->getActiveUser();
            if (!$active_user || $token !== trim($active_user->getToken())) {
                $this->_messageManager->addError(__('Please input correct token for activation functional plugin'));
                $url = $this->_urlBuilder->getUrl('kvadro/index/setting');
                $this->_response->setRedirect($url);
            }

            $url = $this->_urlBuilder->getUrl(
                'kvadro/index/setting',
                ['entity_id' => $active_user->getEntityId()]
            );

            //check  isset jobs Todo: ? delete  this check
            if ($this->_syncJobFactory->create()->loadActiveSyncJob($active_user)) {
                $this->_messageManager->addError(__('Sorry, the previous task is not finished'));
                $this->_response->setRedirect($url);
                return false;
            }
            // send request
            $job_id = $this->sendRequstSyncJob($active_user);
            if ($job_id == 0) {
                $this->_messageManager->addError(__('Sorry, empty data for sinchronization. Add products in your Store'));
                $this->_response->setRedirect($url);
                return false;
            }
            $this->saveData($job_id, $active_user->getEntityId());

            $this->_messageManager->addSuccess(__('Request synchronization send success'));
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
            $this->_messageManager->addError(__('Error delete data-' . $e->getMessage()));
        }
        $this->_response->setRedirect($url);
    }

    protected function saveData($job_id, $user_id)
    {
        $current_date = $this->_kvadroHelper->getCurrentDate();
        $model = $this->_syncJobFactory->create();
        $model->setJobId($job_id);
        $model->setUserId($user_id);
        // status 1-sending 2-close(save data success) 3-error(savedata_error);
        $model->setStatus(1);
        $model->setCreateAt($current_date);
        $model->save();
    }

    protected function sendRequstSyncJob($active_user)
    {
        $callbackUrl = $this->_kvadroHelper->getCallBackUrl();

        // get all id active products
        $items = $this->_kvadroHelper->getProductsData();

        // do not products for request
        if (!$items) {
            return 0;
        }

        $collectedItems = [];

        foreach ($items as $item) {
            $collectedItems[] = ['id' => $item->getId(),
                'aliases' => [$item->getSku()]
            ];
        }

        //Todo: capp ????
        var_dump($collectedItems);//exit;

        $token = $active_user->getToken();
        // Todo:  after correct sdk uncomment
        $client = ClientFactory::getClientInstance([
            'apiToken' => $token,
            'sendReports' => true,
        ]);
        //Todo : error in SDK with updated last version
        //Client error: `POST https://api.kvadro.com/api/cp/jobs/register/sync` resulted in a `400 Bad Request` response: {"statusCode":400,"error":"Bad Request","message":"jobs.register.sync validation failed: data.data[0].attributes.capp sh (truncated...)

        $job_id = $client->registerSyncJob(
            Request\Process\JobsRegisterSyncPost::fromData(
            $collectedItems,
            "push.http",
            $callbackUrl
          )
        )
            ->getBodyData()
            ->getId();
        var_dump($job_id);

        return $job_id;
    }
}
