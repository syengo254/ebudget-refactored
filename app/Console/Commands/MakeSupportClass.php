<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeSupportClass extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:support {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate a new support class for your helper functions in the App\Support namespace.';

    protected $type = 'Support class';

    protected function getStub()
    {
        return __DIR__ . '/stubs/support.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\Support';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the support class'],
        ];
    }
}
