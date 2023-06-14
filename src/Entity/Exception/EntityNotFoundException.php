<?php

declare(strict_types=1);

namespace Entity\Exception;

use OutOfBoundsException;
use Throwable;

class EntityNotFoundException extends OutOfBoundsException
{
    /**
     * Classe EntityNotFoundException. Cette exception est déclenchée quand une entité n'est pas trouvé dans la base de
     * donnée.
     */
}
