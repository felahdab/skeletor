<?php

namespace App\Console\Commands;

use App\Models\SkeletorUsageLog;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DisplayMostUsedRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:display-most-used-routes-command {--user-email=*}
                                                                    {--method=*}
                                                                    {--route=}
                                                                    {--status=}
                                                                    {--ip=}
                                                                    {--after-date=}
                                                                    {--before-date=}
                                                                    {--on-date=}
                                                                    {--sort=-last_used}
                                                                    {--group=*}
                                                                    {--limit=20}
                                                                    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Affiche un tableau des routes les plus utilisees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = SkeletorUsageLog::query();

        if ($this->option('group')) {
            $query->select($this->option('group'))
                ->addSelect(DB::raw('MAX(updated_at) as last_used'))
                ->addSelect(DB::raw('SUM(counter) as counter'));
        }

        $this->applyFilters($query);
        $this->applyGrouping($query);
        $this->applySorting($query);

        $results = $query->limit($this->option('limit'))->get();

        $this->table(
            $this->getFields(),
            $results->toArray()
        );

        return Command::SUCCESS;
    }

    protected function applyFilters(Builder $query): Builder
    {
        return $query->when(!empty($this->option('user-email')), function (Builder $query) {
            $query->whereIn('user-email', $this->option('user-email'));
        })->when(!empty($this->option('method')), function (Builder $query) {
            $query->whereIn('method', $this->option('method'));
        })->when(!empty($this->option('route')), function (Builder $query) {
            $query->where('route', 'LIKE', $this->option('route'));
        })->when(!empty($this->option('status')), function (Builder $query) {
            $query->where('status', 'LIKE', $this->option('status'));
        })->when(!empty($this->option('ip')), function (Builder $query) {
            $query->where('ip', 'LIKE', $this->option('ip'));
        })->when(!empty($this->option('after-date')), function (Builder $query) {
            $query->where('updated_at', '>=', $this->option('after-date'));
        })->when(!empty($this->option('before-date')), function (Builder $query) {
            $query->where('updated_at', '<=', $this->option('before-date'));
        })->when(!empty($this->option('on-date')), function (Builder $query) {
            $query->whereDate('updated_at', $this->option('on-date'));
        });
    }

    protected function applyGrouping(Builder $query): Builder
    {
        return $query->when($this->option('group'), function (Builder $query) {
            $query->groupBy($this->option('group'));
        });
    }

    protected function applySorting(Builder $query): Builder
    {
        $sort = $this->option('sort');
        if (Str::contains($sort, 'last_used')) {
            $sort = Str::replace('last_used', 'updated_at', $sort);
        }

        if (Str::startsWith($sort, '-')) {
            $sort = substr($sort, 1);
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        return $query->orderBy($sort, $order);
    }

    protected function getFields(): array
    {
        if ($this->option('group')) {
            return array_merge($this->option('group'), ['last_used', 'counter']);
        }

        return [
            'id',
            'uri',
            'session',
            'source',
            'user-agent',
            'user-email',
            'status',
            'ip',
            'method',
            'counter',
            'updated_at',
            // 'counter'
        ];
    }
}
