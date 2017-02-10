<?php

namespace Orchid\Defender;

class Defender
{
    /**
     * Name the files to be excluded during the validation.
     *
     * @var array
     */
    public $exceptionsValid = [
        '.blade.php',
    ];

    /**
     * File extensions that will be scanned.
     *
     * @var array
     */
    public $extensions = [];

    /**
     * Typical signs of virus.
     *
     * @var array
     */
    public $signatures = [];
    /**
     * Scan directory.
     *
     * @var null|string
     */
    public $dir;
    /**
     * @var array
     */
    public $notValid = [];
    /**
     * @var array
     */
    public $dangerFiles = [];
    /**
     * Scanned files.
     *
     * @var array
     */
    private $files = [];

    /**
     * Defender constructor.
     *
     * @param null $dir
     */
    public function __construct($dir = null)
    {
        if (is_null($dir)) {
            $dir = public_path();
        }
        $this->dir = $dir;

        $this->getDirContents($this->dir, $this->files);
    }

    /**
     * @param $dir
     * @param array $results
     *
     * @return array
     */
    private function getDirContents($dir, array &$results = [])
    {
        $files = scandir($dir);

        foreach ($files as  $value) {
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else {
                if ($value != '.' && $value != '..') {
                    $this->getDirContents($path, $results);
                    $results[] = $path;
                }
            }
        }

        return $results;
    }

    /**
     * Scans for possible dangerous problems.
     *
     * @return $this
     */
    public function scan()
    {
        $files = $this->extensionsFile($this->files);

        foreach ($files as $file) {
            $content = file_get_contents($file);

            if (!str_contains($file, $this->exceptionsValid) && !$this->checkForValidPhp($content)) {
                $this->notValid[] = $file;
            }

            if (str_contains($content, $this->signatures)) {
                $this->dangerFiles[] = $file;
            }
        }

        return $this;
    }

    /**
     * @param $files
     *
     * @return array
     */
    private function extensionsFile(array $files)
    {
        $extensionsFiles = [];
        foreach ($files as $file) {
            if (str_contains($file, $this->extensions)) {
                $extensionsFiles[] = $file;
            }
        }

        return $extensionsFiles;
    }

    /**
     * @param $content
     *
     * @return bool
     */
    private function checkForValidPhp($content)
    {
        $len = strlen($content);
        $start = 0;
        $valid = false;
        while (($start = strpos($content, '<?', $start)) !== false) {
            $valid = true;
            $start++;
            $end = strpos($content, '?>', $start + 1);
            if ($end === false) {
                $end = $len;
            }
            while (++$start < $end) {
                $c = ord($content[$start]);
                if ($c < 9 || ($c >= 14 && $c <= 31) || $c == 11 || $c == 12) {
                    return false;
                }
            }
        }

        return $valid;
    }

    /**
     * @param array $signatures
     *
     * @return $this
     */
    public function loadSignatures(array $signatures)
    {
        $this->signatures = $signatures;

        return $this;
    }

    /**
     * @param array $extensions
     *
     * @return $this
     */
    public function loadExtensions(array $extensions)
    {
        $this->extensions = $extensions;

        return $this;
    }

    /**
     * @param array $exceptionsValid
     *
     * @return $this
     */
    public function loadExceptionsValid(array $exceptionsValid)
    {
        $this->exceptionsValid = $exceptionsValid;

        return $this;
    }

    /**
     * @return array
     */
    public function infoDanger()
    {
        $files = [];
        foreach ($this->dangerFiles as $file) {
            $files[] = stat($file);
        }

        return $files;
    }

    /**
     * @return $this
     */
    public function export()
    {
        $export = new Export();
        $export->export($this);

        return $this;
    }
}
