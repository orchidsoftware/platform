<?php


require "vendor/autoload.php";

function findTranslations($files)
{
    $functions = [
        '__',
    ];

    $stringPattern =                                    // See https://regex101.com/r/WEJqdL/6
        "[^\w]".                                        // Must not have an alphanum before real method
        '('.implode('|', $functions).')'.               // Must start with one of the functions
        "\(\s*".                                        // Match opening parenthesis
        "(?P<quote>['\"])".                             // Match " or ' and store in {quote}
        "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)".  // Match any string that can be {quote} escaped
        "\k{quote}".                                    // Match " or ' previously matched
        "\s*[\),]";                                     // Close parentheses or new parameter


    $keys = [];

    foreach ($files as $file) {
        if (preg_match_all("/$stringPattern/siU", file_get_contents($file), $matches)) {
            // Get all matches
            foreach ($matches["string"] as $key) {
                $keys[] = $key;
            }
        }
    }

    $keys = array_unique($keys);
    sort($keys);

    return $keys;
}

// $keys = findTranslations();
// dump($keys);

function glob_recursive($base, $pattern, $flags = 0)
{
    if (substr($base, -1) !== DIRECTORY_SEPARATOR) {
        $base .= DIRECTORY_SEPARATOR;
    }

    $files = glob($base.$pattern, $flags);
    if ($files === false) {
        $files = [];
    }

    foreach (glob($base.'*', GLOB_ONLYDIR | GLOB_NOSORT | GLOB_MARK) as $dir) {
        $dirFiles = glob_recursive($dir, $pattern, $flags);
        if ($dirFiles !== false) {
            $files = array_merge($files, $dirFiles);
        }
    }

    return $files;
}

$glob = glob_recursive("./src", "*");
$glob = array_merge(glob_recursive("./stub", "*"), $glob);

$glob = array_filter($glob, function ($f) {
    return is_file($f);
});

dump($glob);

$keys = findTranslations($glob);
dump($keys);
