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
    protected function getPackageNamespace() {
        return config('package.namespace',null) != null ? config('package.namespace') : env('PACKAGE_NAMESPACE', null) ;
    }

    /**
     * Get destination.
     *
     * @return string
     */
    protected function getDestination() {
        return config('package.src_path',null) != null ? config('package.src_path') :
            env('PACKAGE_SRC_PATH', null) ;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->getPackageNamespace(), '', $name);
        $this->checkDestination();
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
        $this->checkNamespace();

        $rootNamespace = $this->getPackageNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name);
    }

    /**
     * Check namespace.
     */
    private function checkNamespace() {
        if ($this->getPackageNamespace() == null) {
            $this->error(
                'No package namespace specified neither on config/package.php file or PACKAGE_NAMESPACE env variable');
            die();
        }
    }

    /**
     * Check destination.
     */
    private function checkDestination() {
        if ($this->getDestination() == null) {
            $this->error(
                'No package destination specified neither on config/package.php file or PACKAGE_SRC_PATH env variable');
            die();
        }
    }
}