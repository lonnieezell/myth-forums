<?php namespace App\Core;

class Modules
{
    /**
     * ModuleFile instance cache
     *
     * @var array
     */
    protected $moduleFiles = [];

    public function __construct()
    {
        helper('filesystem');
    }

    public function initAdmin()
    {
        $this->locateInfoFiles();

        // Init each module
        foreach($this->moduleFiles as $moduleFile)
        {
            $moduleFile->initAdmin();
        }
    }

    /**
     * Searches our app\Modules folder to locate and instantiate
     * any Module info files, named simply 'Module';
     */
    protected function locateInfoFiles(): void
    {
        // No need to do it twice...
        if (count($this->moduleFiles))
        {
            return;
        }

        $map = directory_map(APPPATH . 'Modules/', 2);

        foreach ($map as $folder => $module)
        {
            if (! is_array($module) || ! array_search('Module.php', $module))
            {
                continue;
            }

            $path = APPPATH . "Modules/{$folder}/Module.php";
            if (! file_exists($path))
            {
                continue;
            }

            $folder = rtrim($folder, '/ ');
            $locater = service('locator');
            $class = $locater->getClassName($path);

            if (! class_exists($class))
            {
                continue;
            }

            $this->moduleFiles[$folder] = new $class();
        }
    }
}
