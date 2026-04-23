<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SQLDataSeeder extends Seeder
{
    public function run(): void
    {
        $sqlPath = database_path('gym_management.sql');
        if (!File::exists($sqlPath)) {
            $this->command->error("SQL file not found at $sqlPath");
            return;
        }

        $sql = File::get($sqlPath);

        // Split by semicolon (roughly, might be issues with semicolons in strings but usually okay for standard dumps)
        // A better way is to look for INSERT INTO statements
        
        preg_match_all('/INSERT INTO `[^`]+` \([^)]+\) VALUES.*?;/s', $sql, $matches);

        if (empty($matches[0])) {
            $this->command->error("No INSERT statements found in SQL file.");
            return;
        }

        $this->command->info("Found " . count($matches[0]) . " INSERT statements. Executing...");

        // Disable foreign key checks for seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($matches[0] as $statement) {
            try {
                // Determine table name for logging
                if (preg_match('/INSERT INTO `([^`]+)`/', $statement, $tableNameMatch)) {
                    $tableName = $tableNameMatch[1];
                    // Skip 'migrations' table data to avoid messing with Laravel's migration state
                    if ($tableName === 'migrations') {
                        continue;
                    }
                    $this->command->line("Seeding table: $tableName");
                }
                
                DB::unprepared($statement);
            } catch (\Exception $e) {
                $this->command->warn("Error executing statement: " . $e->getMessage());
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info("SQL data seeding completed.");
    }
}
