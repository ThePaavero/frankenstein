<?php

class JSON_API_Cars_Controller
{
    private $api;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        global $json_api;
        $this->api = $json_api;
    }

    public function getWithTaxonomies()
    {
        $formatted = [];
        $cars = get_posts([
            'post_type' => 'cars'
        ]);
        foreach ($cars as $car)
        {
            $meta = get_post_meta($car->ID);
            foreach ($meta as $key => $value)
            {
                $meta[$key] = $value[0];
            }
            $meta->title = $car->post_title;
            $imageGalleryObject = unserialize($meta['picture_gallery']);
            $color = get_the_terms($car, 'color');
            $aspiration = get_the_terms($car, 'aspiration');
            $formatted[] = [
                'post' => $car,
                'meta' => $meta,
                'color' => $color,
                'aspiration' => $aspiration,
                'pictures' => $this->getPictures($imageGalleryObject)
            ];
        }

        return [
            'success' => true,
            'cars' => $formatted
        ];
    }

    public function getPictures($imageAttachmentArray)
    {
        $images = [];
        foreach ($imageAttachmentArray as $data)
        {
            $imageId = (int)$data['file'];
            $images[] = [
                'small' => wp_get_attachment_image_src($imageId, 'thumbnail')[0],
                'medium' => wp_get_attachment_image_src($imageId, 'medium')[0],
                'original' => wp_get_attachment_url($imageId)
            ];
        }

        return $images;
    }
}