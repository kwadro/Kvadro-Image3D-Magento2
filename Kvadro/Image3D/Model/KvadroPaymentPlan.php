<?php

namespace Kvadro\Image3D\Model;

use Kvadro\Image3D\Api\Data\KvadroPaymentPlanInterface;

class KvadroPaymentPlan extends \Magento\Framework\Model\AbstractModel implements KvadroPaymentPlanInterface
{
    protected function _construct()
    {
        $this->_init('Kvadro\Image3D\Model\ResourceModel\KvadroPaymentPlan');
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function getValue()
    {
        return $this->getData(self::DATA_VALUE);
    }

    public function setValue($value)
    {
        return $this->setData(self::DATA_VALUE, $value);
    }

    public function getLabel()
    {
        return $this->getData(self::DATA_LABEL);
    }

    public function setLabel($label)
    {
        return $this->setData(self::DATA_LABEL, $label);
    }

    public function getAllLabelPlan()
    {
        $result = [];
        $collection = $this->getCollection();
        foreach ($collection as $item) {
            $result[$item->getValue()] = $item->getLabel();
        }
        return $result;
    }
    public function getCodePlanByLabel($label)
    {
        $result = NULL;
        $collection = $this->getCollection();
        foreach ($collection as $item) {
            if($item->getLabel()==$label){
                $result=(int)$item->getValue();
                break;
            }
        }
        return $result;

    }
}