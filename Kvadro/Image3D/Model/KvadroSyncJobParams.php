<?php

namespace Kvadro\Image3D\Model;

use Kvadro\Image3D\Api\Data\KvadroSyncJobParamsInterface;


class KvadroSyncJobParams extends \Magento\Framework\Model\AbstractModel implements KvadroSyncJobParamsInterface
{

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\ResourceModel\KvadroSyncJobParams');
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function getUserId()
    {
        return $this->getData(self::DATA_USER_ID);
    }

    public function setUserId($user_id)
    {
        return $this->setData(self::DATA_USER_ID, $user_id);
    }

    public function geAutoNewProduct() {
        return $this->getData(self::DATA_AUTO_NEW_PRODUCT);
    }

    public function seAutoNewProduct($value){
        return $this->setData(self::DATA_AUTO_NEW_PRODUCT, $value);
    }

    public function getUpdateManualChoices() {
        return $this->getData(self::DATA_UPDATE_MANUAL_CHOICES);
    }

    public function setUpdateManualChoices($value){
        return $this->setData(self::DATA_UPDATE_MANUAL_CHOICES, $value);
    }

    public function getUseThumbnallOfButton() {
        return $this->getData(self::DATA_USE_THUMBNALL_OF_BUTTON);
    }

    public function setUseThumbnallOfButton($value){
        return $this->setData(self::DATA_USE_THUMBNALL_OF_BUTTON, $value);
    }


    public function getAddPreviewToGallery() {
        return $this->getData(self::DATA_ADD_PREVIEW_TO_GALLERY);
    }

    public function setVagetAddPreviewToGallerylue($value){
        return $this->setData(self::DATA_ADD_PREVIEW_TO_GALLERY, $value);
    }


    public function getSetPreviewBase() {
        return $this->getData(self::DATA_SET_PREVIEW_BASE);
    }

    public function setSetPreviewBase($value){
        return $this->setData(self::DATA_SET_PREVIEW_BASE, $value);
    }

    public function loadByUserId($userId)
    {
       return $this->load($userId,self::DATA_USER_ID);
    }


}