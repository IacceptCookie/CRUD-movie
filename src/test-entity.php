<?php

declare(strict_types=1);

use Database\MyPdo;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

// dbname, username et password à compléter !
MyPdo::setConfiguration(
    "mysql:host=mysql;dbname=;charset=utf8",
    "",
    ""
);

echo "People findById 678";
var_dump(\Entity\People::findById(678));
echo "Movie findById 582";
var_dump(\Entity\Movie::findById(582));
echo "PeopleCollection findByMovieId 582";
var_dump(\Entity\Collection\PeopleCollection::findByMovieId(582));
echo "MovieCollection findByPeopleId 678";
var_dump(\Entity\Collection\MovieCollection::findByPeopleId(678));
echo "MovieCollection findAll";
var_dump(\Entity\Collection\MovieCollection::findAll());
echo "Cast getRoleById 582 678";
var_dump(\Entity\Cast::getRoleById(582, 678));
echo "Image findById 33";
var_dump(\Entity\Image::findById(33));
