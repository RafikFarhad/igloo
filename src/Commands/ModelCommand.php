<?php

namespace Farhad\Igloo\Commands;

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
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new model with fillable and guarded.';


    protected $namespace = 'Models\\';

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
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $this->namespace.$name;
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyNamespace', '/*GUARDED*/', '/*FILLABLE*/'],
            [$this->rootNamespace(), $this->getOptionalKey('guarded'), $this->getOptionalKey('fillable')],
            $stub
        );
        return $this;
    }


    protected function getOptionalKey($optional_key)
    {
        $fields = $this->option($optional_key);
        $fields = explode(',', $fields);
        $result = "";
        foreach ($fields as $field)
        {
            $result .= "'".$field."',";
        }
        $result = rtrim($result, ',');
        if($result=="''") return null;
        return $result;
    }


    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return rtrim($this->laravel->getNamespace().$this->namespace, '\\');
    }


    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

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
