<?php

namespace Orchid\Http\Controllers\Install\Helpers;

class InstalledFileManager
{
    /**
     * Update installed file.
     *
     * @return int
     */
    public function update()
    {
        return $this->create();
    }

    /**
     * Create installed file.
     *
     * @return int
     */
    public function create()
    {
        $env = file_get_contents(base_path('.env'));
        if (!str_contains($env, 'APP_INSTALL')) {
            $env = "APP_INSTALL=true\n" . $env;
        } else {
            $env = preg_replace('/APP_INSTALL=false/', 'APP_INSTALL=true', $env);
        }

        file_put_contents(base_path('.env'), $env);
    }
}
