<?php

namespace Kvadro\Image3D\Model;

use Kvadro\Image3D\Api\Data\KvadroSyncDataInterface;
use Kvadro\Image3D\Helper\Data as KvadroHelper;

class KvadroSyncData extends \Magento\Framework\Model\AbstractModel implements KvadroSyncDataInterface
{
    CONST RESOURCE_SYNCHRONIZATION = "sync";
    CONST BASE_IFRAME_URL = "";

    protected function _construct()
    {

        $this->_init('Kvadro\Image3D\Model\ResourceModel\KvadroSyncData');
    }
    public function getProductImage3D($product_id)
    {
        return $this->load($product_id,KvadroSyncDataInterface::DATA_PRODUCT_ID);
    }
    public function saveResultData($data, $jobId)
    {
        try {
            $items = $this->ReplaceDataImage($data);

            $kvadroHelper=KvadroHelper::getInstance();

            $current_date = $kvadroHelper->getCurrentDate();

            $thumbnall = $kvadroHelper->getBaseThumbnall();

            foreach ($items as $item) {
                $image3D = $item['uploadId'];
                $product_id=(int)$item['id'];

                $imageObject = $this->load($product_id, KvadroSyncDataInterface::DATA_PRODUCT_ID);

                if ($imageObject->getId()) {
                    // do not save
                    if (!$imageObject->getImage3d() == $image3D) {
                        //continue;
                    }

                    //Todo:add logic custom data update
                    if (!$imageObject->getSyncResource() == self::RESOURCE_SYNCHRONIZATION) {
                        //continue;
                    }
                    $imageObject->setUpdateAt($current_date);
                } else {
                    $imageObject = $this;
                    $imageObject->setCreateAt($current_date);
                    $imageObject->setProductId($product_id);
                }

                $imageObject->setImage3d($image3D);

                $params = [
                    'autorun' => 0,
                    'closebutton' => 1,
                    'logo' => 1,
                    'autorotate' => 0,
                    'autorotatetime' => 10,
                    'autorotatedelay' => 2,
                    'autorotatedir' => 1,
                    'hidefullscreen' => 1,
                    'hideautorotateopt' => 1,
                    'hidesettingsbtn' => 0,
                    'enableimagezoom' => 1,
                    'zoomquality' => 1,
                    'hidezoomopt' => 0,
                ];
                $query_string = http_build_query($params);
                $image3D_url = self::BASE_IFRAME_URL . $image3D .'/embedded?' .$query_string;
                $imageObject->setUrl3d($image3D_url);
                $imageObject->setJobId($jobId);
                $imageObject->setSyncResource(self::RESOURCE_SYNCHRONIZATION);
                $imageObject->setThumbnall3d($thumbnall);

                $imageObject->save();
            }
            $result = TRUE;
        } catch (\Exception $e) {
            $result = FALSE;
        }
        return $result;
    }

    protected function ReplaceDataImage($data)
    {
       //TODO: after change
        return $data;
    }


    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function getProductId()
    {
        return $this->getData(self::DATA_PRODUCT_ID);
    }

    public function setProductId($product_id)
    {
        return $this->setData(self::DATA_PRODUCT_ID, $product_id);
    }

    public function getImage3d()
    {
        return $this->getData(self::DATA_IMAGE_CODE_3D);
    }

    public function setImage3d($image_3d)
    {
        return $this->setData(self::DATA_IMAGE_CODE_3D, $image_3d);
    }

    public function getUrl3d()
    {
        return $this->getData(self::DATA_IMAGE_URL_3D);
    }

    public function setUrl3d($url_3d)
    {
        return $this->setData(self::DATA_IMAGE_URL_3D, $url_3d);
    }

    public function getThumbnall3d()
    {
        return $this->getData(self::DATA_THUMBNALL_3D);
    }

    public function setThumbnall3d($thumbnall_3d)
    {
        return $this->setData(self::DATA_THUMBNALL_3D, $thumbnall_3d);
    }

    public function getSyncResource()
    {
        return $this->getData(self::DATA_RESOURCE);
    }

    public function setSyncResource($resource)
    {
        return $this->setData(self::DATA_RESOURCE, $resource);
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