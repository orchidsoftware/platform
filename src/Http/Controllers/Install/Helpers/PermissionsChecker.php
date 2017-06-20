<?php

namespace Orchid\Http\Controllers\Install\Helpers;

class PermissionsChecker
{
    /**
     * @var array
     */
    protected $results = [
        'permissions' => [],
        'errors'      => null,
    ];

    /**
     * Check for the folders permissions.
     *
     * @param array $folders
     *
     * @return array
     */
    public function check(array $folders)
    {
        foreach ($folders as $folder => $permission) {
            if (!($this->getPermission($folder) >= $permission)) {
                $this->addFileAndSetErrors($folder, $permission, false);
            } else {
                $this->addFile($folder, $permission, true);
            }
        }

        return $this->results;
    }

    /**
     * Get a folder permission.
     *
     * @param $folder
     *
     * @return string
     */
    private function getPermission($folder)
    {
        return substr(sprintf('%o', fileperms(base_path($folder))), -4);
    }

    /**
     * Add the file and set the errors.
     *
     * @param $folder
     * @param $permission
     * @param $isSet
     */
    private function addFileAndSetErrors($folder, $permission, $isSet)
    {
        $this->addFile($folder, $permission, $isSet);

        $this->results['errors'] = true;
    }

    /**
     * Add the file to the list of results.
     *
     * @param $folder
     * @param $permission
     * @param $isSet
     */
    private function addFile($folder, $permission, $isSet)
    {
        array_push($this->results['permissions'], [
            'folder'     => $folder,
            'permission' => $permission,
            'isSet'      => $isSet,
        ]);
    }
}
