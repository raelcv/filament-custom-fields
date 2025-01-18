<?php

namespace HungryBus\CustomFields\Commands;

use Illuminate\Console\Command;

class CustomFieldsCommand extends Command
{
    public $signature = 'custom-fields';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
