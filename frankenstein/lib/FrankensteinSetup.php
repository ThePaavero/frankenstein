<?php

use Themosis\Facades\Field;
use Themosis\Facades\Metabox;
use Themosis\Facades\PostType;
use Themosis\Facades\Taxonomy;

class FrankensteinSetup
{
    public $config;
    public $controllerDir;

    public function __construct($config)
    {
        $this->controllerDir = __DIR__ . '/../controllers/';
        $this->config = $config;
    }

    public function run()
    {
        $this->createPostTypes($this->config->itemTypes);
        $this->createTaxonomies($this->config->taxonomies);
        $this->registerControllers();
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
                'menu_icon' => $postType->dashIcon
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
            Taxonomy::make($taxonomy->slug, $taxonomy->appliesToItemTypes, $taxonomy->namePlural, $taxonomy->nameSingular)->set([
                'public' => true
            ]);
        }
    }

    public function registerControllers()
    {
        $files = scandir($this->controllerDir);
        foreach ($files as $filename)
        {
            if (strstr($filename, '.php'))
            {
                $this->registerController(str_replace('.php', '', $filename));
            }
        }
    }

    public function registerController($controllerName)
    {
        $slug = strtolower($controllerName);

        add_filter('json_api_controllers', function ($controllers) use ($slug)
        {
            $controllers[] = $slug;

            return $controllers;
        });

        add_filter('json_api_' . $slug . '_controller_path', function () use ($slug)
        {
            return $this->controllerDir . $slug . '.php';
        });
    }
}
