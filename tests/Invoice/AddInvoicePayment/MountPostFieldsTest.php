<?php
namespace WhmcsApi\Test\Invoice\AddInvoicePayment;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use WhmcsApi\Invoice\AddInvoicePayment;

class MountPostFieldsTest extends TestCase
{
    public function testFielsAll()
    {
        $addInvoicePayment = new AddInvoicePayment('url', 'username', 'password');
        $addInvoicePayment
            ->setInvoiceid(1)
            ->setTransid('transid')
            ->setGateway('gateway')
            ->setDate(Carbon::createFromDate(2017,5,9,'America/Fortaleza'))
            ->setAmount(50.5)
            ->setFees(50.5)
            ->setNoemail(true)
            ;

        $postfields = [
            'invoiceid' => 1,
            'transid' => 'transid',
            'gateway' => 'gateway',
            'date' => Carbon::createFromDate(2017,5,9,'America/Fortaleza'),
            'amount' => 50.5,
            'fees' => 50.5,
            'noemail' => true,
        ];

        $this->assertEquals($postfields, $addInvoicePayment->mountPostfields());
    }

    public function testFieldsBasicTest()
    {
        $addInvoicePayment = new AddInvoicePayment('url', 'username', 'password');
        $addInvoicePayment
            ->setInvoiceid(1)
            ->setTransid('transid')
            ->setGateway('gateway')
        ;

        $postfields = [
            'invoiceid' => 1,
            'transid' => 'transid',
            'gateway' => 'gateway',
        ];

        $this->assertEquals($postfields, $addInvoicePayment->mountPostfields());
    }
}