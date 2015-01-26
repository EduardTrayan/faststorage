<?php

namespace Eduardtrayan\FaststorageBundle\Service;

use Eduardtrayan\FaststorageBundle\Exception\MemcacheConnectionException;

class MemcacheFastStorage extends FastStorageAbstract
{
    /**
     * @var \Memcache|null
     */
    private $connection = null;

    /**
     * @param string $host
     * @param integer $port
     * @throws MemcacheConnectionException
     */
    public function __construct($host, $port)
    {
        $this->connection = new \Memcache();

        if (!$this->connection->connect($host, $port)) {
            throw new MemcacheConnectionException();
        }
    }

    /** {@inheritdoc} */
    public function set($key, $value)
    {
        $this->checkInputValue($value);

        return $this->connection->set($key, $value);
    }

    /** {@inheritdoc} */
    public function get($key)
    {
        return $this->connection->get($key);
    }

    /** {@inheritdoc} */
    public function increment($key)
    {
        return $this->connection->increment($key);
    }

    /** {@inheritdoc} */
    public function decrement($key)
    {
        return $this->connection->decrement($key);
    }

    /** {@inheritdoc} */
    public function delete($key)
    {
        return $this->connection->delete($key);
    }
}
