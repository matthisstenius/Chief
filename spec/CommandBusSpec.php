<?php namespace spec\Matthis\Chief;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Matthis\Chief\TestDummies\AnotherCommand;
use spec\Matthis\Chief\TestDummies\Invalid;
use spec\Matthis\Chief\TestDummies\TestCommand;

class CommandBusSpec extends ObjectBehavior
{
    function it_should_execute_a_command_to_command_handler()
    {
        $this->execute(new TestCommand)->shouldReturn('Command handled successfully');
    }

    function it_should_fail_when_handler_class_does_not_exist()
    {
        $this->shouldThrow('Matthis\Chief\Exceptions\HandlerNotRegisteredException')
            ->during('execute', [new AnotherCommand]);
    }

    function it_should_fail_when_command_is_named_incorrectly()
    {
        $this->shouldThrow('Matthis\Chief\Exceptions\InvalidCommandException')
            ->during('execute', [new Invalid]);
    }
}
