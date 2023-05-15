<div class="btn-group" role="groupe">
    <button @click="
    console.log('{{ $user['gradelong'] }}');
    $dispatch('preset-this-user', { nom    : '{{ htmlspecialchars($user['nom'] , ENT_QUOTES) }}', 
                                                    prenom : '{{ htmlspecialchars($user['prenomusuel'], ENT_QUOTES) }}', 
                                                    nid    : '{{ htmlspecialchars($user['nid'] , ENT_QUOTES)}}',
                                                    email  : '{{ htmlspecialchars($user['email'] , ENT_QUOTES) }}',
                                                    grade  : '{{ htmlspecialchars(Str::ascii( $user['gradelong'], ENT_QUOTES ) ) }}' });
                    toggle()"
            class='btn btn-primary btn-sm'>></button>
</div>