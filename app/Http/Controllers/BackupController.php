<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{

    public function index()
    {



        $backups = $this->backupsList();
        $mysqldump = $this->checkMysqlDump();

        return view('system.backups', [
            'backups' => $backups,
            'mysqldump' => $mysqldump,
        ]);
    }




    public function backup()
    {

        $notinstalled = $this->checkMysqlDump('true');

        if ($notinstalled == 'stop') {
            session()->flash('error',  'mysqldump is not installed!');
            return redirect()->route('backups');
        }

        $filename = "backup-" . config('database.connections.mysql.database') . '-' . Carbon::now()->format('Y-m-d-His') . ".gz";
        // use settings instead of env() function
        $command =  config('database.mysqldump_path') . " --user=" . config('database.connections.mysql.username') . " --password=" . config('database.connections.mysql.password') . " --host=" . config('database.connections.mysql.host') . " " . config('database.connections.mysql.database') . " | gzip > " . storage_path() . "/app/backup/" . $filename;

        $output = array();

        exec($command, $output, $worked);
        switch ($worked) {
            case 0:
                $answer =  'Database ' . config('database.connections.mysql.database') . ' successfully exported';
                break;
            case 1:
                $answer =  'There was a warning during the export';
                break;
            case 2:
                $answer =  'There was an error during export.';
                break;
        }


        session()->flash('message',  $answer);

        // redirect to the backup page and change the location to the backup page
        return redirect()->route('backups');
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


    public function checkMysqlDump($stop = false)
    {

        $answer =  'Mysqldump ...';

        // check to see if mysqldump is installed on the server

        $command = config('database.mysqldump_path') . ' --version';
        // $command = 'mysqldump --version';

        $output = array();

        exec($command, $output, $retval);
        switch ($retval) {
            case 0:
                $answer =  $output[0] . ' is installed';
                break;
            case 1:
                $answer =  'Mysqldump is not installed';
                if ($stop) {
                    return 'stop';
                }
                break;
            case 2:
                $answer =  'Mysqldump is not installed';
                if ($stop) {
                    return 'stop';
                }
                break;
            case 127:
                $answer =  'Mysqldump is not available. Check your mysqldump_path setting in .env file';
                if ($stop) {
                    return 'stop';
                }
                break;
        }

        return $answer;
    }
}
