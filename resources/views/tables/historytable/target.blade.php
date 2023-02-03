@php
$event_details = json_decode($row->event_details, $associative=true);

if (array_key_exists("sous_objectif", $event_details))
    {
    $target = "Sous-objectif: " . $event_details["sous_objectif"]["ssobj_lib"];
    }
elseif (array_key_exists("tache", $event_details))
    {
    $target="Tache: " . $event_details["tache"]["tache_libcourt"];
    }
    
elseif (array_key_exists("stage", $event_details))
    $target = "Stage: " . $event_details["stage"]["stage_libcourt"];
    
elseif (array_key_exists("fonction", $event_details))
    $target = "Fonction: " .$event_details["fonction"]["fonction_libcourt"];

else
    $target = "Non reconnu";
@endphp

{{ $target }}