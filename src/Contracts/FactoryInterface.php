<?php

namespace App\Contracts;


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