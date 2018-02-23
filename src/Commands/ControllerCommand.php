<?php

namespace Farhad\Igloo\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Farhad\Igloo\GeneratorClass;

class ControllerCommand extends GeneratorClass
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-controller { name : Model Name }
                            {attributes : Model column names}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new controller.';


    protected $namespace = 'Http\Controllers\Api\\';

    protected $files;

    protected $type = 'Controller';

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
        $name = trim($this->argument('name'));
        $lower_name = strtolower($name[0]).substr($name, 1);
        $plural_name = str_plural($lower_name);
        $stub = str_replace(
            [
                'DummyNamespace',
                '/*DummyColumnValues*/',
                'DUMMYDATE',
                'DummyRequest',
                'dummyService',
                'DummyService',
                'DummyTransformer',
                'dummy_plural',
                'dummy',
                'Dummy',
                '/*FILLABLE*/'
            ],
            [
                $this->rootNamespace(),
                $this->getAttributeKey('attributes'),
                Carbon::now()->toDateTimeString(),
                $name.'Request',
                $lower_name.'Service',
                $name.'Service',
                $name.'Transformer',
                $plural_name,
                $lower_name,
                $name,
                $this->getAttributeKey('attributes')
            ],
            $stub
        );
        return $this;
    }


    protected function getAttributeKey($attribute_key)
    {
        $fields = trim($this->argument($attribute_key));
        $fields = explode(',', $fields);
        $result = "";
        foreach ($fields as $field)
        {
            if($field == 'id')
                ;
            else
                $result .= "'".$field."',";
        }
        $result = rtrim($result, ',');
        if($result=="''") return null;
        return $result;
    }



    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $this->model = trim($this->argument('name'));
        return $this->model . 'Controller';
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

        return str_replace('DummyController', $class, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/DummyController.php';
    }
}
