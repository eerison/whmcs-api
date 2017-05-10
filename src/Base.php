<?php
namespace WhmcsApi;

use Curl\Curl;

abstract class Base extends Curl
{
    private $action;
    private $url;
    private $username;
    private $password;
    private $responsetype = 'json';

    /**
     * @param string $url url da api do whmcs.
     * @param int $username usuário para autenticar a api.
     * @param int $password senha para autenticar a api.
     */
    public function __construct($url = null, $username = null, $password = null)
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;

        if(is_null($url) && isset($_ENV['WHMCSAPI_URL']))
            $this->url = $_ENV['WHMCSAPI_URL'];

        if(is_null($username) && isset($_ENV['WHMCSAPI_USERNAME']))
            $this->username = $_ENV['WHMCSAPI_USERNAME'];

        if(is_null($password) && isset($_ENV['WHMCSAPI_PASSWORD']))
            $this->password = $_ENV['WHMCSAPI_PASSWORD'];

        $this->isValidExistAuth();

        parent::__construct();
    }

    /**
     * @return mixed
     */
    protected function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return Api
     */
    protected function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Base
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Base
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Base
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponsetype()
    {
        return $this->responsetype;
    }

    /**
     * @param mixed $responsetype
     * @return Api
     */
    public function setResponsetype($responsetype)
    {
        $this->responsetype = $responsetype;
        return $this;
    }

    public function exec()
    {
        $this->isValidFieldRequired();
        $this->isValidFieldRequiredBasic();
        $postfields = $this->mountPostfields();

        $url = $this->getUrl();
        $postfields["action"] = $this->getAction();
        $postfields["username"] = $this->getUsername();
        $postfields["password"] = $this->getPasswordMD5();
        $postfields["responsetype"] = $this->getResponsetype();

        $curl = new Curl();
        $curl->post($url, $postfields);
        $data = json_decode($curl->response);

        if ($data->result == "success")
            return true;

        $this->throwException($data, $postfields);
    }

    public function getPasswordMD5()
    {
        return md5($this->password);
    }

    /**
     * verifica se os parametros de para fazer a conexão existe
     * @return bool
     * @throws Exception
     */
    private function isValidExistAuth()
    {
        switch(true)
        {
            case is_null($this->getUrl()):
            case is_null($this->getUsername()):
            case is_null($this->getPassword()):
                throw new Exception('Url, username ou password não informados no construtor do objeto ou na variável de ambeiente.');
                break;
        }

        return true;
    }

    public function isValidFieldRequiredBasic()
    {
        if(is_null($this->getAction()))
            throw new Exception('Action não informada.');
        return true;
    }

    /**
     * aqui vai ser implementado todas as mensagens de lançamento de exeções.
     * @param $data
     * @param array $postfields
     * @return Exception
     * @throws Exception
     */
    public abstract function throwException($data, array $postfields);

    /**
     * @return Array
     */
    public abstract function mountPostfields();

    /**
     * fazer verificação de todos os campos obrigatórios.
     * caso algum não esteja informado, lançar um Exception
     * estando tudo certo retornar true
     * @return bool
     * @throws Exception
     */
    public abstract function isValidFieldRequired();
}
