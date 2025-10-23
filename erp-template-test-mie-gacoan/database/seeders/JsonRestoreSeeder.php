<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JsonRestoreSeeder extends Seeder
{
    public function run()
    {
        $backupPath = 'database/backups/json/';
        $files = Storage::files($backupPath);

        foreach ($files as $file) {
            $table = basename($file, '.json');
            $data = json_decode(Storage::get($file), true);

            if ($data) {
                DB::table($table)->truncate(); // Optional: Clear the table before seeding
                DB::table($table)->insert($data);
                $this->command->info("Table {$table} has been restored.");
            }
        }
    }
}
