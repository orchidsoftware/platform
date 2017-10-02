<?php

namespace Orchid\Platform\Http\Controllers\Install;

use Orchid\Platform\Http\Controllers\Install\Helpers\DatabaseManager;
use Orchid\Platform\Http\Controllers\Controller;

class DatabaseController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $response = $this->databaseManager->migrateAndSeed();

        return redirect()->route('install::administrator')
            ->with(['message' => $response]);
    }
}
