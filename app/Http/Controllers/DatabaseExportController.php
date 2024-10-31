<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class DatabaseExportController extends Controller
{
    public function index()
    {
      if (Auth::user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Return a confirmation view (you can create this view)
    return rediect()->route('admin.dashboard'); // Make sure to create this view file
}

public function export()
{
    // Check if the user is an admin
    if (Auth::user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    $databaseName = env('DB_DATABASE');
    $user = env('DB_USERNAME');
    $password = env('DB_PASSWORD');
    $host = env('DB_HOST');

    // Define the output file path
    $outputFile = storage_path("app/exports/{$databaseName}_" . date('Y-m-d_H-i-s') . '.sql');

    // Run the mysqldump command
    $command = "mysqldump -u {$user} -p{$password} -h {$host} {$databaseName} > {$outputFile}";
    exec($command);

    // Check if the file exists and return it as a download
    if (file_exists($outputFile)) {
        return response()->download($outputFile)->deleteFileAfterSend(true);
    }

    return redirect()->route('admin.dashboard')->with('error', 'Failed to create the database export.');
}

}