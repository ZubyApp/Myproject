<?php

declare (strict_types = 1);

namespace Tests\Unit\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayInterface;
use App\Services\SalesTaxService;
use App\Services\StripePayment;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    /** @test */
    public function it_process_invoice(): void
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $paymentGatewayMock  = $this->createMock(StripePayment::class);
        $emailServiceMock    = $this->createMock(EmailService::class);

        $paymentGatewayMock->method('charge')->willReturn(true);

        // given invoice service
            $invoiceService = new InvoiceService(
                $salesTaxServiceMock,
                $paymentGatewayMock, 
                $emailServiceMock
            );

            $customer = ['name' => 'Zuby'];
            $amount = 150;


            // when process is called 
            $result = $invoiceService->process($customer, $amount);

            // then assert invoice is processed successfully
            $this->assertTrue($result);
    }

    /** @test */
    public function it_sends_receipt_email_when_invoice_is_processed(): void
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $paymentGatewayMock  = $this->createMock(StripePayment::class);
        $emailServiceMock    = $this->createMock(EmailService::class);

        $paymentGatewayMock->method('charge')->willReturn(true);

        $emailServiceMock
        ->expects($this->once())
        ->method('send')
        ->with(['name' => 'Zuby'], 'receipt');

        // given invoice service
        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $paymentGatewayMock,
            $emailServiceMock
        );

        $customer = ['name' => 'Zuby'];
        $amount = 150;


        // when process is called 
        $result = $invoiceService->process($customer, $amount);

        // then assert invoice is processed successfully
        $this->assertTrue($result);
    }
}