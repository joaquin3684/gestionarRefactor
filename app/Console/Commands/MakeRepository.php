<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeRepository extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repositorio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() === false) {
            return;
        }

        $this->createMapper();
        $this->createModel();
    }

    protected function createModel()
    {
        $a = $this->argument('name');
        $j = explode('Repo', $a);
        $this->call('make:model', [
            'name' => $j[0]
        ]);

        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }


    protected function createMapper()
    {
        $a = $this->argument('name');
        $j = explode('Repo', $a);
        $this->call('make:mapper', [
            'name' => $j[0].'Mapper'
        ]);
    }


    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $j = explode('Repo', $class);
        $p = str_replace('DummyClass', $class, $stub);
        $h = str_replace('DummyModel', $j[0], $p);
        return str_replace('DummyMapper', $j[0].'Mapper', $h);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../Stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

}
