<?php

namespace Kvadro\Image3D\Model;

use Kvadro\Image3D\Api\Data\KvadroParamsRuleInterface;

class KvadroParamsRule extends \Magento\Framework\Model\AbstractModel implements KvadroParamsRuleInterface
{

    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\ResourceModel\KvadroParamsRule');
    }

    public function getEntityId(){
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId){
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function getName(){
        return $this->getData(self::DATA_NAME);
    }

    public function setName($name){
        return $this->setData(self::DATA_NAME, $name);
    }

    public function getType(){
        return $this->getData(self::DATA_TYPE);
    }

    public function setType($type){
        return $this->setData(self::DATA_TYPE, $type);
    }

    public function getDefaultValue(){
        return $this->getData(self::DATA_DEFAULT_VALUE);
    }

    public function setDefaultValue($default_value){
        return $this->setData(self::DATA_DEFAULT_VALUE, $default_value);
    }

    public function getRegPlanLevel(){
        return $this->getData(self::DATA_REG_PLAN_LEVEL);
    }

    public function setRegPlanLevel($get_reg_plan_level){
        return $this->setData(self::DATA_REG_PLAN_LEVEL, $get_reg_plan_level);
    }

    public function getPaid(){
        return $this->getData(self::DATA_PAID);
    }

    public function setPaid($paid){
        return $this->setData(self::DATA_PAID, $paid);
    }

    public function getLabel(){
        return $this->getData(self::DATA_LABEL);
    }

    public function setLabel($label){
        return $this->setData(self::DATA_LABEL, $label);
    }

    public function getDescription(){
        return $this->getData(self::DATA_DESCRIPTION);
    }

    public function setDescription($description){
        return $this->setData(self::DATA_DESCRIPTION, $description);
    }






}