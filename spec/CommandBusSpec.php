<?php namespace spec\Matthis\Chief;

use Illuminate\Contracts\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Matthis\Chief\TestDummies\AnotherCommand;
use spec\Matthis\Chief\TestDummies\Invalid;
use spec\Matthis\Chief\TestDummies\TestCommand;
use spec\Matthis\Chief\TestDummies\TestCommandHandler;

class CommandBusSpec extends ObjectBehavior
{
    function it_should_execute_a_command_to_command_handler(Container $container)
    {
        $container->make(TestCommand::class . 'Handler')->willReturn(new TestCommandHandler);
        $this->beConstructedWith($container);

        $this->execute(new TestCommand)->shouldReturn('Command handled successfully');
    }

    function it_should_fail_when_handler_class_does_not_exist(Container $container)
    {
        $container->make(AnotherCommand::class . 'Handler')->willReturn(null);
        $this->beConstructedWith($container);

        $this->shouldThrow('Matthis\Chief\Exceptions\HandlerNotRegisteredException')
            ->during('execute', [new AnotherCommand]);
    }

    function it_should_fail_when_command_is_named_incorrectly(Container $container)
    {
        $this->beConstructedWith($container);

        $this->shouldThrow('Matthis\Chief\Exceptions\InvalidCommandException')
            ->during('execute', [new Invalid]);
    }
}
