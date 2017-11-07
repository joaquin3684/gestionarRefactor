<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeMapper extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:mapper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a mapper class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Mapper';

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

    }


    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $j = explode('Mapper', $class);
        $p = str_replace('DummyClass', $class, $stub);
        return str_replace('DummyModel', $j[0], $p);


    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../Stubs/mapper.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories\Mapper';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
}
