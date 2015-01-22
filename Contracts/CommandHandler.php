<?php namespace Workly\Commander\Contracts;

interface CommandHandler {
    public function handle($command);
} 