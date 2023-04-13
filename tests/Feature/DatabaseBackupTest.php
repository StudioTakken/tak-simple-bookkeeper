<?php

use App\Http\Controllers\BackupController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;


it('can find mysqldump', function () {

    $responce = (new BackupController())->checkMysqlDump();
    // assert that the responce contains ' is installed';
    expect($responce)->toContain('is installed');
});


it('can create a backup', function () {

    $this->artisan('database:backup')->assertExitCode(0);
    $filename = "backup-" . config('database.connections.mysql.database') . '-' . Carbon::now()->format('Y-m-d-His') . ".gz";
    $backupFile = storage_path('app/backup/' . $filename);

    // assert that the backup file exists
    expect(File::exists($backupFile))->toBeTrue();
    // assert that the backup file is not empty
    expect(File::size($backupFile))->toBeGreaterThan(0);
})->group('backup');
