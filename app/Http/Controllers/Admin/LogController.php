<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(Request $request): Response
    {
        $logs = Activity::with('causer')
            ->when($request->log_name, fn($q, $n) => $q->where('log_name', $n))
            ->when($request->causer_id, fn($q, $id) => $q->where('causer_id', $id))
            ->latest()
            ->paginate(30)
            ->through(fn($log) => [
                'id'           => $log->id,
                'log_name'     => $log->log_name,
                'description'  => $log->description,
                'subject_type' => $log->subject_type,
                'subject_id'   => $log->subject_id,
                'properties'   => $log->properties,
                'causer'       => $log->causer ? [
                    'id'        => $log->causer->id,
                    'full_name' => $log->causer->full_name,
                ] : null,
                'created_at'   => $log->created_at->translatedFormat('d/m/Y H:i'),
            ]);

        return Inertia::render('Admin/Logs/Index', compact('logs'));
    }
}