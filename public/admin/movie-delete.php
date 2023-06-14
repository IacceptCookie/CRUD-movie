<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;

try {
    if (!(isset($_GET['movieId']) and ctype_digit($_GET['movieId']))) {
        throw new ParameterException('Parameter movieId is not set or is not an integer');
    } else {
        $movieId = intval($_GET['movieId']);
        $movie = Movie::findById($movieId);
        $movie->delete();
        header('Location: /index.php');
    }
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
