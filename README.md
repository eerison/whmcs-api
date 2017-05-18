# WhmcsApi

[![Build Status](https://travis-ci.org/eerison/whmcs-api.svg?branch=master)](https://travis-ci.org/eerison/whmcs-api)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/26c2079f-4e2b-4bd4-959c-5bf23558c028/mini.png)](https://insight.sensiolabs.com/projects/26c2079f-4e2b-4bd4-959c-5bf23558c028)

Projeto para utilizar api externa do whmcs!

### Lista de modulos implementados

* Billing
    - [x] AddInvoicePayment
   
### composer

composer require eerison/whmcs-api

### Configurar `app/config/config.yml`

``` yml

...
    whmcs:
      api:
        url : localhost
        username : whmcs
        password : whmcs    
...

```

### Exemples

exemplo sem variável de ambiente

``` php
try {
    $payment = new \WhmcsApi\Invoice\AddInvoicePayment();
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
