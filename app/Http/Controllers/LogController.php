<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Traits\LogsActivityHelper;

class LogController extends Controller
{
    use LogsActivityHelper;

    public function index(Request $request)
    {
        $logs = Activity::with('causer')
            ->latest()
            ->paginate(20)
            ->through(function ($log) {
                return [
                    'id' => $log->id,
                    'date' => $log->created_at->format('Y-m-d'),
                    'time' => $log->created_at->format('H:i:s'),
                    'user' => $log->causer ? $log->causer->name : '-',
                    'menu' => $log->log_name,
                    'action' => $log->description,
                    'device' => $log->properties['user_agent'] ?? '-',
                    'ip' => $log->properties['ip'] ?? '-',
                ];
            });
        $this->logActivity('viewed logs list');
        return Inertia::render('Logs/Index', [
            'logs' => $logs,
        ]);
    }

    public function destroy($id)
    {
        $log = \Spatie\Activitylog\Models\Activity::findOrFail($id);
        $log->delete();
        $this->logActivity('deleted log', $log);
        return redirect()->route('logs.index')->with('success', 'Log deleted successfullyw!');
    }
}
