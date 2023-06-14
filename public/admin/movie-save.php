<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $form = new MovieForm();
    $form->setEntityFromQueryString();
    $form->getMovie()->save();
    header('Location: /index.php');
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
