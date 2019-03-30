<?php
namespace Kvadro\Image3D\Api\Data;

interface KvadroImageParamsInterface
{
    const ENTITY_ID = 'entity_id';
    const DATA_AUTORUN = 'autoRun';
    const DATA_CLOSEBUTTON = 'closeButton';
    const DATA_ANALYTICS = 'analytics';
    const DATA_HIDEFULLSCREEN = 'hideFullScreen';

    const DATA_USER_ID = 'user_id';

    public function getEntityId();

    public function setEntityId($entityId);

    public function geAutoRun();

    public function seAutoRun($value);

    public function getCloseButton();

    public function setCloseButton($value);

    public function getAnalytics();

    public function setAnalytics($value);

    public function getHideFullScreen();

    public function setHideFullScreen($value);
}