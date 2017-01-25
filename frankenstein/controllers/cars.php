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
        $cars = $this->getItemsOfType('cars');

        foreach ($cars as $car)
        {
            $id = $this->getItemId($car);
            $fields = $this->getOwnFields($car);
            $formatted[] = [
                'id' => $id,
                'title' => $this->getItemTitle($car),
                'registrationDate' => $fields['registered_date'],
                'description' => $fields['description'],
                'specs' => $fields['technical_specs'],
                'color' => $this->getTaxonomySingle($car, 'color'),
                'tags' => $this->getTaxonomyMany($car, 'misc_tags', false),
                'price' => $fields['price'],
                'mileage' => $fields['mileage'],
                'aspiration' => $this->getTaxonomySingle($car, 'aspiration'),
                'pictures' => $this->getPictures(unserialize($fields['picture_gallery']))
            ];
        }

        return [
            'success' => true,
            'cars' => $formatted
        ];
    }
}
