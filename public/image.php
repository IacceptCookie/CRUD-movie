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
} catch (EntityNotFoundException) {
    echo "img/movie.png";
    exit();
} catch (Exception) {
    http_response_code(500);
}

header('Content-Type: image/jpeg');
echo $image->getJpeg();
