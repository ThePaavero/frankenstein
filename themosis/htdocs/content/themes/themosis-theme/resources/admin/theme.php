<?php

function frankensteinToThemosis()
{
    $frankensteinBasePath = $_SERVER['DOCUMENT_ROOT'] . '/../../frankenstein/';
    $frankensteinClassPath = $frankensteinBasePath . 'lib/FrankensteinSetup.php';
    $structureJsonPath = $frankensteinBasePath . 'structure.json';
    require $frankensteinClassPath;
    $config = json_decode(file_get_contents($structureJsonPath));

    $builder = new FrankensteinSetup($config);
    $builder->run();
}

frankensteinToThemosis();
