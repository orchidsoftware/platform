<?php

namespace Orchid\Foundation\Http\Controllers\Install;

use Orchid\Foundation\Helpers\RequirementsChecker;
use Orchid\Foundation\Http\Controllers\Controller;

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
