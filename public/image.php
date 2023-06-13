<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {// on teste si imageId est valide
    if (!(isset($_GET['imageId']) and ctype_digit($_GET['imageId']))) {
        throw new ParameterException("Paramètre imageId invalide");
    }
    $imageId = intval($_GET['imageId']);
    $image = Image::findById($imageId);
} catch (ParameterException) {// si imageId a une mauvaise syntaxe ou est absent
    http_response_code(400);
    if (isset($_GET['type']) and ctype_alpha($_GET['type'])) {// on regarde le paramètre type
        if ($_GET['type'] === "m") {// si il vaut m
            header('Content-Type: image/png');
            echo file_get_contents("img/movie.png");
        } elseif ($_GET['type'] === "p") {// si il vaut p
            header('Content-Type: image/png');
            echo file_get_contents("img/actor.png");
        }
    }
    exit();
} catch (EntityNotFoundException) {// si l'id imageId est introuvable
    http_response_code(404);
    if (isset($_GET['type']) and ctype_alpha($_GET['type'])) {// on regarde le paramètre type
        if ($_GET['type'] === "m") {// si il vaut m
            header('Content-Type: image/png');
            echo file_get_contents("img/movie.png");
        } elseif ($_GET['type'] === "p") {// si il vaut p
            header('Content-Type: image/png');
            echo file_get_contents("img/actor.png");
        }
    }
    exit();
} catch (Exception) {// si une exception non géré est présente
    http_response_code(500);
}

header('Content-Type: image/jpeg');
echo $image->getJpeg();
