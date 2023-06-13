<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    if (!(isset($_GET['imageId']) and ctype_digit($_GET['imageId']))) {
        throw new ParameterException("Paramètre imageId invalide");
    }
    $imageId = intval($_GET['imageId']);
    $image = Image::findById($imageId);
} catch (ParameterException) {
    http_response_code(400);
    header('Content-Type: image/png');
    echo file_get_contents("img/movie.png");
} catch (EntityNotFoundException) {
    http_response_code(404);
    header('Content-Type: image/png');
    echo file_get_contents("img/movie.png");
} catch (Exception) {
    http_response_code(500);
}

header('Content-Type: image/jpeg');
echo $image->getJpeg();
