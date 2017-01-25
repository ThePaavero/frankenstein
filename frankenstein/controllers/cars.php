<?php

use Frankenstein\FrankensteinController;

class JSON_API_Cars_Controller extends FrankensteinController
{
    public function __construct()
    {
        parent::__construct();
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
            $imageGalleryObject = unserialize($meta['picture_gallery']);
            $color = get_the_terms($car, 'color')[0]->name;
            $aspiration = get_the_terms($car, 'aspiration')[0]->name;
            $formatted[] = [
                'id' => $car->ID,
                'title' => $car->post_title,
                'registrationDate' => $meta['registered_date'],
                'description' => $meta['description'],
                'specs' => $meta['technical_specs'],
                'color' => $color,
                'price' => $meta['price'],
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
            $imageId = (int) $data['file'];
            $images[] = [
                'small' => wp_get_attachment_image_src($imageId, 'thumbnail')[0],
                'medium' => wp_get_attachment_image_src($imageId, 'medium')[0],
                'original' => wp_get_attachment_url($imageId)
            ];
        }

        return $images;
    }
}
