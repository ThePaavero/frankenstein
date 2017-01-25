<?php

namespace Frankenstein;

class FrankensteinController
{
    protected $api;

    public function __construct()
    {
        global $json_api;
        $this->api = $json_api;
        $this->doOriginWall();
    }

    public function doOriginWall()
    {
        $origin = $_SERVER['HTTP_ORIGIN'];
        if (!$origin)
        {
            return header('Access-Control-Allow-Origin: *');
        }
        $okUrls = json_decode(file_get_contents(__DIR__ . '/../okayUrls.json'))->allowed;
        if (!in_array($origin, $okUrls))
        {
            header('Access-Control-Allow-Origin: *');
            die(json_encode([
                'error' => 'This URL is not allowed.'
            ]));
        }

        return header('Access-Control-Allow-Origin: ' . $origin);
    }

    public function getDomainFromUrl($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs))
        {
            return $regs['domain'];
        }

        return false;
    }

    public function getItemsOfType($typeString, $limit = 0)
    {
        return get_posts([
            'post_type' => $typeString,
            'numberposts' => $limit
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

    public function getTaxonomyMany($post, $taxonomyKey, $nameOnly = true)
    {
        $return = [];
        $terms = get_the_terms($post, $taxonomyKey);
        foreach ($terms as $term)
        {
            if ($nameOnly)
            {
                $return[] = $term->name;
            }
            else
            {
                $return[] = $term;
            }
        }

        return $return;
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
            $imageId = (int)$data['file'];
            $images[] = [
                'small' => wp_get_attachment_image_src($imageId, 'thumbnail')[0],
                'medium' => wp_get_attachment_image_src($imageId, 'medium')[0],
                'original' => wp_get_attachment_url($imageId)
            ];
        }

        return $images;
    }

    public function getImageById($imageId)
    {
        return [
            'small' => wp_get_attachment_image_src($imageId, 'thumbnail')[0],
            'medium' => wp_get_attachment_image_src($imageId, 'medium')[0],
            'original' => wp_get_attachment_url($imageId)
        ];
    }
}
