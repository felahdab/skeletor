<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

use App\CentralObjects\Tenant;
use Illuminate\Support\Facades\Storage;

class SkeletorCreateTenantCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:create-tenant {tenantid : le slug du tenant a creer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lorsque l application est en mode multi tenant, permet de creer un nouveau tenant.';

    

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! config('skeletor.multi_tenancy')){
            $this->fail('Cette commande n a pas de sens: Skeletor est configure en mono tenant.');
        }

        $tenant_slug =  $this->argument('tenantid');

        $tenant = Tenant::create(['id' => $tenant_slug]);

        tenancy()->initialize($tenant);

        // Il faut aussi creer le dossier de cache suivant: (notamment pour le preview Livewire)
        ///app/storage/instancecourbet/framework/cache/
        Storage::disk('framework_cache')->makeDirectory('framework/cache/');

        // Il faut aussi s'occuper des assets:
        //- Google fonts

        tenancy()->end();
    }
}
