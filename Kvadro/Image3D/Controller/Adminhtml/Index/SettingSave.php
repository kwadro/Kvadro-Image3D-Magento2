<?php

namespace Kvadro\Image3D\Controller\Adminhtml\Index;

use CappasitySDK\Client\Model\Request;
use CappasitySDK\ClientFactory;
use Kvadro\Image3D\Api\Data\KvadroDataInterface;

class SettingSave extends \Magento\Backend\App\Action
{
    const TEST_API_TOKEN = '6496141956559667200.da0848f7-a6bd-445f-81a5-9d2e533a6bf8.PrutyD14_Gs6RTumVjOx0Sbwif588ryFZTfUPEPPh_I';

    protected $_date;
    protected $coreRegistry;
    protected $settingFactory;
    protected $paymentPlanFactory;
    protected $_kvadroHelper;
    protected $_messageManager;
    protected $_store;
    protected $jobParamsFactory;
    protected $imageParamsFactory;
    protected $paramsRuleFactory;

    public function __construct(
        \Kvadro\Image3D\Helper\Data $KvadroHelper,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Kvadro\Image3D\Model\KvadroParamsRuleFactory $KvadroParamsRuleFactory,
        \Kvadro\Image3D\Model\KvadroSyncJobParamsFactory $KvadroSyncJobParamsFactory,
        \Kvadro\Image3D\Model\KvadroImageParamsFactory $KvadroImageParamsFactory,
        \Kvadro\Image3D\Model\KvadroPaymentPlanFactory $PaymentPlanFactory,
        \Kvadro\Image3D\Model\KvadroSettingFactory $settingFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->settingFactory = $settingFactory;
        $this->paramsRuleFactory = $KvadroParamsRuleFactory;
        $this->jobParamsFactory = $KvadroSyncJobParamsFactory;
        $this->imageParamsFactory = $KvadroImageParamsFactory;
        $this->paymentPlanFactory = $PaymentPlanFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_messageManager = $messageManager;
        $this->_kvadroHelper = $KvadroHelper;
        $this->_store = $storeManager;
    }

    public function execute()
    {
        try {
            $token = $this->getRequest()->getParam('token', false);
            if (!$token) {
                $token = self::TEST_API_TOKEN;
            }
            $client = ClientFactory::getClientInstance([
                'apiToken' => $token
            ]);
            $currentUser = false;
            $current_date = $this->_kvadroHelper->getCurrentDate();

            if (!$client) {
                $this->_messageManager->addError(__('Pleasee input correct token'));
                $this->_redirect('kvadro/index/action');
            } else {
                $response = $client->getUser(new Request\Users\MeGet())
                    ->getBodyData();
                $user = $response
                    ->getData()
                    ->getAttributes();
                // get user plan
                $plan = $user->getPlan();
                $code_plan = $this->paymentPlanFactory->create()->getCodePlanByLabel($plan);
                // get user alias
                $userAlias = $user->getAlias();

                //$code_plan = 1;
                //$userAlias = 'test';
                $model = $this->settingFactory->create();

                $activeUser = $model->loadActiveUser();

                if ($activeUser) {
                    $activeUser = $model->load($activeUser->getentityid());
                    if (trim($activeUser->getAliases()) !== $userAlias) {
                        //deactivate old user
                        $activeUser->setData(KvadroDataInterface::DATA_STATUS, 0);

                        $activeUser->save();
                    } else {
                        $currentUser = $activeUser;
                        $currentUser->setData(KvadroDataInterface::DATA_TOKEN, $token);
                        $currentUser->setData(KvadroDataInterface::DATA_UPDATE_AT, $current_date);
                    }
                }

                if (!$currentUser) {
                    $currentUserId = $model->loadCurrentUser($userAlias);
                    if ($currentUserId) {
                        $currentUser = $model->load($currentUserId);
                        $old_plan = $currentUser->getPlan();
                        if ($old_plan !== $code_plan) {
                            $this->_messageManager->addSuccess(__('Your plan is chanched. Current plan :') . __(strtoupper($plan)));
                        }
                        $currentUser->setData(KvadroDataInterface::DATA_UPDATE_AT, $current_date);
                    } else {
                        $currentUser = $this->settingFactory->create();
                        $currentUser->setData(KvadroDataInterface::DATA_CREATE_AT, $current_date);
                        $currentUser->setData(KvadroDataInterface::DATA_ALIASES, $userAlias);
                    }
                    $currentUser->setData(KvadroDataInterface::DATA_TOKEN, $token);
                    $currentUser->setData(KvadroDataInterface::DATA_STATUS, 1);
                }

                $currentUser->setData(KvadroDataInterface::DATA_PLAN, $code_plan);
                $currentUser->save();

                $this->setUserParamsJob($currentUser);

                $this->setUserParamsImage($currentUser);

                $this->coreRegistry->register('KvadroUserId', $currentUser->getEntityId());
                if ($code_plan !== 30) {
                    $this->_messageManager->addNotice(__('Please update your plan'));
                }
            }

            $this->_redirect('kvadro/index/action');
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    protected function setUserParamsJob($user)
    {
        $user_id = $user->getEntityId();
        $params = $this->jobParamsFactory->create()->load((int)$user_id, "user_id");

        if (!$params->getEntityId()) {
            $params = $this->jobParamsFactory->create();
            $params->setEntityId($user_id);
        }
        $default_params = $this->_kvadroHelper->getDefaulSaveJobParams();
        $params->setUserId((int)$user_id);
        foreach ($default_params as $key => $value) {
            $params->setData(trim($key), (int)$value);
        }
        $params->save();
    }

    protected function setUserParamsImage($user)
    {
        $plan = $user->getPlan();
        $user_id = $user->getentityId();
        $default_params = $this->getImageParamsByPlan($plan);

        $params = $this->imageParamsFactory->create()->load((int)$user_id);
        if (!$params->getEntityId()) {
            $params = $this->imageParamsFactory->create();
            $params->setEntityId($user_id);
        }

        foreach ($default_params as $key => $value) {
            $params->setData(trim($key), (int)$value);
        }

        $params->setEntityId($user_id);

        $params->save();
    }

    protected function getImageParamsByPlan($current_plan)
    {
        $result = [];
        $rules = $this->paramsRuleFactory->create()->getCollection();
        foreach ($rules as $rule) {
            $access = false;
            if ($rule->getPaid()) {
                if ($current_plan >= $rule->getRegPlanLevel()) {
                    $access = true;
                }
            } else {
                $access = true;
            }
            if ($access) {
                $v = $rule->getDefaultValue();

                if ($v === "TRUE") {
                    $v = 2;
                }
                if ($v === "FALSE") {
                    $v = 1;
                }

                $result[trim($rule->getName())] = $v;
            }
        }
        return $result;
    }
}
