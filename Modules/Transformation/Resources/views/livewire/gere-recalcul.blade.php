<div>
    <button class="btn btn-primary" wire:click="startRecalcul">Lancer le calcul</button>
    @if($inProgress)
    <button class="btn btn-danger" wire:click="cancelCalcul">Arreter le calcul</button>
    @endif
    @if($inProgress)
        <div wire:poll.500ms style="width: 100%; background-color: transparent; position: relative;">
         
            <div class="w-100 mb-2" style="height: 35px">
                <x-ffast-progression-div :pourcentage="$nb_jours_batch->progress()" height="35px" style="div" text="Calcul du nombre de jours de validation"/>
            </div>
            <div class="w-100"  style="height: 35px">
                <x-ffast-progression-div :pourcentage="$tx_transfo_batch->progress()" height="35px" style="div"  text="Mise à jour des taux de transformation"/>
            </div>
        <div>
    @endif
</div>
