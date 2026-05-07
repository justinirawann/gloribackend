// Admin Layout JavaScript

function initAdminLayout() {
    const mobileToggle = document.getElementById('admin-mobile-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    const mobileOverlay = document.querySelector('.admin-mobile-overlay');
    const mainContent = document.querySelector('.admin-main');

    if (mobileToggle && sidebar && mobileOverlay) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-hidden');
            mobileOverlay.classList.toggle('show');
        });

        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.add('mobile-hidden');
            mobileOverlay.classList.remove('show');
        });
    }

    const sidebarItems = document.querySelectorAll('.admin-sidebar-item');
    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            if (window.innerWidth < 1024 && sidebar && mobileOverlay) {
                sidebar.classList.add('mobile-hidden');
                mobileOverlay.classList.remove('show');
            }
        });
    });

    window.addEventListener('resize', () => {
        if (sidebar && mobileOverlay) {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('mobile-hidden');
                mobileOverlay.classList.remove('show');
            } else {
                sidebar.classList.add('mobile-hidden');
            }
        }
    });

    const alerts = document.querySelectorAll('.admin-alert');
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                alert.remove();
            });
        }

        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    });

    if (window.innerWidth < 1024) {
        mainContent?.classList.add('mobile-padded');
        sidebar?.classList.add('mobile-hidden');
    }
}

function initAdminTabs() {
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanes = document.querySelectorAll('[data-tab-pane]');

    if (!tabButtons.length || !tabPanes.length) {
        return;
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const target = document.querySelector(button.dataset.tabTarget);

            tabButtons.forEach(btn => {
                btn.classList.remove('bg-slate-100', 'text-slate-900');
                btn.classList.add('text-slate-600');
            });

            button.classList.add('bg-slate-100', 'text-slate-900');

            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
            });

            if (target) {
                target.classList.remove('hidden');
            }
        });
    });
}

function initAdminModals() {
    const openers = document.querySelectorAll('[data-modal-open]');
    const closers = document.querySelectorAll('[data-modal-close]');
    const modals = document.querySelectorAll('.admin-modal');
    const body = document.body;

    const normalizeModalTarget = value => {
        if (!value) {
            return null;
        }

        if (value.startsWith('#') || value.startsWith('.')) {
            return value;
        }

        return `#${value}`;
    };

    const openModal = modal => {
        body.style.overflow = 'hidden';
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    };

    const closeModal = modal => {
        modal.classList.add('hidden');
        modal.style.display = 'none';
        body.style.overflow = '';
    };

    openers.forEach(trigger => {
        trigger.addEventListener('click', event => {
            event.preventDefault();
            const selector = normalizeModalTarget(trigger.dataset.modalOpen);
            const target = selector ? document.querySelector(selector) : null;

            if (target) {
                openModal(target);
            }
        });
    });

    closers.forEach(trigger => {
        trigger.addEventListener('click', event => {
            event.preventDefault();
            const modal = trigger.closest('.admin-modal');
            if (modal) {
                closeModal(modal);
            }
        });
    });

    modals.forEach(modal => {
        modal.addEventListener('click', event => {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
    });
}


export function initAdmin() {
    document.body.style.overflow = '';
    initAdminLayout();
    initAdminTabs();
    initAdminModals();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdmin);
} else {
    initAdmin();
}