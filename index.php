<?php

require_once "vendor/autoload.php";

use App\Classes\Model\ImporterSql;

// Cities
$citiesClassInstance = new ImporterSql(
    './data/cities.csv',
    [
        'name' => 'name',
        'lat' => 'latitude',
        'long' => 'longitude',
    ], 
    'cities'
);
$citiesClassInstance->import();
$citiesClassInstance->setInsertQueryString();
$citiesClassInstance->setInsertQueryIntoFile();

// Categories
$categoriesClassInstance = new ImporterSql(
    './data/categories.csv',
    [
        'name' => 'name',
        'icon' => 'slug',
    ], 
    'categories'
);
$categoriesClassInstance->import();
$categoriesClassInstance->setInsertQueryString();
$categoriesClassInstance->setInsertQueryIntoFile();
