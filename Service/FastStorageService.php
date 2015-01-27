<?php

namespace Eduardtrayan\FaststorageBundle\Service;

use Eduardtrayan\FaststorageBundle\Exception\FastStorageDriverConnectionException;
use Eduardtrayan\FaststorageBundle\Exception\FastStorageInvalidArgumentException;
use Eduardtrayan\FaststorageBundle\Exception\FastStorageInvalidResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FastStorageService implements FastStorageInterface
{
    const EXCEPTION_INVALID_VALUE_TO_STORE = 'You try to save value of unsupported type "%s". Supported types: %s';
    const EXCEPTION_INCORRECT_RESULT = 'Incorrect result from server for operation "%s" for value with key "%s"';

    /**
     * @var FastStorageDriverInterface
     */
    private $driver;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var array
     */
    private $allowedInternalTypes = [
        'integer',
        'array',
        'string',
        'float',
    ];

    /**
     * @var Constraint[]
     */
    private $constraints = [];

    /**
     * @param ValidatorInterface         $validator
     * @param FastStorageDriverInterface $driver
     * @throws FastStorageDriverConnectionException
     */
    public function __construct(ValidatorInterface $validator, FastStorageDriverInterface $driver = null)
    {
        $this->validator = $validator;

        if (!$driver instanceof FastStorageDriverInterface) {
            $driver = new BlackHoleFastStorageDriver();
        }

        $this->driver = $driver;
        $this->driver->connect();
    }

    /** {@inheritdoc} */
    public function set($key, $value)
    {
        $this->checkInputValue($value);

        $result = $this->driver->set($key, $value);

        $this->checkResult($result, 'set', $key);

        return $result;
    }

    /** {@inheritdoc} */
    public function get($key)
    {
        $result = $this->driver->get($key);

        $this->checkResult($result, 'get', $key);

        return $result;
    }

    /** {@inheritdoc} */
    public function increment($key)
    {
        $result = $this->driver->increment($key);

        $this->checkResult($result, 'increment', $key);

        return $result;
    }

    /** {@inheritdoc} */
    public function decrement($key)
    {
        $result = $this->driver->decrement($key);

        $this->checkResult($result, 'decrement', $key);

        return $result;
    }

    /** {@inheritdoc} */
    public function delete($key)
    {
        $result = $this->driver->delete($key);

        $this->checkResult($result, 'delete', $key);

        return $result;
    }

    /**
     * @param mixed $value
     * @throws FastStorageInvalidArgumentException
     */
    private function checkInputValue($value)
    {
        if (empty($this->constraints) && !empty($this->allowedInternalTypes)) {
            foreach ($this->allowedInternalTypes as $allowedType) {
                $this->constraints[] = new Type(['type' => $allowedType, ]);
            }
        }

        $errors = $this->validator->validate($value, $this->constraints);

        if (count($errors) === count($this->allowedInternalTypes)) {
            throw new FastStorageInvalidArgumentException(
                sprintf(self::EXCEPTION_INVALID_VALUE_TO_STORE, gettype($value), implode($this->allowedInternalTypes, ', '))
            );
        }
    }

    /**
     * @param mixed $result
     * @param string $method
     * @param string $key
     * @throws FastStorageInvalidResultException
     */
    private function checkResult($result, $method, $key)
    {
        if (false === $result) {
            throw new FastStorageInvalidResultException(
                sprintf(self::EXCEPTION_INCORRECT_RESULT, $method, $key)
            );
        }
    }
}
