<?php

namespace Mouadziani\Mercanet\Tests\Traits;

use PHPUnit\Framework\Constraint\Exception as ConstraintException;
use PHPUnit\Framework\Constraint\LogicalNot;
use PHPUnit\Framework\ExpectationFailedException;
use Throwable;

/**
 * Allows for multiple assertions checking for throwable without using multiple methods.
 */
trait AssertThrows
{
    /**
     * Asserts that the callable doesn't throw a specified exception.
     *
     * @param string $class The exception type expected not to be thrown.
     * @param callable $execute The callable.
     *
     * @since   1.0.0
     */
    public function assertNotThrows(string $class, callable $execute): void
    {
        try {
            $execute();
        } catch (ExpectationFailedException $e) {
            throw $e;
        } catch (Throwable $e) {
            static::assertThat($e, new LogicalNot(new ConstraintException($class)));

            return;
        }

        static::assertThat(null, new LogicalNot(new ConstraintException($class)));
    }

    /**
     * Asserts that the callable throws a specified throwable.
     * If successful and the inspection callable is not null
     * then it is called and the caught exception is passed as argument.
     *
     * @param string $class The exception type expected to be thrown.
     * @param callable $execute The callable.
     * @param callable|null $inspect [optional] The inspector.
     *
     * @since   1.0.0
     */
    public function assertThrows(
        string $class,
        callable $execute,
        callable $inspect = null
    ): void
    {
        try {
            $execute();
        } catch (ExpectationFailedException $e) {
            throw $e;
        } catch (Throwable $e) {
            static::assertThat($e, new ConstraintException($class));

            if ($inspect !== null) {
                $inspect($e);
            }

            return;
        }

        static::assertThat(null, new ConstraintException($class));
    }
}