<?php

# adapted from https://github.com/barryvdh/laravel-translation-manager
function find_translation_keys(): array
{
    $files = glob_recursive("./src", "*");
    $files = array_merge(glob_recursive("./stubs", "*"), $files);
    $files = array_merge(glob_recursive("./resources/views", "*"), $files);
    $files = array_filter($files, function ($f) {
        return is_file($f);
    });

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
        $content = file_get_contents($file);
        if (false === $content) {
            throw new \RuntimeException('Error reading file: '. $file);
        }
        if (preg_match_all("/$stringPattern/siU", $content, $matches)) {
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


# https://gist.github.com/UziTech/3b65b2543cee57cd6d2ecfcccf846f20
function glob_recursive($base, $pattern, $flags = 0): array
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


function read_locale_from_resources(): array
{
    $json_files = glob('resources/lang/*.json');
    $locales = [];
    foreach ($json_files as $json_file) {
        $locale_name = basename($json_file, '.json');
        $locales[$locale_name] = json_decode(file_get_contents($json_file), true);
    }

    return $locales;
}


function sync_translations($translations, $keys): array
{
    $new_translations = [];

    foreach ($keys as $key) {
        foreach ($translations as $locale => $translation) {
            if (array_key_exists($key, $translation)) {
                $new_translations[$locale][$key] = trim($translation[$key]);
            } else {
                $new_translations[$locale][$key] = "[*]".$key;
            }
        }
    }

    return $new_translations;
}


function summary($new_translations, $old_translations)
{
    echo "# Missing keys:".PHP_EOL;
    foreach ($new_translations as $locale => $new_translation) {
        echo "## $locale: ".PHP_EOL;
        foreach (array_diff_key($new_translation, $old_translations[$locale]) as $key => $_) {
            echo "### $key" . PHP_EOL;
        }
        echo PHP_EOL;
    }

    echo PHP_EOL;

    echo "# Deleted keys:".PHP_EOL;
    foreach ($new_translations as $locale => $new_translation) {
        echo "## $locale: ".PHP_EOL;
        foreach (array_diff_key($old_translations[$locale], $new_translation) as $key => $_) {
            echo "### $key" . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

function main()
{
    $old_translations = read_locale_from_resources();
    $keys = find_translation_keys();
    $new_translations = sync_translations($old_translations, $keys);

    foreach ($new_translations as $locale => $translation) {
        file_put_contents("./resources/lang/".$locale.'.json',
        json_encode($translation, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    summary($new_translations, $old_translations);
}

main();
