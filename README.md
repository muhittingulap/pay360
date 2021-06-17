<p align="center">
<img src="https://raw.githubusercontent.com/muhittingulap/pay360/main/images/pay360-logo.png" width="300">
</p>

<h3 align="center">PHP-OOP Pay360 Api integration</h3>

<p align="center">
  <a href="https://packagist.org/packages/muhittingulap/pay360"><img src="https://poser.pugx.org/muhittingulap/pay360/v/stable.svg" alt="Latest Stable Version">
  <a href="https://packagist.org/packages/muhittingulap/pay360"><img src="https://poser.pugx.org/muhittingulap/pay360/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/muhittingulap/pay360"><img src="https://poser.pugx.org/muhittingulap/pay360/license.svg" alt="License"></a>
</p>

## Get Started
PHP OOP Pay360 Api integration

## Documentation (pay360)
[Click](https://docs.pay360.com/)

## Install

    $ composer require muhittingulap/pay360
 
## Using in your project
```php

    <?php     
    include('vendor/autoload.php');

    $payService = new \PAY360\libraries\transactions();
    $custService = new \PAY360\libraries\customers();

```  
## Config

| Parametre        | Detail |
| ---------------- | -------- |
| username         | API Username (pay360 Information contained in the mail sent by) |
| password         | API Password (pay360 Information contained in the mail sent by) |
| cardLockId       | CardLock ID (pay360 Information contained in the mail sent by) |
| hostedCashierId  | Installations Hosted Cashier (pay360 Information contained in the mail sent by) |
| cashierId        | Installations Cashier API (pay360 Information contained in the mail sent by) |
| type             | 0: Test 1: Prod |

## Use

```php

  <?php 
  $payService->setUsername()
             ->setPassword()
             ->setCardLockId()
             ->setHostedCashierId()
             ->setType(); // 0:test 1:prod

```  
## Transaction Methods

#### - Verify

```php

  <?php 
  $payService->setPostData($p_data) // $p_data -> array data
             ->verify();

```  
#### - Payment

```php

  <?php 
  $payService->setPostData($p_data) // $p_data -> array data
             ->payment();

```  
#### - 3D Resume

```php

  <?php 
  $return=$payService->resume(); // return data

```  
## Customers Methods

#### - Payment Method Remove

```php

  <?php 
  $custService->setCardToken()// pa360 card token
              ->setCustomerId() // pa360 customer Id
              ->paymentMethodRemove();

```  