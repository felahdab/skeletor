<div x-data="{}">
  @auth
  <div class="offcanvas offcanvas-end" tabindex="-1" data-bs-scroll="true"
    id="notificationPanel" aria-labelledby="offcanvasRightLabel">
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
</div>