<?php

namespace Frankenstein;

class FrankensteinController
{
    protected $api;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        global $json_api;
        $this->api = $json_api;
    }

    public function getPostsOfType($typeString)
    {
        return get_posts([
            'post_type' => $typeString
        ]);
    }

    public function getOwnFields($post)
    {
        $meta = get_post_meta($post->ID);
        foreach ($meta as $key => $value)
        {
            $meta[$key] = $value[0];
        }

        return $meta;
    }

    public function getTaxonomySingle($post, $taxonomyKey, $nameOnly = true)
    {
        $term = get_the_terms($post, $taxonomyKey)[0];

        return $nameOnly ? $term->name : $term;
    }

    public function getItemId($post)
    {
        return $post->ID;
    }

    public function getItemTitle($post)
    {
        return $post->post_title;
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
