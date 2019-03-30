<?php

namespace Kvadro\Image3D\Model\Plugin\Catalog\Product\Gallery;

class AddImage3DInGallery
{
    protected $_coreRegistry;
    protected $_syncData;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Kvadro\Image3D\Model\KvadroSyncData $kvadroTechSyncData,
        \Magento\Catalog\Block\Product\Context $context
    )
    {
        $this->_imageHelper = $context->getImageHelper();
        $this->_syncData = $kvadroTechSyncData;
        $this->_coreRegistry = $coreRegistry;
    }

    public function afterGetGalleryImagesJson(
        \Magento\Catalog\Block\Product\View\Gallery $subject,
        $result
    )
    {
        $product = $this->_coreRegistry->registry('product');
        //Todo:add function of STBL-6
        // $iframe_url =
        // $iframe_thumb =_
        $iframeUrl = "https://api.kvadro.com/api/player/c2fc7a9c-dd5c-4367-b82c-87ad82dde1d9/embedded?autorun=0&closebutton=1&logo=1&autorotate=0&autorotatetime=10&autorotatedelay=2&autorotatedir=1&hidefullscreen=1&hideautorotateopt=1&hidesettingsbtn=0&enableimagezoom=1&zoomquality=1&hidezoomopt=0";
        $temp_result=[];
        if ($iframeUrl) {
            $images3D = [
                'thumb' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'img' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'full' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'caption' => '',
                'position' => '0',
                'isMain' => true,
                'type' => 'image3D',
                'videoUrl' => $iframeUrl,
            ];
            $temp_result= json_decode($result,true);
            array_unshift($temp_result, $images3D);

            foreach ($temp_result as &$item) {
                $item['position']++;
                if ($item['isMain']) $item['isMain'] = false;
            }
            $result=json_encode($temp_result);
        }

        return $result;
    }
}