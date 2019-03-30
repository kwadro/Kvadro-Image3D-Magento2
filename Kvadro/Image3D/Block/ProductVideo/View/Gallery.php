<?php

namespace Kvadro\Image3D\Block\ProductVideo\View;

class Gallery extends \Magento\ProductVideo\Block\Product\View\Gallery
{

    public function getMediaGalleryDataJson()
    {
        $mediaGalleryData = [];

       $mediaGalleryData[] = [
            'mediaType' => 'image3D',
            'videoUrl' => "https://api.kvadro.com/api/player/c2fc7a9c-dd5c-4367-b82c-87ad82dde1d9/embedded?autorun=0&closebutton=1&logo=1&autorotate=0&autorotatetime=10&autorotatedelay=2&autorotatedir=1&hidefullscreen=1&hideautorotateopt=1&hidesettingsbtn=0&enableimagezoom=1&zoomquality=1&hidezoomopt=0",
            'isBase' => true,
        ];
        foreach ($this->getProduct()->getMediaGalleryImages() as $mediaGalleryImage) {
            $mediaGalleryData[] = [
                'mediaType' => $mediaGalleryImage->getMediaType(),
                'videoUrl' => $mediaGalleryImage->getVideoUrl(),
                'isBase' => $this->isMainImage($mediaGalleryImage),
            ];
        }


        return $this->jsonEncoder->encode($mediaGalleryData);
    }
}
