<?php

namespace Eduardtrayan\FaststorageBundle\Service;

use Eduardtrayan\FaststorageBundle\Exception\FastStorageDriverConnectionException;
use Predis\Client;

class RedisFastStorageDriver implements FastStorageDriverInterface
{
    const SCHEME = 'tcp';

    /**
     * @var Client|null
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
        try {
            $this->connection = new Client([
                'scheme' => self::SCHEME,
                'host' => $this->host,
                'port' => $this->port,
            ]);

            $this->connection->connect();
        } catch (\Exception $e) {
            throw new FastStorageDriverConnectionException($e->getMessage());
        }
    }

    /** {@inheritdoc} */
    public function set($key, $value)
    {
        if (is_array($value)) {
            return $this->connection->hmset($key, $value);
        }

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
        return $this->connection->incr($key);
    }

    /** {@inheritdoc} */
    public function decrement($key)
    {
        return $this->connection->decr($key);
    }

    /** {@inheritdoc} */
    public function delete($key)
    {
        return $this->connection->del([$key, ]);
    }
}
