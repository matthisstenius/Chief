<?php namespace Matthis\Chief\Contracts;

interface CommandHandler {
    public function handle($command);
} 