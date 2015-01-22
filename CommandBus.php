<?php namespace Workly\Commander;

use Illuminate\Contracts\Container\Container;
use Workly\Commander\Exceptions\HandlerNotRegisteredException;
use Workly\Commander\Exceptions\InvalidCommandException;

class CommandBus {
    /**
     * @var Container
     */
    private $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Executes the command
     *
     * @param $command
     * @throws InvalidCommandException
     */
    public function execute($command)
    {
        $handlerName = $this->translateToHandler($command);

        if (! $handlerName) {
            throw new InvalidCommandException('The provided command was invalid. Check command name!');
        }

        $commandHandler = $this->getHandlerClass($handlerName);

        $commandHandler->handle($command);
    }

    /**
     * Translates command name to handler name
     *
     * @param $command
     * @throws HandlerNotRegisteredException
     * @return mixed
     */
    private function translateToHandler($command)
    {
        $commandName = get_class($command);

        $handler = str_replace('Command', 'CommandHandler', $commandName);

        if (! class_exists($handler)) {
            throw new HandlerNotRegisteredException("The command handler class $handler does not exist");
        }

        return $handler;
    }

    /**
     * Resolves the handler class from the container
     *
     * @param string $handlerName
     * @return mixed
     */
    private function getHandlerClass($handlerName)
    {
        return $this->app->make($handlerName);
    }
} 