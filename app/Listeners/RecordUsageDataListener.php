<?php

namespace App\Listeners;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

use App\Models\SkeletorUsageLog;

class RecordUsageDataListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RequestHandled $event): void
    {
        $request = $event->request;
        $response = $event->response;

        if (!config('analytics.enabled')) {
            return;
        }

        if (in_array($request->method(), config('analytics.ignoreMethods', []))) {
            return;
        }

        if (in_array($request->ip(), config('analytics.ignoredIPs', []))) {
            return;
        }

        foreach (config('analytics.exclude', []) as $except) {
            if (!Str::contains($except, env('APP_PREFIX'))) {
                $prefix = Str::startsWith($except,'/') ? env('APP_PREFIX')  : env('APP_PREFIX') . '/';
                $except = $prefix . $except;
            }

            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return;
            }
        }

        $uri = str_replace($request->root(), '', $request->url()) ?: '/';
        $user_name = $request->user()?->email ?? 'anonyme';

        SkeletorUsageLog::firstOrCreate([
            'uri'        => $uri,
            'route'      => $request->route()?->getName() ?? 'unnamed_route',
            'session'    => $request->session()->getId(),
            'source'     => $request->headers->get('referer'),
            'user-agent' => $request->userAgent(),
            'user-email' => $user_name,
            'status'     => $response->getStatusCode(),
            'ip'         => $request->ip(),
            'method'     => $request->getMethod(),
        ], ['counter' => 0])->increment('counter', 1);
    }
}
