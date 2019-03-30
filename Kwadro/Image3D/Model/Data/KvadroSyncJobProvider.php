<?php

namespace Kvadro\Image3D\Model\Data;

use Magento\Framework\App\Request\DataPersistorInterface;
use Kvadro\Image3D\Model\ResourceModel\KvadroSyncJobParams\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class KvadroSyncJobProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    private $loadedData;

    private $dataPersistor;

    public $collection;

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
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []

    )
    {
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

        foreach ($items as $model) {
            $data_model = $model->load($model->getId());
            $this->loadedData[$model->getId()] = $data_model->getData();
        }
        return $this->loadedData;
    }


}
