<?php
/**
 * RepositoryFields.php.
 */

namespace Orchid\Platform\Core\Traits;

use Illuminate\Config\Repository;

/**
 * Class RepositoryFields.
 */
trait RepositoryFields
{
    /**
     * @return array
     */
    abstract public function getRepositoryFields(): array;

    /**
     * @param $name
     * @return Repository
     */
    public function getAttribute($name)
    {
        $value = parent::getAttribute($name);
        if (in_array($name, $this->getRepositoryFields())) {
            if (is_array($value)) {
                return new Repository($value);
            }
        }

        return $value;
    }
}
