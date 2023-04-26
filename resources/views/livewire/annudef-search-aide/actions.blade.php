<div class="btn-group" role="groupe">
    <button @click="$dispatch('preset-this-user', { nom: '{{ $user['nom'] }}', 
                                                    prenom: '{{ $user['prenom'] }}', 
                                                    nid: '{{ $user['nid'] }}',
                                                    email: '{{ $user['email'] }}' })"
            class='btn btn-primary btn-sm'>></button>
</div>