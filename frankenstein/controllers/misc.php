<?php

use Frankenstein\FrankensteinController;

class JSON_API_Misc_Controller extends FrankensteinController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getStaff()
    {
        $people = [];
        $items = $this->getItemsOfType('staff');
        foreach ($items as $item)
        {
            $fields = $this->getOwnFields($item);
            $people[] = [
                'name' => $this->getItemTitle($item),
                'email' => $fields['email'],
                'phone' => $fields['phone'],
                'photo' => $this->getImageById($fields['photo'])
            ];
        }

        return [
            'staff' => $people
        ];
    }
}
