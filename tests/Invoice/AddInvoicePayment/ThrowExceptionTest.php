<?php
namespace WhmcsApi\Test\Invoice\AddInvoicePayment;

use PHPUnit\Framework\TestCase;
use WhmcsApi\Exception;
use WhmcsApi\Invoice\AddInvoicePayment;

class ThrowExceptionTest extends TestCase
{
    /**
     * caso não tenha parametros para poder autenticar lança uma Exception.
     * @expectedException        Exception
     * @expectedExceptionMessage Invoice #1 não encontrada.
     */
    public function testInvoiceNotFound()
    {
        $addInvoicePayment =  new AddInvoicePayment('url','username','password');
        $mydata = (object)['message' => 'Invoice ID Not Found'];
        $postfields = ['invoiceid' => 1];
        $addInvoicePayment->throwException($mydata, $postfields);
    }

    /**
     * caso não tenha parametros para poder autenticar lança uma Exception.
     * @expectedException        Exception
     * @expectedExceptionMessage Impossivel adicionar pagamento Invoice #1 cancelada.
     */
    public function testInvoiceCanceled()
    {
        $addInvoicePayment =  new AddInvoicePayment('url','username','password');
        $mydata = (object)['message' => 'It is not possible to add a payment to an invoice that is Cancelled'];
        $postfields = ['invoiceid' => 1];
        $addInvoicePayment->throwException($mydata, $postfields);
    }

    /**
     * caso não tenha parametros para poder autenticar lança uma Exception.
     * @expectedException        Exception
     * @expectedExceptionMessage The following error occured: Outra MSG
     */
    public function testInvoiceDefault()
    {
        $addInvoicePayment =  new AddInvoicePayment('url','username','password');
        $mydata = (object)['message' => 'Outra MSG'];
        $postfields = ['invoiceid' => 1];
        $addInvoicePayment->throwException($mydata, $postfields);
    }
}