@foreach($row->roles as $role)
    <span class="badge bg-primary">{{ $role->name }}</span>
@endforeach