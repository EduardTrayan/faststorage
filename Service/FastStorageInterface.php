<?php

namespace Eduardtrayan\FaststorageBundle\Service;

use Eduardtrayan\FaststorageBundle\Exception\FastStorageInvalidArgumentException;
use Eduardtrayan\FaststorageBundle\Exception\FastStorageInvalidResultException;

interface FastStorageInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @return boolean
     * @throws FastStorageInvalidArgumentException
     * @throws FastStorageInvalidResultException
     */
    public function set($key, $value);

    /**
     * @param string $key
     * @return mixed
     * @throws FastStorageInvalidResultException
     */
    public function get($key);

    /**
     * @param string $key
     * @return mixed
     * @throws FastStorageInvalidResultException
     */
    public function increment($key);

    /**
     * @param string $key
     * @return mixed
     * @throws FastStorageInvalidResultException
     */
    public function decrement($key);

    /**
     * @param string $key
     * @return boolean
     * @throws FastStorageInvalidResultException
     */
    public function delete($key);
}
