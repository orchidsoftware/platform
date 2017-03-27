<?php

namespace Orchid\Http\Controllers\Install\Helpers;

use Exception;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateAndSeed()
    {
        $this->sqlite();

        return $this->migrate();
    }

    /**
     * check database type. If SQLite, then create the database file.
     */
    private function sqlite()
    {
        if (DB::connection() instanceof SQLiteConnection) {
            $database = DB::connection()->getDatabaseName();
            if (!file_exists($database)) {
                touch($database);
                DB::reconnect(Config::get('database.default'));
            }
        }
    }

    /**
     * Run the migration and call the seeder.
     *
     * @return array
     */
    private function migrate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }

        return $this->seed();
    }

    /**
     * Return a formatted error messages.
     *
     * @param        $message
     * @param string $status
     *
     * @return array
     */
    private function response($message, $status = 'danger')
    {
        return [
            'status'  => $status,
            'message' => $message,
        ];
    }

    /**
     * Seed the database.
     *
     * @return array
     */
    private function seed()
    {
        try {
            Artisan::call('db:seed');
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }

        return $this->response(trans('messages.final.finished'), 'success');
    }
}
