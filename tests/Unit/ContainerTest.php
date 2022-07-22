<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Container;
use App\Services\PaymentGatewayInterface;
use App\Services\SalesTaxService;
use App\Services\StripePayment;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public string $id = 'SalesTaxService::class';
    

    /** @test */
    public function check_if_id_has_binding(): void
    {
        // given that we have a container object

        $container = new Container();
         

         //when we call the has method with arg
         $result = $container->has($this->id);

         // we assert that entry exists in container
         $this->assertTrue(isset($result));
    }

    /** @test */
    public function check_if_class_is_set_in_container(): void
    {
        $container = new Container();

        $setClass = $container->set(PaymentGatewayInterface::class, StripePayment::class);

        $this->assertTrue(isset($setClass));

    }

}