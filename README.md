# Email checker api lib

<p align="center">

[![Build Status](https://travis-ci.org/seredenko/email-checker.svg?branch=master)](https://travis-ci.org/seredenko/email-checker)
[![codecov](https://codecov.io/gh/seredenko/email-checker/branch/master/graph/badge.svg)](https://codecov.io/gh/seredenko/email-checker)
[![Latest Stable Version](https://poser.pugx.org/seredenko/email-checker/v/stable)](https://packagist.org/packages/seredenko/email-checker)
[![Total Downloads](https://poser.pugx.org/seredenko/email-checker/downloads)](https://packagist.org/packages/seredenko/email-checker)
[![License](https://poser.pugx.org/seredenko/email-checker/license)](https://packagist.org/packages/seredenko/email-checker)
</p>


## Installation

### With composer
`composer require seredenko/email-checker`

## Usage

Before usage we must prepare $config for library. Out of box we have two config providers:
* ArrayConfigProvider
* JsonConfigProvider


**ArrayConfigProvider** gets config from array. We can use default array in provider or set custom.

```
// with basic array
$config = new ArrayConfigProvider();

// with custom array
$config = new ArrayConfigProvider(['host' => 'custom host with protocol']);
```

**JsonConfigProvider** gets config from json file from base library folder. Or your can change the path to 
the file:

```
// with basic file
$config = new JsonConfigProvider();

// or your file
$config = new JsonConfigProvider(#path to your file);
```

After setting config we can use EmailChecker

```
$checked = new EmailChecker($config);
$result = $checker->verify('test@gmail.com');
```

Or you can use checker without config. On that way will be using default ArrayConfigProvider

```
$checked = new EmailChecker();
$result = $checker->verify('test@gmail.com');
```


### Response

Validation response has next fields:

* email - validated email
* result - result of validation (boolean value true or false)
* reason - invalid email explanation (optional, if result was false)
* suggested - if email valid, but not working, this option show presumptive email (optional, if any suggestion was proposed)


#### Example (with default config)


```
use Seredenko\EmailChecker;

class AuthController
{
    public function emailValidation($email){        
        $checker = new EmailChecker();
        
        return $checker->verify($email);
    }
}
```