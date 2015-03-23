# Chief

[![Build Status](https://travis-ci.org/matthisstenius/Chief.svg?branch=master)](https://travis-ci.org/matthisstenius/Chief)

A simple Command bus.

## Installation

Install via composer.

`composer require "matthis/chief:1.0"`

## Usage

Executing a command is as simple as:

```php
<?php 

$commandBus = new matthis\Chief\CommandBus();

$myCommand = new ReigtserUserCommand('John Doe', 'john@doe.com');
$commandBus->execute($myCommand);
```

Chief expects the following naming convention:

The commands should end with "Command".

Example command:

```php
<?php

class RegisterUserCommand`
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
        $command->username; //John Doe
        $command->email; //john@doe.com
    }
}
```

## Tests

`vendor/bin/phpspec run`
