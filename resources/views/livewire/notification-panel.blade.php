<div>
  @auth
  <div class="offcanvas offcanvas-end @if($showPanel) show @endif" tabindex="-1" data-bs-scroll="true"
    id="notificationPanel" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Notifications</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      @foreach(auth()->user()->unreadNotifications as $notification)
      <div class="toast fade show" role="alert" id="notification.{{ $notification->id }}" aria-live="assertive"
        aria-atomic="true" x-init="$el.addEventListener('hidden.bs.toast', () => {
              $wire.markNotificationAsRead('{{ $notification->id }}')
            })">
        <div class="toast-header">
          <strong class="me-auto">{{ $notification->data["title"] }}</strong>
          @if(array_key_exists("marin", $notification->data))<small>{{ $notification->data["marin"] }}</small> @endif
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          {{ $notification->data["body"] }}
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endauth
</div>