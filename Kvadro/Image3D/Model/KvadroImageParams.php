<?php

namespace Kvadro\Image3D\Model;

use Kvadro\Image3D\Api\Data\KvadroImageParamsInterface;


class KvadroImageParams extends \Magento\Framework\Model\AbstractModel implements KvadroImageParamsInterface
{

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\ResourceModel\KvadroImageParams');
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function geAutoRun(){
        return $this->getData(self::ENTITY_ID);
    }

    public function seAutoRun($value) {
        return $this->setData(self::ENTITY_ID, $value);
    }

    public function getCloseButton(){
        return $this->getData(self::ENTITY_ID);
    }

    public function setCloseButton($value) {
        return $this->setData(self::ENTITY_ID, $value);
    }

    public function getAnalytics(){
        return $this->getData(self::ENTITY_ID);
    }

    public function setAnalytics($value) {
        return $this->setData(self::ENTITY_ID, $value);
    }

    public function getHideFullScreen(){
        return $this->getData(self::ENTITY_ID);
    }

    public function setHideFullScreen($value) {
        return $this->setData(self::ENTITY_ID, $value);
    }




}