<?php
namespace WhmcsApi\Test\Invoice\AddInvoicePayment;

use PHPUnit\Framework\TestCase;
use WhmcsApi\Exception;
use WhmcsApi\Invoice\AddInvoicePayment;

class ValidFieldRequiredTest extends TestCase
{
    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Informe todos os campos obrigatórios [action, invoiceid, transid, gateway].
     */
    public function testRequiredInvoiceid()
    {
        $addInvoicePayment = new AddInvoicePayment('url','username','password');;
        $addInvoicePayment
            ->setTransid('transaction')
            ->setGateway('geteway')
        ;
        $addInvoicePayment->isValidFieldRequired();
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Informe todos os campos obrigatórios [action, invoiceid, transid, gateway].
     */
    public function testRequiredTransid()
    {
        $addInvoicePayment = new AddInvoicePayment('url','username','password');;
        $addInvoicePayment
            ->setInvoiceid(1)
            ->setGateway('geteway')
        ;
        $addInvoicePayment->isValidFieldRequired();
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Informe todos os campos obrigatórios [action, invoiceid, transid, gateway].
     */
    public function testRequiredGateway()
    {
        $addInvoicePayment = new AddInvoicePayment('url','username','password');;
        $addInvoicePayment
            ->setInvoiceid(1)
            ->setTransid('transaction')
        ;
        $addInvoicePayment->isValidFieldRequired();
    }

    public function testIsValid()
    {
        $addInvoicePayment = new AddInvoicePayment('url','username','password');;
        $addInvoicePayment
            ->setInvoiceid(1)
            ->setTransid('transaction')
            ->setGateway('geteway')
        ;

        $this->assertTrue($addInvoicePayment->isValidFieldRequired());
    }
}