<?php
namespace WhmcsApi\Invoice;

use Carbon\Carbon;
use WhmcsApi\Base;
use WhmcsApi\Exception;

class AddInvoicePayment extends Base
{
    /** @var  int $invoiceid */
    private $invoiceid;
    /** @var  string $transid */
    private $transid;
    /** @var  string $gateway */
    private $gateway;
    /** @var  Carbon $date */
    private $date;
    /** @var  float $amount */
    private $amount;
    /** @var  float $fees */
    private $fees;
    /** @var  bool $noemail */
    private $noemail;

    /**
     * @return int
     */
    public function getInvoiceid()
    {
        return $this->invoiceid;
    }

    /**
     * @param int $invoiceid
     * @return AddInvoicePayment
     */
    public function setInvoiceid($invoiceid)
    {
        $this->invoiceid = $invoiceid;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransid()
    {
        return $this->transid;
    }

    /**
     * @param string $transid
     * @return AddInvoicePayment
     */
    public function setTransid($transid)
    {
        $this->transid = $transid;
        return $this;
    }

    /**
     * @return string
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param string $gateway
     * @return AddInvoicePayment
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param Carbon $date
     * @return AddInvoicePayment
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return AddInvoicePayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * @param float $fees
     * @return AddInvoicePayment
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isNoemail()
    {
        return $this->noemail;
    }

    /**
     * @param boolean $noemail
     * @return AddInvoicePayment
     */
    public function setNoemail($noemail)
    {
        $this->noemail = $noemail;
        return $this;
    }

    public function mountPostfields()
    {
        $postfields["invoiceid"]     = $this->getInvoiceid();
        $postfields["transid"]       = $this->getTransid();
        $postfields["amount"]        = $this->getAmount();
        $postfields["gateway"]       = $this->getGateway();

        return $postfields;
    }

    /**
     * aqui vai ser implementado todas as mensagens de lançamento de exeções.
     * @param \ArrayObject $data
     * @param array $postfields
     * @return Exception
     * @throws Exception
     */
    protected function throwException(\ArrayObject $data, array $postfields)
    {
        if($data->message == 'Invoice ID Not Found')
            throw new Exception(sprintf('Invoice #%s não encontrada.', $postfields['invoiceid']), 20);

        if($data->message == 'It is not possible to add a payment to an invoice that is Cancelled')
            throw new Exception(sprintf('Impossivel adicionar pagamento Invoice #%s cancelada.', $postfields['invoiceid']), 30);

        throw new Exception("The following error occured: " . $data->message, 10);
    }

    /**
     * fazer verificação de todos os campos obrigatórios.
     * caso algum não esteja informado, lançar um Exception
     * estando tudo certo retornar true
     * @return bool
     * @throws Exception
     */
    public function isValidFieldRequired()
    {
        switch(true)
        {
            case is_null($this->getAction()):
            case is_null($this->getInvoiceid()):
            case is_null($this->getTransid()):
            case is_null($this->getGateway()):
                throw new Exception('Informe todos os campos obrigatórios [action, invoiceid, transid, gateway].');
                break;
        }

        return true;
    }
}