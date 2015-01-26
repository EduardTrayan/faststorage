<?php

namespace Eduardtrayan\FaststorageBundle\Service;

interface FastStorageInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @throws \InvalidArgumentException
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
