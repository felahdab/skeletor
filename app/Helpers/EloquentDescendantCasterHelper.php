<?php

if (!function_exists('cast_as_eloquent_descendant')) {
    /**
     * Cette méthode permet de résoudre le problème de caster un modèle Eloquent dans un classe descendante.
     *
     * Par exemple, si dans un module on étend le modèle User de Skeletor parce qu'on souhaite rajouter des relations
     * qui n'existent quand dans le contexte de ce module, on peut utiliser:
     *
     * $module_user = cast_as_eloquent_descendant($user, \Modules\Module\Models\User::class);
     *
     * Ceci évite de devoir refaire une requête en base de données pour recaster explicitement le modèle avec la bonne
     * classe.
     *
     * @param mixed $model
     * @param mixed $destination_class
     */
    function cast_as_eloquent_descendant($model, $destination_class)
    {
        if (null == $model) {
            return null;
        }
        $ret = new $destination_class();
        $ret->forceFill($model->toArray());

        return $ret;
    }
}
