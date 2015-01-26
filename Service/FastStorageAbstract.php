<?php

namespace Eduardtrayan\FaststorageBundle\Service;

abstract class FastStorageAbstract implements FastStorageInterface
{
    const EXCEPTION_ALLOWED_VARIABLES = 'Invalid input value: only string, integer or array allowed';

    /**
     * @param mixed $value
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function checkInputValue($value)
    {
        if (!is_string($value) && !is_int($value) && !is_array($value)) {
            throw new \InvalidArgumentException(self::EXCEPTION_ALLOWED_VARIABLES);
        }
    }
}
