<?php

namespace Kvadro\Image3D\Api\Data;

interface KvadroSyncDataInterface
{
    const ENTITY_ID = 'entity_id';
    const DATA_PRODUCT_ID = 'product_id';
    const DATA_IMAGE_CODE_3D = 'image_3d';
    const DATA_IMAGE_URL_3D = 'url_3d';
    const DATA_THUMBNALL_3D = 'thumbnall_3d';
    const DATA_UPDATE_AT = 'updated_at';
    const DATA_CREATE_AT = 'created_at';
    const DATA_RESOURCE = 'resource';
    const DATA_JOB_ID = 'job_id';

    public function getEntityId();

    public function setEntityId($entityId);

    public function getProductId();

    public function setProductId($product_id);

    public function getImage3d();

    public function setImage3d($image_3d);

    public function getUrl3d();

    public function setUrl3d($url_3d);

    public function getThumbnall3d();

    public function setThumbnall3d($thumbnall_3d);

    public function getSyncResource();

    public function setSyncResource($resource);

    public function getJobId();

    public function setJobId($job_id);

    public function getCreateAt();

    public function setCreateAt($create_at);

    public function getUpdateAt();

    public function setUpdateAt($update_at);
}