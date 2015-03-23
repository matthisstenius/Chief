# Chief

[![Build Status](https://travis-ci.org/matthisstenius/Chief.svg?branch=master)](https://travis-ci.org/matthisstenius/Chief)

A simple Command bus. As default it uses Laravels IoC container but that can be swappedat run time against another implementation.  

## Installation

Install via composer.

`composer require "matthis/chief:1.0"`

## Usage

Chief expects the following naming convention:

The commands should end with "Command".

Example command:

``php
<?php

class RegisterUserCommand 
{
    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->email = $email;
    }
}
```

For Chief to map the command to a command handler the handler should have the same name as the command and have "Handler" appended to it.

Example command handler:

```php
<?php

class RegisterUserCommandHandler
{
    public function handle($command)
    {
        $command->username; //The username
        $command->email; //The email
    }
}
```
## Tests

`vendor/bin/phpspec run`