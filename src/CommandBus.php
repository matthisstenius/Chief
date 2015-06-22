<?php namespace Matthis\Chief;

use Illuminate\Container\Container;
use Matthis\Chief\Exceptions\HandlerNotRegisteredException;
use Matthis\Chief\Exceptions\InvalidCommandException;
use ReflectionClass;

class CommandBus
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
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
        $reflection = new ReflectionClass($command);

        $commandName =  $reflection->getShortName();
        $namespace = $reflection->getNameSpaceName();

        if (! stripos($commandName, 'Command')) {
            throw new InvalidCommandException('The provided command name is invalid. Command must have  "Command” in it!');
        }

        $handler = $namespace . '\\Handlers\\' . str_replace('Command', 'CommandHandler', $commandName);
         
        if (! class_exists($handler)) {
            throw new HandlerNotRegisteredException("The command handler class $handler does not exist");
        }

        return $handler;
    }

    /**
     * Resolves the handler class
     *
     * @param string $handlerName
     * @return object
     */
    private function getHandlerClass($handlerName)
    {
        return $this->container->make($handlerName);
    }
}
