<?php

use Themosis\Facades\Field;
use Themosis\Facades\Metabox;
use Themosis\Facades\PostType;
use Themosis\Facades\Taxonomy;

class Frankenstein
{
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function run()
    {
        $this->createPostTypes($this->config->postTypes);
        $this->createTaxonomies($this->config->taxonomies);
    }

    public function createFields($fields)
    {
        $createdFields = [];
        foreach ($fields as $field)
        {
            $fieldType = $field->type;
            if ($fieldType === 'infinite')
            {
                $createdFields[] = $this->createInfiniteField($field);
                continue;
            }
            $createdFields[] = Field::$fieldType($field->slug, [
                'title' => $field->title,
                'info' => $field->info
            ]);
        }

        return $createdFields;
    }

    public function createInfiniteField($infiniteField)
    {
        $fields = $infiniteField->fields;
        $fieldsCreated = $this->createFields($fields);
        $infiniteFieldCreated = Field::infinite($infiniteField->slug, $fieldsCreated, [
            'title' => $infiniteField->title,
            'info' => $infiniteField->info
        ]);

        return $infiniteFieldCreated;
    }

    public function createPostTypes($postTypes)
    {
        foreach ($postTypes as $postType)
        {
            PostType::make($postType->slug, $postType->namePlural, $postType->nameSingular)->set([
                'public' => true,
                'supports' => 'title',
                'menu_icon' => $postType->dashIcon,
                'show_in_rest' => true
            ]);

            // Create our metabox + fields and attach it to this post type
            $fields = $this->createFields($postType->fields);
            Metabox::make('Data', $postType->slug)->set($fields);
        }
    }

    public function createTaxonomies($taxonomies)
    {
        foreach ($taxonomies as $taxonomy)
        {
            Taxonomy::make($taxonomy->slug, $taxonomy->appliesToPostTypes, $taxonomy->namePlural, $taxonomy->nameSingular)->set([
                'public' => true
            ]);
        }
    }
}
