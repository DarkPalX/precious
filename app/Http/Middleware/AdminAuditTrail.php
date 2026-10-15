<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuditTrail
{
    /**
     * Record admin-panel requests that perform database write operations.
     */
    public function handle(Request $request, Closure $next)
    {
        $databaseWrite = false;

        DB::listen(function ($query) use (&$databaseWrite) {
            $sql = ltrim(strtolower($query->sql));

            if (preg_match('/^(insert|update|delete|replace|alter|create|drop|truncate)\b/', $sql)) {
                $databaseWrite = true;
            }
        });

        $response = $next($request);

        if ($databaseWrite && auth()->check() && auth()->user()->role_id != 6 && auth()->user()->role_id != 2) {
            ActivityLog::create([
                'log_by' => auth()->id(),
                'activity_type' => 'request',
                'dashboard_activity' => $request->method() . ' ' . ($request->route()->getName() ?: $request->path()),
                'activity_desc' => $request->method() . ' request to ' . $request->path(),
                'activity_date' => now(),
                'db_table' => 'admin_request',
                'old_value' => null,
                'new_value' => null,
                'reference' => null,
                'action' => $request->method(),
                'page' => $request->route()->getName() ?: $request->path(),
                'url' => $request->fullUrl(),
                'status_code' => $response->getStatusCode(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}
