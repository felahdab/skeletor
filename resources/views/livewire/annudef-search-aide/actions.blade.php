<div class="btn-group" role="groupe">
    <button @click="
    $dispatch('preset-this-user', { nom    : '{{ htmlspecialchars($user['nom'] , ENT_QUOTES) }}', 
                                    prenom : '{{ htmlspecialchars($user['prenomusuel'], ENT_QUOTES) }}', 
                                    nid    : '{{ htmlspecialchars($user['nid'] , ENT_QUOTES)}}',
                                    email  : '{{ htmlspecialchars($user['email'] , ENT_QUOTES) }}',
                                    grade  : '{{ htmlspecialchars(Str::ascii( $user['gradelong'], ENT_QUOTES ) ) }}' });"
    class='btn btn-primary btn-sm'>></button>
</div>