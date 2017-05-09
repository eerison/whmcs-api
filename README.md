# WhmcsApi

[![Build Status](https://travis-ci.org/eerison/whmcs-api.svg?branch=master)](https://travis-ci.org/eerison/whmcs-api)

Projeto para utilizar api externa do whmcs!

### Lista de modulos implementados

* Billing
    - [x] AddInvoicePayment
   
### composer

composer require eerison/whmcs-api

### Variáveis de ambiente

WHMCSAPI_URL

WHMCSAPI_USERNAME

WHMCSAPI_PASSWORD

### Exemples

exemplo sem variável de ambiente

``` php
try {
    $payment = new \WhmcsApi\Invoice\AddInvoicePayment('https://urlapiwhmcs.com.br/api.php','username','password');
    $payment
        ->setInvoiceid(8542)
        ->setTransid('transação 1')
        ->setDate(\Carbon\Carbon::now())
        ->setGateway('banktransfer')
        ->exec()
    ;
} catch (WhmcsApi\Exception $e) {
    echo $e->getMessage();
}
```

Utilizando variáveis de ambiente não precisa informar os dados de autenticação no construtor do metodo.

exemplo : 
``` php
...
    $payment = new \WhmcsApi\Invoice\AddInvoicePayment();
...
```