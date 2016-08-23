<?php
/**
 * @author Hannes Finck <finck.hannes@gmail.com>
 */

namespace ApiAi\Exception;


use Exception;

class EntityObjectException extends \RuntimeException
{
    /**
     * EntityObjectException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}