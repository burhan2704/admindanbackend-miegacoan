<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncSequence extends Command
{
    protected $signature = 'sync:sequence {--table=}';

    protected $description = 'Sync PostgreSQL sequences with MAX(id) value of their tables';

    public function handle()
    {
        $tableArg = $this->option('table');

        $tables = $tableArg ? [$tableArg] : $this->getAllTablesWithId();

        foreach ($tables as $table) {
            $sequenceName = DB::selectOne("SELECT pg_get_serial_sequence(?, 'id') AS seq", [$table]);

            if (!$sequenceName || !$sequenceName->seq) {
                $this->warn("⚠️  Sequence for `$table.id` not found or not serial.");
                continue;
            }

            $maxId = DB::table($table)->max('id') ?? 0;

            DB::statement("SELECT setval(?, ?, true)", [
                $sequenceName->seq,
                $maxId,
            ]);

            $this->info("✅ Synced sequence `{$sequenceName->seq}` to $maxId for table `$table`.");
        }

        $this->info("🎉 Sequence sync completed.");
    }

    protected function getAllTablesWithId()
    {
        $schema = 'public'; // sesuaikan jika schema kamu berbeda

        $tables = DB::select("
            SELECT table_name
            FROM information_schema.columns
            WHERE column_name = 'id' AND table_schema = ?
        ", [$schema]);

        return collect($tables)->pluck('table_name')->map(fn($t) => "$schema.$t")->toArray();
    }
}
