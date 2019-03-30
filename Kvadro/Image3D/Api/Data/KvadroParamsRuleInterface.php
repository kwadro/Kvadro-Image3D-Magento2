<?php

namespace Kvadro\Image3D\Api\Data;

interface KvadroParamsRuleInterface
{
    const ENTITY_ID = 'entity_id';
    const DATA_NAME = 'name';
    const DATA_TYPE = 'type';
    const DATA_DEFAULT_VALUE = 'default_value';
    const DATA_REG_PLAN_LEVEL = 'req_plan_level';
    const DATA_PAID = 'paid';
    const DATA_DESCRIPTION = 'description';
    const DATA_LABEL = 'label';


    public function getEntityId();

    public function setEntityId($entityId);

    public function getName();

    public function setName($name);

    public function getType();

    public function setType($type);

    public function getDefaultValue();

    public function setDefaultValue($default_value);

    public function getRegPlanLevel();

    public function setRegPlanLevel($get_reg_plan_level);

    public function getPaid();

    public function setPaid($paid);

    public function getLabel();

    public function setLabel($label);

    public function getDescription();

    public function setDescription($description);
}