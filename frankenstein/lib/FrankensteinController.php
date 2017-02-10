<?php

namespace Frankenstein;

/**
 * Class FrankensteinController.
 * This will abstract WordPress specific function calls away.
 * Your API controller class can/should extend this class.
 *
 * @package Frankenstein
 */
class FrankensteinController
{
    protected $api;

    /**
     * FrankensteinController constructor.
     */
    public function __construct()
    {
        global $json_api;
        $this->api = $json_api;
        $this->doOriginWall();
    }

    /**
     * Permit only allowed (and empty) origins.
     */
    public function doOriginWall()
    {
        $origin = $_SERVER['HTTP_ORIGIN'];
        if ( ! $origin)
        {
            return header('Access-Control-Allow-Origin: *');
        }
        $okUrls = json_decode(file_get_contents(__DIR__ . '/../okayUrls.json'))->allowed;
        if ( ! in_array($origin, $okUrls))
        {
            header('Access-Control-Allow-Origin: *');
            header('HTTP/1.0 403 Forbidden');
            die(json_encode([
                'error' => 'This URL is not allowed.'
            ]));
        }

        return header('Access-Control-Allow-Origin: ' . $origin);
    }

    /**
     * Get items of a certain post type.
     *
     * @param $typeString
     * @param int $limit
     * @return array
     */
    public function getItemsOfType($typeString, $limit = 0)
    {
        return get_posts([
            'post_type' => $typeString,
            'numberposts' => $limit
        ]);
    }

    /**
     * Get all custom fields for given post.
     *
     * @param $post
     * @return mixed
     */
    public function getOwnFields($post)
    {
        $meta = get_post_meta($post->ID);
        foreach ($meta as $key => $value)
        {
            $meta[$key] = $value[0];
        }

        return $meta;
    }

    /**
     * Get single taxonomy term for given post and given taxonomy type.
     *
     * @param $post
     * @param $taxonomyKey
     * @param bool $nameOnly
     * @return mixed
     */
    public function getTaxonomySingle($post, $taxonomyKey, $nameOnly = true)
    {
        $term = get_the_terms($post, $taxonomyKey)[0];

        return $nameOnly ? $term->name : $term;
    }

    /**
     * Get multiple taxonomy terms for given post and given taxonomy type.
     *
     * @param $post
     * @param $taxonomyKey
     * @param bool $nameOnly
     * @return array
     */
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

    /**
     * Get title ID.
     *
     * @param $post
     * @return mixed
     */
    public function getItemId($post)
    {
        return $post->ID;
    }

    /**
     * Get item title.
     *
     * @param $post
     * @return mixed
     */
    public function getItemTitle($post)
    {
        return $post->post_title;
    }

    /**
     * Turn an array of attachment IDs into an array with corresponding image URLS (all sizes).
     *
     * @param $imageAttachmentArray
     * @return array
     */
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

    /**
     * Get all URLs to all sizes for an image with given ID.
     *
     * @param $imageId
     * @return array
     */
    public function getImageById($imageId)
    {
        return [
            'small' => wp_get_attachment_image_src($imageId, 'thumbnail')[0],
            'medium' => wp_get_attachment_image_src($imageId, 'medium')[0],
            'original' => wp_get_attachment_url($imageId)
        ];
    }

    /**
     * Get all terms for given taxonomy type.
     *
     * @param $typeSlug
     * @return array|int|\WP_Error
     */
    public function getAllTermsForTaxonomyType($typeSlug)
    {
        return get_terms($typeSlug);
    }
}
