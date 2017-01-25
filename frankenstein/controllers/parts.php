<?php

use Frankenstein\FrankensteinController;

class JSON_API_Parts_Controller extends FrankensteinController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $formatted = [];
        $parts = $this->getItemsOfType('parts');

        foreach ($parts as $part)
        {
            $id = $this->getItemId($part);
            $fields = $this->getOwnFields($part);
            $formatted[] = [
                'id' => $id,
                'title' => $this->getItemTitle($part),
                'price' => $fields['price'],
                'description' => $fields['description'],
                'specs' => $fields['technical_specs'],
                'pictures' => $this->getPictures(unserialize($fields['picture_gallery'])),
                'typeTags' => $this->getTaxonomyMany($part, 'part_type')
            ];
        }

        return [
            'success' => true,
            'parts' => $formatted
        ];
    }
}
