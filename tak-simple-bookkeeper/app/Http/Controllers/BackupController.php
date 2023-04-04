<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{

    public function index()
    {
        $backups = $this->backupsList();
        return view('system.backups', [
            'backups' => $backups,
        ]);
    }


    public function backup()
    {
        Artisan::call('database:backup');
        return 'created a backup yes';
    }



    protected function backupsList()
    {
        // list all the backup files in the storage/app/backup folder
        $files = File::files(storage_path('app/backup'));
        $backups = [];

        foreach ($files as $key => $value) {
            $backups[$key]['file_name'] = $value->getFilename();
            $backups[$key]['file_size'] = $value->getSize();
            $backups[$key]['last_modified'] = date("F d Y, h:i:s A", $value->getMTime());
        }
        return $backups;
    }



    public function restore($file_name)
    {

        $returnVar = NULL;
        $output = NULL;

        // copy the file first and remove the .gz extension form the new file
        $extract_file_name = 'restore_' . $file_name;
        File::copy(storage_path() . '/app/backup/' . $file_name, storage_path() . '/app/backup/' . $extract_file_name);

        // first unzip the file
        $command = 'gunzip ' . storage_path() . '/app/backup/' . $extract_file_name;
        exec($command, $output, $returnVar);

        // remove the .gz extension from the file name
        $extract_file_name = str_replace('.gz', '', $extract_file_name);

        // restore the database
        $command = 'mysql --user=' . config('database.connections.mysql.username') . ' --password=' . config('database.connections.mysql.password') . ' --binary-mode=1  ' . config('database.connections.mysql.database') . ' < ' . storage_path() . '/app/backup/' . $extract_file_name;
        exec($command, $output, $returnVar);

        // remove the extracted file
        File::delete(storage_path() . '/app/backup/' . $extract_file_name);

        session()->flash('message', 'Hersteld: ' . $file_name);

        // redirect to the backup page and change the location to the backup page
        return redirect()->route('backups');
    }
}
