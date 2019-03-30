<?php

namespace Kvadro\Image3D\Model\Data;

use Magento\Framework\App\Request\DataPersistorInterface;
use Kvadro\Image3D\Model\ResourceModel\KvadroSetting\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class KvadroSettingProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    private $loadedData;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    private $dataPersistor;


    public $collection;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Kvadro\Image3D\Model\KvadroPaymentPlanFactory $PaymentPlanFactory,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []

    )
    {
        $this->paymentPlanFactory = $PaymentPlanFactory;
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $plan_label = $this->paymentPlanFactory->create()->getAllLabelPlan();

        foreach ($items as $model) {
            $data_model = $model->load($model->getId());
            $this->loadedData[$model->getId()] = $data_model->getData();

            if ($model->getPlan()) {

                $m['plan_label'] = strtoupper($plan_label[(int)$model->getPlan()]);
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m);
            }

        }
        return $this->loadedData;
    }


}
