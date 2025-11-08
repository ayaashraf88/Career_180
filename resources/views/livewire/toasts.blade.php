<div aria-live="polite" aria-atomic="true"
     class="position-fixed top-0 end-0 p-3"
     style="z-index: 1080;">
</div>

<script>
        document.addEventListener('livewire:init', () => {
        window.addEventListener('notify', function(e) {
            const {
                type = 'primary', message = ''
            } = e.detail;
            const container = document.querySelector('[aria-live]');
            const id = 'toast-' + Date.now();

            const toastEl = document.createElement('div');
            toastEl.className = `toast align-items-center text-bg-${type} border-0 mb-2`;
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');
            toastEl.innerHTML = ` <div class="d-flex"> <div class="toast-body">${message}</div> <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button> </div>`;
            container.appendChild(toastEl);

            const toast = new bootstrap.Toast(toastEl, {
                delay: 3000
            });
            toast.show();
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        });
    });
</script>