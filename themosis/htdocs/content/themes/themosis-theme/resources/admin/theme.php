<?php

function frankensteinToThemosis()
{
    $frankensteinBasePath = $_SERVER['DOCUMENT_ROOT'] . '/../../frankenstein/';
    $frankensteinClassPath = $frankensteinBasePath . 'Frankenstein.php';
    $structureJsonPath = $frankensteinBasePath . 'structure.json';
    require $frankensteinClassPath;
    $config = json_decode(file_get_contents($structureJsonPath));

    $builder = new Frankenstein($config);
    $builder->run();
}

frankensteinToThemosis();
