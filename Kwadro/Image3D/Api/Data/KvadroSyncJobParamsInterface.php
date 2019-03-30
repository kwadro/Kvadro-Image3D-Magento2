<?php
namespace Kvadro\Image3D\Api\Data;

interface KvadroSyncJobParamsInterface
{
    const ENTITY_ID = 'entity_id';
    const DATA_AUTO_NEW_PRODUCT = 'auto_new_product';
    const DATA_UPDATE_MANUAL_CHOICES = 'update_manual_choices';
    const DATA_USE_THUMBNALL_OF_BUTTON = 'use_thumbnall_of_button';
    const DATA_ADD_PREVIEW_TO_GALLERY = 'add_preview_to_gallery';
    const DATA_SET_PREVIEW_BASE = 'set_preview_base';
    const DATA_USER_ID = 'user_id';

    public function getEntityId();

    public function setEntityId($entityId);

    public function geAutoNewProduct();

    public function seAutoNewProduct($value);

    public function getUpdateManualChoices();

    public function setUpdateManualChoices($value);

    public function getUseThumbnallOfButton();

    public function setUseThumbnallOfButton($value);

    public function getAddPreviewToGallery();

    public function setVagetAddPreviewToGallerylue($value);

    public function getSetPreviewBase();

    public function setSetPreviewBase($value);

    public function getUserId();

    public function setUserId($user_id);

}