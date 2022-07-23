<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Container;
use App\Exceptions\Container\ContainerException;
use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayInterface;
use App\Services\SalesTaxService;
use App\Services\StripePayment;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        parent::setUp();

        $this->container = new Container;
    }

    /** @test */
    public function check_if_id_has_binding_in_container(): void
    {
         //when a dependency is set in the container
         $this->container->set('App\Services\PaymentGatewayInterface', 'App\Services\PaddlePayment');
         
         // assert that entry exists in container
         $this->assertTrue($this->container->has('App\Services\PaymentGatewayInterface'));
    }

    /** @test */
    public function can_get_dependency_from_container(): void
    {
        $this->container->set(InvoiceService::class, function(){
            return new InvoiceService(
                new SalesTaxService(),
                new StripePayment(),
                new EmailService()
            );
        }
    );

        $sampleClass = new SalesTaxService();

        $this->assertEquals($sampleClass, $this->container->get(SalesTaxService::class)
        );

    }

    /** @test */
    public function it_throws_container_exception(): void
    {
        $theClass = PaymentGatewayInterface::class;

        $this->expectException(ContainerException::class);

        $this->container->resolve($theClass);
    }

}
