<?php

namespace App\Http\Controllers\Admin;

use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLogsController extends Controller
{
    public function listItems()
    {
        $oLogs = Log::orderBy('created_at', 'DESC')->get();

        return view('admin.logs.list', [
            'arrObjects' => $oLogs
        ]);
    }

    public function editItems(Request $request, $logID = null)
    {
        $oLog = Log::where('logID', $logID)->first();

        return view('admin.logs.edit', [
            'oLog' => $oLog
        ]);
    }

    public function deleteItems()
    {
        Log::truncate();

        return redirect()->route('admin_logs_list');
    }
}
