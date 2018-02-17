<?php

namespace Farhad\Igloo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Farhad\Igloo\GeneratorClass;

class RouteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-route { name : Model Name }
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make API Routes for basic CRUD';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = fopen(__DIR__ .'/../Stubs/DummyRoute.stub', "r");
        $stub = '';
        while(!feof($file))
            $stub .= fgets($file);
        $stub = str_replace(
            [
                'DUMMY',
                'dummy'
            ],
            [
                $this->argument('name'),
                strtolower($this->argument('name'))
            ],
            $stub
        );

        $this->info($stub);
    }


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


}
