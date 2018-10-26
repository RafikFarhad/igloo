<?php

namespace Farhad\Igloo\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Farhad\Igloo\GeneratorClass;

class RepositoryCommand extends GeneratorClass
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-repo { name : Model Name }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new repository.';


    protected $namespace = 'Repositories/';

    protected $files;

    protected $type = 'Repository';

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
        $stub = str_replace(
            [
                'DummyNamespace',
                'DummyModelWithClass',
                'DummyModel',
                'DUMMYDATE'
            ], [
                $this->getNamespace($name),
                $this->modelWithClass($name),
                $this->modelWithDefaultNamespace($name),
                Carbon::now()->toDateTimeString()
            ],
            $stub
        );
        return $this;
    }

    protected function modelWithClass($name)
    {
        return $this->getOnlyClassName($name) . '::class';
    }

    protected function modelWithDefaultNamespace($name)
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
        $class = $this->getOnlyClassName($name) . 'Repository';

        return str_replace('DummyRepository', $class, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/DummyRepository.stub';
    }
}
