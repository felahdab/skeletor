<div class="btn-group" role="groupe">
    <button @click="$dispatch('preset-this-user', { nom: '{{ $user['nom'] }}', 
                                                    prenom: '{{ $user['prenomusuel'] }}', 
                                                    nid: '{{ $user['nid'] }}',
                                                    email: '{{ $user['email'] }}' });
                    toggle()"
            class='btn btn-primary btn-sm'>></button>
</div>