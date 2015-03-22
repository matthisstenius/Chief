<?php namespace Workly\Infrastructure\Commander\Contracts;

interface CommandHandler {
    public function handle($command);
} 