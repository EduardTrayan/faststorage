<?php

namespace Eduardtrayan\FaststorageBundle\Service;

use Eduardtrayan\FaststorageBundle\Exception\FastStorageDriverConnectionException;

interface FastStorageDriverInterface
{
    /**
     * @return void
     * @throws FastStorageDriverConnectionException
     */
    public function connect();

    /**
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function set($key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @return mixed
     */
    public function increment($key);

    /**
     * @param string $key
     * @return mixed
     */
    public function decrement($key);

    /**
     * @param string $key
     * @return boolean
     */
    public function delete($key);
}
