<?php

namespace App\Contracts;

/**
 * As factories tends to grow very fast, this interface will keep the pattern safe and te code more readable
 * Interface FactoryInterface
 *
 * @package App\Contracts
 */
interface FactoryInterface
{
    /**
     * FactoryInterface constructor, receives the object properties.
     *
     * @param array $data
     */
    public function __construct(array $data = []);

    /**
     * Receives the object properties if not set in the factory constructor
     * and returns an object instance
     *
     * @param array $data
     *
     * @return mixed
     */
    public function make(array $data = []) : object;
}