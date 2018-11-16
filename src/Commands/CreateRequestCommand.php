<?php

namespace InfancyIt\Igloo\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use InfancyIt\Igloo\GeneratorClass;

class CreateRequestCommand extends GeneratorClass
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-request { name : Model Name }
                            {attributes : Model column names}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Form Request with attributes.';


    protected $namespace = 'Http\Requests\\';

    protected $files;

    protected $type = 'Request';

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
        $this->namespace .= $this->argument('name');
        $this->namespace .= '/';
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
            [
                'DummyNamespace',
                '/*DummyColumnValues*/',
                'DUMMYDATE'
            ],
            [
                'App\\'.$this->getNamespace($name),
                $this->getOptionalKey('attributes'),
                Carbon::now()->toDateTimeString()
            ],
            $stub
        );
        return $this;
    }


    protected function getOptionalKey($optional_key)
    {
        $fields = $this->argument($optional_key);
        $fields = explode(',', $fields);
        $result = "";
        foreach ($fields as $field)
        {
            if($field == 'id')
                ;
            else
                $result .= "\n            ".str_pad("'".$field."'", 25)."=> "."'required',";
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
        return $this->getOnlyClassName(null).'CreateRequest';
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
        $class = $this->getOnlyClassName($name);

        return str_replace('DummyCreateRequest', $class, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/DummyCreateRequest.stub';
    }
}
