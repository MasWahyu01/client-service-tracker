import './bootstrap';
import '../css/app.css';

// Quick Service Status Update
document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    document.querySelectorAll('.service-status-select').forEach(select => {
        select.addEventListener('change', async (e) => {
            const el = e.target;
            const serviceId = el.dataset.serviceId;
            const url = el.dataset.updateUrl;
            const newStatus = el.value;

            if (!url || !csrfToken) {
                console.error('Missing URL or CSRF token');
                return;
            }

            try {
                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: newStatus }),
                });

                if (!response.ok) {
                    throw new Error('Failed to update status');
                }

                const data = await response.json();

                // Optional: kasih efek kecil kalo sukses
                el.classList.add('ring-2', 'ring-emerald-400');
                setTimeout(() => {
                    el.classList.remove('ring-2', 'ring-emerald-400');
                }, 500);
            } catch (error) {
                console.error(error);
                alert('Failed to update status. Please try again.');
            }
        });
    });
});