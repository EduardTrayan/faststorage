<?php

namespace Eduardtrayan\FaststorageBundle\Service;

class BlackHoleFastStorageDriver implements FastStorageDriverInterface
{
    /** {@inheritdoc} */
    public function connect()
    {
    }

    /** {@inheritdoc} */
    public function set($key, $value)
    {
    }

    /** {@inheritdoc} */
    public function get($key)
    {
    }

    /** {@inheritdoc} */
    public function increment($key)
    {
    }

    /** {@inheritdoc} */
    public function decrement($key)
    {
    }

    /** {@inheritdoc} */
    public function delete($key)
    {
    }
}
