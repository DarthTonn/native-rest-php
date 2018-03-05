<?php

namespace src\Core;

/**
 * Interface ApiInterface
 * @package src\Core
 */
interface ApiInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param $id
     * @return \stdClass
     */
    public function getById(int $id): \stdClass;

    /**
     * @return boolean
     */
    public function create(): bool;

    /**
     * @param int $id
     * @return boolean
     */
    public function update(int $id): bool;

    /**
     * @param int $id
     * @return boolean
     */
    public function delete(int $id): bool;
}