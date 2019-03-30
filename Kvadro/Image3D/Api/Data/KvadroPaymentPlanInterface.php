<?php

namespace Kvadro\Image3D\Api\Data;

interface KvadroPaymentPlanInterface
{
    const ENTITY_ID = 'entity_id';
    const DATA_VALUE = 'value';
    const DATA_LABEL = 'label';


    public function getEntityId();

    public function setEntityId($entityId);

    public function getValue();

    public function setValue($value);

    public function getLabel();

    public function setLabel($label);


}