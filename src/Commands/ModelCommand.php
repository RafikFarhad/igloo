<?php

namespace Farhad\Igloo\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Farhad\Igloo\GeneratorClass;

class ModelCommand extends GeneratorClass
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-model { name : Model Name }
                            {--fillable= : The name of fillable attributes}
                            {--guarded= : The name of guarded attributes}
                            {--table_name= : The name of associated table}
                            {--namespace= : The namespace to store the Model}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new model with fillable, guarded, table name and namespace.';


    protected $namespace = 'Models/';

    protected $files;

    protected $type = 'Model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $this->namespace . $name;
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $table_name = $this->option('table_name');
        if ($table_name == null) {
            $table_name = strtolower($this->getOnlyClassName($name));
        }

        $stub = str_replace([
            'DummyNamespace',
            'DUMMYDATE',
            '/*GUARDED*/',
            '/*FILLABLE*/',
            '/*TABLE NAME*/'], [
            $this->getNamespace($name),
            Carbon::now()->toDateTimeString(),
            $this->getOptionalKey('guarded'),
            $this->getOptionalKey('fillable'),
            $table_name
        ],
            $stub
        );
        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = $this->getOnlyClassName($name);
        return str_replace('DummyModel', $class, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/DummyModel.stub';
    }
}
