<?php

namespace Kvadro\Image3D\Model;

use Kvadro\Image3D\Api\Data\KvadroDataInterface;

class KvadroSetting extends \Magento\Framework\Model\AbstractModel implements KvadroDataInterface
{
    const CACHE_TAG = 'cappacity_setting_chache';
    protected $_cacheTag = 'cappacity_setting_chachetag';
    protected $_eventPrefix = 'cappacity_setting_event';

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\ResourceModel\KvadroSetting');
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function getToken()
    {
        return $this->getData(self::DATA_TOKEN);
    }

    public function setToken($token)
    {
        return $this->setData(self::DATA_TOKEN, $token);
    }


    public function getPlan()
    {
        return $this->getData(self::DATA_PLAN);
    }

    public function setPlan($plan)
    {
        return $this->setData(self::DATA_PLAN, $plan);
    }

    public function getAliases()
    {
        return $this->getData(self::DATA_ALIASES);
    }

    public function setAliases($aliases)
    {
        return $this->setData(self::DATA_ALIASES, $aliases);
    }

    public function getCreateAt()
    {
        return $this->getData(self::DATA_CREATE_AT);
    }

    public function setCreateAt($create_at)
    {
        return $this->setData(self::DATA_CREATE_AT, $create_at);
    }

    public function getUpdateAt()
    {
        return $this->getData(self::DATA_UPDATE_AT);
    }

    public function setUpdateAt($update_at)
    {
        return $this->setData(self::DATA_UPDATE_AT, $update_at);
    }

    public function getStatus()
    {
        return $this->getData(self::DATA_STATUS);
    }

    public function setStatus($status)
    {
        return $this->setData(self::DATA_UPDATE_AT, $status);
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function loadActiveUser()
    {
        $result = false;
        $collection = $this->getCollection()
            ->addFieldToFilter(KvadroDataInterface::DATA_STATUS, 1);
        if ($collection->getSize() > 0) {
            $result = $collection->getFirstItem();
        }
        return $result;

    }

    public function loadCurrentUser($userAlias)
    {
        $result = false;
        $collection = $this->getCollection()
            ->addFieldToFilter(KvadroDataInterface::DATA_ALIASES, $userAlias);
        if ($collection->getSize() > 0) {
            $result = $collection->getFirstItem()->getEntityId();
        }

        return $result;

    }
}