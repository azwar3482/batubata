<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('loadingForm', (options = {}) => ({
        loading: false,
        loadingText: options.text || 'Memproses...',

        startLoading(text) {
            this.loading = true;
            this.loadingText = text || this.loadingText;
        },

        stopLoading() {
            this.loading = false;
        },

        async submitForm(event) {
            this.startLoading();
            try {
                const form = event.target;
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (response.ok || response.redirected) {
                    window.location.reload();
                } else {
                    const data = await response.json().catch(() => ({}));
                    if (data.message) alert(data.message);
                    else if (data.errors) {
                        const messages = Object.values(data.errors).flat().join('\n');
                        alert(messages);
                    } else {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
            } finally {
                this.stopLoading();
            }
        },

        async deleteConfirm(event, message) {
            if (!confirm(message || 'Yakin ingin menghapus?')) {
                event.preventDefault();
                return;
            }
            this.startLoading('Menghapus...');
        },

        async processAction(text) {
            this.startLoading(text || 'Memproses...');
        }
    }));
});
</script>
