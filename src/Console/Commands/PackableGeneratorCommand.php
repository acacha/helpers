<?php

namespace Acacha\Helpers\Console\Commands;

use Illuminate\Support\Str;

/**
 * Class PackableGeneratorCommand.
 *
 * @package App\Console\Commands
 */
trait PackableGeneratorCommand
{
    /**
     * Get package namespace.
     *
     * @return string
     */
    abstract protected function getPackageNamespace();

    /**
     * Get destination.
     *
     * @return string
     */
    abstract protected function getDestination();

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->getPackageNamespace(), '', $name);

        return base_path() . $this->getDestination() . '/'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function parseName($name)
    {
        $rootNamespace = $this->getPackageNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name);
    }
}