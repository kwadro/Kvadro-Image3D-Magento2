<?php

namespace Kvadro\Image3D\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    CONST CAll_BACK_URL = "kvadroadmin/result/syncjobresultsave";
    CONST SAVE_JOB_DEFAULT_PARAMS = "kvadroadmin/general/savejobparams";
    CONST BASE_HTUMBNALL = "images/thunbnal-3D.png";

    protected $scopeConfig;
    protected $_date;
    protected $_settingFactory;
    protected $_store;
    protected $_productCollectionFactory;
    protected static $_instance;

    public function __construct(
        Context $context,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Kvadro\Image3D\Model\KvadroSettingFactory $settingFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productFactory
    )
    {
        $this->_productCollectionFactory = $productFactory;
        $this->_settingFactory = $settingFactory;
        $this->_store = $storeManager;
        $this->_date = $timezone;
        $this->scopeConfig = $context->getScopeConfig();

        parent::__construct($context);

        self::$_instance = $this;
    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof \Magento\Framework\App\Helper\AbstractHelper) {
            throw new \RuntimeException('Data isn\'t initialized');
        }
        return self::$_instance;
    }

    public function getBaseThumbnall()
    {
        return self::BASE_HTUMBNALL;
    }

    public function getCurrentDate()
    {
        date_default_timezone_set(
            $this->_date->getConfigTimezone('store', $this->_store->getStore())
        );
        $date = $this->_date->date();
        $current_date = $date->format('Y/m/d H:i:s');
        return $current_date;
    }

    public function getActiveUser()
    {
        return $this->_settingFactory->create()->loadActiveUser();
    }

    public function getProductsData()
    {
        $result = false;
        $collection = $this->_productCollectionFactory->create();
        if ($collection->getSize() > 0) {
            $result = $collection->getItems();
        }
        return $result;
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getDefaulSaveJobParams($storeId = null)
    {
        $result = $this->getConfigValue(self::SAVE_JOB_DEFAULT_PARAMS, $storeId);
        return json_decode($result, true);
    }

    public function getBaseUrl()
    {
        return $this->_store->getStore()->getBaseUrl();
    }

    public function getCallBackUrl()
    {
        return $this->getBaseUrl() . self::CAll_BACK_URL;
    }
}