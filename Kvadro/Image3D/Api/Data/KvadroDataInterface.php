<?php

namespace Kvadro\Image3D\Api\Data;

interface KvadroDataInterface
{
    const ENTITY_ID = 'entity_id';
    const DATA_TOKEN = 'token';
    const DATA_ALIASES = 'aliases';
    const DATA_PLAN = 'plan';
    const DATA_VIEW_PARAMS = 'view_params';
    const DATA_UPDATE_AT = 'updated_at';
    const DATA_CREATE_AT = 'created_at';
    const DATA_STATUS = 'status';

    public function getEntityId();

    public function setEntityId($entityId);

    public function getToken();

    public function setToken($token);

    public function getPlan();

    public function setPlan($plan);

    public function getAliases();

    public function setAliases($aliases);

    public function getCreateAt();

    public function setCreateAt($create_at);

    public function getUpdateAt();

    public function setUpdateAt($update_at);

    public function getStatus();

    public function setStatus($status);
}