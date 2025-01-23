<?php
 
namespace App\Jobs\Middleware;
 
use Closure;
use Illuminate\Support\Facades\Redis;
 
class RateLimited
{
    public function __construct(public int $delay = 5)
    {}
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        Redis::throttle('key')
                ->block(0)->allow(1)->every($this->delay)
                ->then(function () use ($job, $next) {
                    // Lock obtained...
 
                    $next($job);
                }, function () use ($job) {
                    // Could not obtain lock...
 
                    $job->release($this->delay);
                });
    }
}