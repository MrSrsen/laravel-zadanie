<?php

use App\Console\Commands\SendArticleEmailsCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SendArticleEmailsCommand::class)
    ->cron('0 11,17 * * *');
