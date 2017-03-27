<?php

namespace Orchid\Http\Controllers\Install;

use Orchid\Http\Controllers\Controller;
use Orchid\Http\Controllers\Install\Helpers\RequirementsChecker;

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
            'zip',
        ]);

        return view('dashboard::container.install.requirements', compact('requirements'));
    }
}
