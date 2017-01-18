<?php

use Themosis\Facades\Field;

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
//        td($this->config);
        $this->createFields($this->config->fields);
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
        }
    }
}
