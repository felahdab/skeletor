<?php

namespace App\Listeners;

use Exception;
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
                $prefix = Str::startsWith($except, '/') ? env('APP_PREFIX')  : env('APP_PREFIX') . '/';
                $except = $prefix . $except;
            }

            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return;
            }
        }

        $sessionid = 'no_session_id';
        try {
            $sessionid = $request->session()?->getId();
        } catch (Exception) {
        }


        $uri = str_replace($request->root(), '', $request->url()) ?: '/';
        $user_name = $request->user()?->email ?? 'anonyme';

        $s = SkeletorUsageLog::firstOrCreate([
            'uri'        => $uri,
            'route'      => $request->route()?->getName() ?? 'unnamed_route',
            'session'    => $sessionid,
            'source'     => $request->headers->get('referer'),
            'user-agent' => $request->userAgent(),
            'user-email' => $user_name,
            'status'     => $response->getStatusCode(),
            'ip'         => $request->ip(),
            'method'     => $request->getMethod(),
        ], ['counter' => 0]);
        $s->fill(['response_time' =>  $request->responsetime ?? 0]);
        $s->increment('counter', 1);
        $s->save();
    }
}
