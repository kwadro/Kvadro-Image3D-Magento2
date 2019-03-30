<?php

namespace Kvadro\Image3D\Api\Data;

interface KvadroSyncJobInterface
{
    const ENTITY_ID = 'entity_id';
    const DATA_JOB_ID = 'job_id';
    const DATA_USER_ID= 'user_id';
    const DATA_UPDATE_AT = 'updated_at';
    const DATA_CREATE_AT = 'created_at';
    const DATA_STATUS = 'status';

    public function getEntityId();

    public function setEntityId($entityId);

    public function getUserId();

    public function setUserId($user_id);

    public function getJobId();

    public function setJobId($job_id);

    public function getCreateAt();

    public function setCreateAt($create_at);

    public function getUpdateAt();

    public function setUpdateAt($update_at);

    public function getStatus();

    public function setStatus($status);



}