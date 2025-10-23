<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupToJson extends Command
{
    protected $signature = 'backup:json {tables?*}';
    protected $description = 'Backup database tables to JSON files';

    public function handle()
    {
        // Jika tabel spesifik diberikan, gunakan itu. Jika tidak, ambil semua tabel.
        $tables = $this->argument('tables') ?: $this->getAllTables();
        $backupPath = 'database/backups/json/';

        foreach ($tables as $table) {
            try {
                // Fetch data dari tabel
                $data = DB::table($table)->get();
                
                // Simpan data ke JSON
                Storage::put($backupPath . $table . '.json', $data->toJson(JSON_PRETTY_PRINT));
                $this->info("Table '{$table}' has been backed up.");
            } catch (\Exception $e) {
                $this->error("Failed to backup table '{$table}': " . $e->getMessage());
            }
        }

        $this->info('Backup completed.');
    }

    /**
     * Mendapatkan daftar semua tabel dalam database.
     *
     * @return array
     */
    private function getAllTables()
    {
        // Bergantung pada database yang digunakan
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            $query = "SHOW TABLES";
            $key = 'Tables_in_' . env('DB_DATABASE');
        } elseif ($driver === 'pgsql') {
            $query = "SELECT tablename FROM pg_tables WHERE schemaname = 'public'";
            $key = 'tablename';
        } else {
            throw new \Exception("Database driver '{$driver}' is not supported.");
        }

        $tables = DB::select($query);
        return collect($tables)->pluck($key)->toArray();
    }
}
