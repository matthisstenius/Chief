<?php namespace Matthis\Chief;

use Illuminate\Contracts\Container\Container;
use Matthis\Chief\Exceptions\HandlerNotRegisteredException;
use Matthis\Chief\Exceptions\InvalidCommandException;

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

        $commandHandler = $this->getHandlerClass($handlerName);

        return $commandHandler->handle($command);
    }

    /**
     * Translates command name to handler name
     *
     * @param $command
     * @throws HandlerNotRegisteredException
     * @throws InvalidCommandException
     * @return mixed
     */
    private function translateToHandler($command)
    {
        $commandName = get_class($command);

        if (! stripos($commandName, 'Command')) {
            throw new InvalidCommandException('The provided command name is invalid. Command must have  "Command” in it!');
        }

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