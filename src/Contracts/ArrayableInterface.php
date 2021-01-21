<?php

namespace App\Contracts;


/**
 * -note: This interface was made to accommodate a common feature in the User, Role, Permission entity classes
 * Interface ArrayableInterface
 *
 * @package App\Contracts
 */
interface ArrayableInterface
{
    public function toArray() : array;
}