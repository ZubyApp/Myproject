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
use Closure;
use PHPUnit\Framework\TestCase;
class ContainerTest extends TestCase
{
    private Container $container;
    private Closure $invoiceClass;

    public function setUp(): void
    {
        parent::setUp();

        $this->container = new Container;
        $this->invoiceClass = function () { return new InvoiceService(
                new SalesTaxService(),
                new StripePayment(),
                new EmailService()
            );
        };

        
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
    public function binding_does_not_exist_before_set_method_is_called(): void
    {
        $this->assertFalse($this->container->has(InvoiceService::class));

        $this->container->set(
            InvoiceService::class,
            $this->invoiceClass
        );

        $this->assertTrue($this->container->has(InvoiceService::class));
    }

    /** @test */
    public function can_get_class_that_has_binding_from_container(): void
    {
        $this->container->set(InvoiceService::class, $this->invoiceClass
    );

        $sampleClass = new InvoiceService(
            new SalesTaxService(),
            new StripePayment(),
            new EmailService()
        );

        $this->assertEquals($sampleClass, $this->container->get(InvoiceService::class)
        );

    }

    /** @test */
    public function can_get_class_that_does_not_have_binding_from_container(): void
    {
        $this->container->set(
            InvoiceService::class,
            $this->invoiceClass
        );

        $sampleClass = new SalesTaxService();

        $this->assertEquals(
            $sampleClass,
            $this->container->get(SalesTaxService::class)
        );
    }

    /** @test */
    public function it_throws_class_not_instantiable_container_exception(): void
    {
        $theClass = PaymentGatewayInterface::class;

        $this->expectException(ContainerException::class);

        $this->container->resolve($theClass);
    }

    /** @test
     * @dataProvider ParamErrorCases
     */
    public function it_throws_param_error_container_exception(string $class): void
    {
        $this->expectException(ContainerException::class);

        $this->container->resolve($class);
    }

    public function ParamErrorCases(): array
    {
        $class = new class([])
        {
            public function __construct(
                protected SalesTaxService|array $anonymousClass
            ) {
            }
        };

        $class1 = new class('done')
        {
            public function __construct(
                protected $class1,
            ) {
            }
        };

        $class2 = new class([])
        {
            public function __construct(
                protected array $class2,
            ) {
            }
        };
        return [
            [$class::class],
            [$class1::class],
            [$class2::class]
        ];
    }
}
