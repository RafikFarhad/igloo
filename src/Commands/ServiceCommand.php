<?php

namespace Farhad\Igloo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Farhad\Igloo\GeneratorClass;
use Carbon\Carbon;

class ServiceCommand extends GeneratorClass
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-service { name : Model Name }
                                         { attributes : Model column names}'
                                        ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new service.';


    protected $namespace = 'Services/';

    protected $files;

    protected $type = 'Service';

    protected $model = '';

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
        return $this->namespace . $name . 'Service';
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
        $onlyClassName = preg_replace('/Service$/', '', $this->getOnlyClassName($name));
        $lower_name = strtolower($onlyClassName[0]).substr($onlyClassName, 1);
        $plural_name = str_plural($lower_name);
        $stub = str_replace([
            'NamespaceFor',
            'DummyNamespace',
            '/*DummyColumnValues*/',
            'DUMMYDATE',
            'DummyCreateRequest',
            'DummyUpdateRequest',
            'dummyService',
            'DummyService',
            'NamespacedDummyRepository',
            'DummyRepository',
            'dummyRepository',
            'NamespacedDummyTransformer',
            'DummyTransformer',
            'dummy_plural',
            'dummy',
            'Dummy',
            '/*FILLABLE*/'
        ], [
            str_replace('/', '\\', $this->argument('name')),
            'App\\'.$this->getNamespace($name),
            $this->getAttributeKey('attributes'),
            Carbon::now()->toDateTimeString(),
            $onlyClassName.'CreateRequest',
            $onlyClassName.'UpdateRequest',
            $lower_name.'Service',
            $onlyClassName.'Service',
            $this->modelWithDefaultNamespace($name).'Repository',
            $onlyClassName . 'Repository',
            $lower_name . 'Repository',
            $this->modelWithDefaultNamespace().'Transformer',
            $onlyClassName.'Transformer',
            $plural_name,
            $lower_name,
            $onlyClassName,
            $this->getAttributeKey('attributes'),
        ],
            $stub
        );
        return $this;
    }


    protected function modelWithDefaultNamespace()
    {
        return rtrim(str_replace('/', '\\', $this->getNameInput()), '\\');
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
        $class = $this->getOnlyClassName($name) . 'Service';
        return str_replace('DummyService', $class, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/DummyService.stub';
    }
}
