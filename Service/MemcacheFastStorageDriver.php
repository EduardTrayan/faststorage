<?php

namespace Eduardtrayan\FaststorageBundle\Service;

use Eduardtrayan\FaststorageBundle\Exception\FastStorageDriverConnectionException;

class MemcacheFastStorageDriver implements FastStorageDriverInterface
{
    /**
     * @var \Memcache|null
     */
    private $connection = null;

    /**
     * @var string
     */
    private $host;

    /**
     * @var integer
     */
    private $port;

    /**
     * @param string $host
     * @param integer $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /** {@inheritdoc} */
    public function connect()
    {
        $this->connection = new \Memcache();

        if (!$this->connection->connect($this->host, $this->port)) {
            throw new FastStorageDriverConnectionException();
        }
    }

    /** {@inheritdoc} */
    public function set($key, $value)
    {
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
