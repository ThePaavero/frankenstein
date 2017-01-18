<?php

use Themosis\Facades\Field;
use Themosis\Facades\PostType;

class Frankenstein
{
    public $config;
    public $createdFields;
    public $createdPostTypes;
    public $createdTaxonomies;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function configToThemosis()
    {
        // td($this->config);
        $this->createFields($this->config->fields);
        $this->createPostTypes($this->config->postTypes);
    }

    public function createFields($fields)
    {
        foreach ($fields as $field)
        {
            $typeName = $field->type;
            Field::$typeName($field->slug, [
                'title' => $field->title,
                'info' => $field->info,
                'default' => ''
            ]);
            $this->createdFields[] = $field->slug;
        }
    }

    public function createPostTypes($postTypes)
    {
//        td($postTypes);
        foreach ($postTypes as $postType)
        {
            $created = PostType::make($postType->slug, $postType->namePlural, $postType->nameSingular)->set([
                'public' => true,
                'supports' => 'title'
            ]);
            $this->createdPostTypes[] = $created->get('name');
        }
    }
}
