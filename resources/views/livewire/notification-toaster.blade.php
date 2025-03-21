<div x-data='{}'  @markallasread.window="$wire.markAsRead()">
    <div class="toast fade @if($notification->read_at == null) show @endif" role="alert" id="notification.{{ $notification->id }}" aria-live="assertive"
        aria-atomic="true" x-init="$el.addEventListener('hidden.bs.toast', () => {
              $wire.markAsRead()
            })">
        <div class="toast-header">
          <strong class="me-auto">{{ $notification->data["titre"] }}</strong>
          @if(array_key_exists("mention", $notification->data))<small>{{ $notification->data["mention"] }}</small> @endif
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          {{ $notification->data["texte"] }}
        </div>
      </div>
</div>
