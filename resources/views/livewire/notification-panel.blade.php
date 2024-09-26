<div x-data="{}">
  @auth
  <div class="offcanvas offcanvas-end" tabindex="-1" data-bs-scroll="true"
    id="notificationPanel" aria-labelledby="offcanvasRightLabel" x-init="$el.addEventListener('hidden.bs.offcanvas', () => {
      $wire.$refresh()
            })">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Notifications</h5>
      <button class="btn btn-primary btn-sm" x-on:click="$dispatch('markallasread')">Marquer tout comme vu</button>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      @foreach(auth()->user()->unreadNotifications as $notification)
        <livewire:notification-toaster :notification="$notification">
      @endforeach
    </div>
  </div>
  @endauth

  @teleport('#notification-space')
    @auth
    <button class="btn btn-outline-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#notificationPanel" aria-controls="offcanvasRight">
      <x-bootstrap-icon iconname='bell.svg' />
      
      @if(auth()->user()->unreadNotifications->count())
        <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
      @endif
      
    </button>
    @endauth
  @endteleport
</div>