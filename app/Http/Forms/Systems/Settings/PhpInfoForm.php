<?php

namespace Orchid\Http\Forms\Systems\Settings;

use Orchid\Forms\Form;

class PhpInfoForm extends Form
{
    /**
     * @var string
     */
    public $name = 'PHP info';

    /**
     * @var string
     */
    public $icon = 'fa fa-info';

    /**
     * Display Settings App.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get()
    {
        ob_start();
        phpinfo(-1);
        $phpInfo = ob_get_clean();

        $phpInfo = preg_replace([
            '#^.*<body>(.*)</body>.*$#ms',
            '#<h2>PHP License</h2>.*$#ms',
            '#<h1>Configuration</h1>#',
            "#\r?\n#",
            "#</(h1|h2|h3|tr)>#",
            '# +<#',
            "#[ \t]+#",
            '#&nbsp;#',
            '#  +#',
            '# class=".*?"#',
            '%&#039;%',
            '#<tr>(?:.*?)"src="(?:.*?)=(.*?)" alt="PHP Logo" /></a><h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
            '#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
            '#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
            "# +#",
            '#<tr>#',
            '#</tr>#',
        ], [
            '$1',
            '',
            '',
            '',
            '</$1>' . "\n",
            '<',
            ' ',
            ' ',
            ' ',
            '',
            ' ',
            '<h2>PHP Configuration</h2>' . "\n" . '<tr><td>PHP Version</td><td>$2</td></tr>' . "\n" . '<tr><td>PHP Egg</td><td>$1</td></tr>',
            '<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
            '<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" . '<tr><td>Zend Egg</td><td>$1</td></tr>',
            ' ',
            '%S%',
            '%E%',
        ], $phpInfo);

        $sections = explode('<h2>', strip_tags($phpInfo, '<h2><th><td>'));
        unset($sections[0]);

        $phpInfo = [];
        foreach ($sections as $section) {
            $heading = substr($section, 0, strpos($section, '</h2>'));

            preg_match_all(
                '#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',
                $section,
                $parts,
                PREG_SET_ORDER
            );

            foreach ($parts as $row) {
                if (!isset($row[2])) {
                    continue;
                } elseif ((!isset($row[3]) || $row[2] == $row[3])) {
                    $value = $row[2];
                } else {
                    $value = array_slice($row, 2);
                }

                if (
                    in_array($row[1], ['HTTP_COOKIE', 'Cookie', 'Set-Cookie', '_SERVER["HTTP_COOKIE"]']) ||
                    strpos($row[1], '_COOKIE[') !== false ||
                    strpos($row[1], '_REQUEST[') !== false
                ) {
                    continue;
                }

                $phpInfo[$heading][$row[1]] = $value;
            }
        }

        return view('dashboard::container.systems.settings.php', [
            'info' => $phpInfo,
        ]);
    }
}
