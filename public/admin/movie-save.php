<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $form = new MovieForm();
    $form->setEntityFromQueryString();
    $movie = $form->getMovie()->save();
    header("Location: /movie.php?movieId={$movie->getId()}");
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
