<?php

use Themosis\Facades\Field;
use Themosis\Facades\Metabox;
use Themosis\Facades\PostType;

class Frankenstein
{
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function run()
    {
//        td($this->config);
        $this->createPostTypes($this->config->postTypes);
    }

    public function createFields($fields)
    {
        $createdFields = [];
        foreach ($fields as $field)
        {
            $fieldType = $field->type;
            $createdFields[] = Field::$fieldType($field->slug, [
                'title' => $field->title,
                'info' => $field->info
            ]);
        }

        return $createdFields;
    }

    public function createPostTypes($postTypes)
    {
        foreach ($postTypes as $postType)
        {
            PostType::make($postType->slug, $postType->namePlural, $postType->nameSingular)->set([
                'public' => true,
                'supports' => 'title'
            ]);

            // Create our metabox + fields and attach it to this post type
            $fields = $this->createFields($postType->fields);
            Metabox::make('Data', $postType->slug)->set($fields);
        }
    }
}
