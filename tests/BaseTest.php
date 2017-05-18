<?php
namespace WhmcsApi\Test;

use PHPUnit\Framework\TestCase;
use WhmcsApi\Base;
use WhmcsApi\Exception;

class BaseTest extends TestCase
{

    /**
     * Verifica se todos os parametros obrigatórios do base estão informados.
     * @throws Exception
     */
    public function testIsValidFieldRequiredBasicAccept()
    {
        $base = new myBase();
        $this->assertTrue($base->isValidFieldRequiredBasic());
    }

    /**
     * verifica se passando parametros no contrutor não está lançando uma Exception.
     */
    public function testIsValidExistAuthParams()
    {
        new myBase('url','username', 'password');
    }

    /**
     * verifica se está gerando senha md5.
     */
    public function testGetPasswordMD5()
    {
        $myBase = new myBase('url','username','password');
        $myBase->setPassword('minhateste@123');
        $this->assertEquals(md5('minhateste@123'), $myBase->getPasswordMD5());
    }
}

class myBase extends Base
{

    public function __construct($url = null, $username = null, $password = null)
    {
        $this->setAction('AddInvoicePayment');
        parent::__construct($url, $username, $password);
    }
    /**
     * @return Array
     */
    public function mountPostfields()
    {
        // TODO: Implement mountPostfields() method.
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
        // TODO: Implement isValidFieldRequired() method.
    }

    /**
     * aqui vai ser implementado todas as mensagens de lançamento de exeções.
     * @param $data
     * @param array $postfields
     * @return Exception
     * @throws Exception
     */
    public function throwException($data, array $postfields)
    {
        // TODO: Implement throwException() method.
    }
}