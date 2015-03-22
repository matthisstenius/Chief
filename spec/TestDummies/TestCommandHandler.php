<?php namespace spec\Matthis\Chief\TestDummies;

use Matthis\Chief\Contracts\CommandHandler;

class TestCommandHandler implements CommandHandler
{
    public function handle($command)
    {
        return 'Command handled successfully';
    }
}