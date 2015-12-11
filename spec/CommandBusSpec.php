<?php namespace spec\Matthis\Chief;

use Illuminate\Contracts\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Matthis\Chief\TestDummies\AnotherCommand;
use spec\Matthis\Chief\TestDummies\Invalid;
use spec\Matthis\Chief\TestDummies\TestCommand;
use spec\Matthis\Chief\TestDummies\Handlers\TestCommandHandler;
use Illuminate\Contracts\Queue\Queue;

class CommandBusSpec extends ObjectBehavior
{
    function let(Container $container, Queue $queue)
    {
        $this->beConstructedWith($container, $queue);
    }

    function it_should_execute_a_command_to_command_handler(Container $container)
    {
        $container->make('spec\Matthis\Chief\TestDummies\Handlers\TestCommandHandler')
            ->willReturn(new TestCommandHandler);

        $this->execute(new TestCommand)->shouldReturn('Command handled successfully');
    }

    function it_should_fail_when_handler_class_does_not_exist(Container $container)
    {
        $container->make(AnotherCommand::class . 'Handler')->willReturn(null);

        $this->shouldThrow('Matthis\Chief\Exceptions\HandlerNotRegisteredException')
            ->during('execute', [new AnotherCommand]);
    }

    function it_should_fail_when_command_is_named_incorrectly(Container $container)
    {
        $this->shouldThrow('Matthis\Chief\Exceptions\InvalidCommandException')
            ->during('execute', [new Invalid]);
    }

    function it_should_queue_a_command_for_later_execution(Container $container, Queue $queue)
    {
        $command = new TestCommand;

        $container->make('spec\Matthis\Chief\TestDummies\Handlers\TestCommandHandler')
            ->willReturn($command);

        $queue->push('Matthis\Chief\CommandBus@execute', serialize($command));
    }
}
