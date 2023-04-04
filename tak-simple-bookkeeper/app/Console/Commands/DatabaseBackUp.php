<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;


// You can add following line to your crontab file. you have to change folder path.
// * * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1
// OR
// * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

// or we can run 
// php artisan database:backup


class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backitup baby';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "backup-" . config('database.connections.mysql.database') . '-' . Carbon::now()->format('Y-m-d-His') . ".gz";

        // use settings instead of env() function
        $command = "mysqldump --user=" . config('database.connections.mysql.username') . " --password=" . config('database.connections.mysql.password') . " --host=" . config('database.connections.mysql.host') . " " . config('database.connections.mysql.database') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
    }
}
