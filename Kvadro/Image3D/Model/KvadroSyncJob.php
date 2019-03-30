<?php

namespace Kvadro\Image3D\Model;

use Kvadro\Image3D\Api\Data\KvadroSyncJobInterface;


class KvadroSyncJob extends \Magento\Framework\Model\AbstractModel implements KvadroSyncJobInterface
{

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\ResourceModel\KvadroSyncJob');
    }

    public function loadActiveSyncJob($active_user)
    {

        if (!$active_user->getEntityId()) return false;
        $collection=$this->getCollection();
        // check status==1(sended) for user_id
        $collection->addFieldToFilter(KvadroSyncJobInterface::DATA_USER_ID,$active_user->getEntityId() );
        $collection->addFieldToFilter(KvadroSyncJobInterface::DATA_STATUS,1);
        if ($collection->getSize()>0){
            return $collection->getItems();
        }
        return false;

    }


    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }


    public function getStatus()
    {
        return $this->getData(self::DATA_STATUS);
    }

    public function setStatus($status)
    {
        return $this->setData(self::DATA_STATUS, $status);
    }

    public function getUserId()
    {
        return $this->getData(self::DATA_USER_ID);
    }

    public function setUserId($user_id)
    {
        return $this->setData(self::DATA_USER_ID, $user_id);
    }


    public function getJobId()
    {
        return $this->getData(self::DATA_JOB_ID);
    }

    public function setJobId($job_id)
    {
        return $this->setData(self::DATA_JOB_ID, $job_id);
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

}