<?php

namespace Orchid\Installer\Controllers;

use Illuminate\Routing\Controller;
use Orchid\Installer\Helpers\RequirementsChecker;

class RequirementsController extends Controller
{
    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $checker)
    {
        $this->requirements = $checker;
    }

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        $requirements = $this->requirements->check([
                'openssl',
                'pdo',
                'mbstring',
                'tokenizer',
            ]);

        return view('install::requirements', compact('requirements'));
    }
}
