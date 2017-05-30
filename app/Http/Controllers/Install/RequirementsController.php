<?php

namespace Orchid\Http\Controllers\Install;

use Illuminate\Support\Facades\DB;
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
            'xml',
            'json',
        ]);

        $requirements = array_merge_recursive($this->database(), $requirements);

        return view('dashboard::container.install.requirements', compact('requirements'));
    }

    /**
     * Check connect database
     */
    public function database()
    {
        try {
            DB::connection()->getPdo();
            $results['requirements']['bd_connect'] = true;

            return $results;
        } catch (\Exception $exception) {
            $results['errors'] = true;
            $results['requirements']['bd_connect'] = false;

            return $results;
        }
    }
}
