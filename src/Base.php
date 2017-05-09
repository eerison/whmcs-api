<?php
namespace WhmcsApi;

abstract class Base
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

        if(is_null($url))
            $this->url = $_ENV['WHMCSAPI_URL'];

        if(is_null($username))
            $this->username = $_ENV['WHMCSAPI_USERNAME'];

        if(is_null($password))
            $this->password = $_ENV['WHMCSAPI_PASSWORD'];
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return Api
     */
    public function setAction($action)
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
        $postfields = $this->mountPostfields();

        $postfields = array_filter($postfields);
        $postfields = array_map(
            function($map) {

                if($map instanceof \DateTime)
                    return $map->format('Ymd');

                return $map;
            },
            array_filter($postfields));

        return $this->sendApi($postfields);
    }

    private function sendApi($postfields)
    {
        $url = $this->getUrl();
        $postfields["action"] = $this->getAction();
        $postfields["username"] = $this->getUsername();
        $postfields["password"] = $this->getPassword();
        $postfields["responsetype"] = $this->getResponsetype();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $data = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($data);

        if ($data->result == "success")
            return true;

        $this->throwException($data, $postfields);
    }

    /**
     * aqui vai ser implementado todas as mensagens de lançamento de exeções.
     * @param \ArrayObject $data
     * @param array $postfields
     * @return Exception
     * @throws Exception
     */
    protected abstract function throwException(\ArrayObject $data, array $postfields);

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