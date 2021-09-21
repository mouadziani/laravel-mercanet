<?php


namespace Mouadziani\Mercanet\Tests;


use Mouadziani\Mercanet\Mercanet;


class MercanetRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_exception_if_at_least_one_of_required_fields_is_empty()
    {
        $this->assertThrows(
            \RuntimeException::class,
            function () {
                Mercanet::boot()
                    ->validateRequiredOptions();
            }
        );
    }

    /**
     * @test
     */
    public function it_throws_exception_if_required_configuration_fields_are_empty()
    {
        $this->assertThrows(
            \RuntimeException::class,
            function () {
                Mercanet::boot()
                    ->newPaymentRequest()
                    ->setTransactionReference('1342342')
                    ->setAmount(100.00)
                    ->validateRequiredOptions();
            }
        );
    }

    /**
     * @test
     */
    public function it_dont_throws_exception_if_all_required_fields_are_filled()
    {
        $this->fillDefaultConfig();

        $this->assertNotThrows(
            \RuntimeException::class,
            function () {
                Mercanet::boot()
                    ->newPaymentRequest()
                    ->setTransactionReference('123456789')
                    ->setAmount(100.00)
                    ->validateRequiredOptions();
            }
        );
    }

    /**
     * @test
     */
    public function it_throws_exception_if_the_given_currency_is_invalid()
    {
        $this->fillDefaultConfig();

        $this->assertThrows(
            \InvalidArgumentException::class,
            function () {
                Mercanet::boot()
                    ->newPaymentRequest()
                    ->setCurrency('abc')
                    ->setTransactionReference('123456789')
                    ->setAmount(100.00)
                    ->validateRequiredOptions();
            }
        );

        $this->assertNotThrows(
            \InvalidArgumentException::class,
            function () {
                Mercanet::boot()
                    ->newPaymentRequest()
                    ->setCurrency('USD')
                    ->setTransactionReference('123456789')
                    ->setAmount(100.00)
                    ->validateRequiredOptions();
            }
        );
    }

    /**
     * @test
     */
    public function it_throws_exception_if_the_given_language_is_not_allowed()
    {
        $this->fillDefaultConfig();

        $this->assertThrows(
            \InvalidArgumentException::class,
            function () {
                Mercanet::boot()
                    ->newPaymentRequest()
                    ->setLanguage('abc')
                    ->setTransactionReference('123456789')
                    ->setAmount(100.00)
                    ->validateRequiredOptions();
            }
        );

        $this->assertNotThrows(
            \InvalidArgumentException::class,
            function () {
                Mercanet::boot()
                    ->newPaymentRequest()
                    ->setLanguage('fr')
                    ->setTransactionReference('123456789')
                    ->setAmount(100.00)
                    ->validateRequiredOptions();
            }
        );
    }
}