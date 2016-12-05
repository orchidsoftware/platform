<?php

namespace Orchid\Installer\Helpers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\SQLiteConnection;

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

    /**
     * Return a formatted error messages.
     *
     * @param $message
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
     * check database type. If SQLite, then create the database file.
     */
    private function sqlite()
    {
        if (DB::connection() instanceof SQLiteConnection) {
            $database = DB::connection()->getDatabaseName();
            if (! file_exists($database)) {
                touch($database);
                DB::reconnect(Config::get('database.default'));
            }
        }
    }
}
