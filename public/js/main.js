/* ============================================================
   EXTRA FIT+ — MAIN JAVASCRIPT
   ============================================================ */

(function() {
'use strict';

/* ============================================================
   THEME / DARK MODE
   ============================================================ */
const THEME_KEY = 'extrafit_theme';

function getTheme() {
    return localStorage.getItem(THEME_KEY) || 'light';
}

function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(THEME_KEY, theme);
    updateDarkIcons(theme);
}

function updateDarkIcons(theme) {
    const isDark = theme === 'dark';
    document.querySelectorAll('[id$="darkIcon"], [id$="DarkIcon"]').forEach(el => {
        el.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
    });
    document.querySelectorAll('[id$="drawerDarkToggle"]').forEach(btn => {
        const icon = btn.querySelector('i');
        if (icon) icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        const text = btn.childNodes[btn.childNodes.length - 1];
        if (text && text.nodeType === 3) text.textContent = isDark ? ' Chế độ sáng' : ' Chế độ tối';
    });
}

function toggleTheme() {
    const current = getTheme();
    setTheme(current === 'dark' ? 'light' : 'dark');
}

// Init theme on load
setTheme(getTheme());

document.addEventListener('DOMContentLoaded', () => {

    /* ============================================================
       HEADER SCROLL
       ============================================================ */
    const header = document.getElementById('siteHeader');
    if (header) {
        const onScroll = () => {
            header.classList.toggle('scrolled', window.scrollY > 10);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ============================================================
       DARK MODE TOGGLE
       ============================================================ */
    document.getElementById('darkModeToggle')?.addEventListener('click', toggleTheme);
    document.getElementById('drawerDarkToggle')?.addEventListener('click', toggleTheme);

    /* ============================================================
       USER DROPDOWN
       ============================================================ */
    const userDropdown = document.getElementById('userDropdown');
    const userTrigger  = document.getElementById('userTrigger');
    if (userDropdown && userTrigger) {
        userTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('open');
        });
        document.addEventListener('click', () => {
            userDropdown.classList.remove('open');
        });
    }

    /* ============================================================
       MOBILE DRAWER
       ============================================================ */
    const hamburgerBtn  = document.getElementById('hamburgerBtn');
    const mobileDrawer  = document.getElementById('mobileDrawer');
    const drawerOverlay = document.getElementById('drawerOverlay');
    const drawerClose   = document.getElementById('drawerClose');

    function openDrawer() {
        mobileDrawer?.classList.add('open');
        drawerOverlay?.classList.add('active');
        hamburgerBtn?.classList.add('open');
        hamburgerBtn?.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        mobileDrawer?.classList.remove('open');
        drawerOverlay?.classList.remove('active');
        hamburgerBtn?.classList.remove('open');
        hamburgerBtn?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    hamburgerBtn?.addEventListener('click', () => {
        mobileDrawer?.classList.contains('open') ? closeDrawer() : openDrawer();
    });
    drawerOverlay?.addEventListener('click', closeDrawer);
    drawerClose?.addEventListener('click', closeDrawer);

    // Close drawer on link click
    document.querySelectorAll('.drawer-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) closeDrawer();
        });
    });

    /* ============================================================
       SCROLL ANIMATIONS (Intersection Observer)
       ============================================================ */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

    /* ============================================================
       COUNTER ANIMATION
       ============================================================ */
    function animateCounter(el, target, duration) {
        const start = performance.now();
        const isDecimal = String(target).includes('.');
        const update = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = isDecimal ? (eased * target).toFixed(1) : Math.floor(eased * target);
            el.textContent = value.toLocaleString('vi-VN');
            if (progress < 1) requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseFloat(el.dataset.target || el.textContent.replace(/[^0-9.]/g, ''));
                animateCounter(el, target, 1800);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));

    /* ============================================================
       SCROLL TO TOP BUTTON
       ============================================================ */
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            scrollTopBtn.classList.toggle('visible', window.scrollY > 400);
        }, { passive: true });
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ============================================================
       HERO SLIDER (Auto)
       ============================================================ */
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots   = document.querySelectorAll('.hero-dot');
    let   heroIndex  = 0;
    let   heroTimer;

    function gotoSlide(n) {
        heroSlides[heroIndex]?.classList.remove('active');
        heroDots[heroIndex]?.classList.remove('active');
        heroIndex = (n + heroSlides.length) % heroSlides.length;
        heroSlides[heroIndex]?.classList.add('active');
        heroDots[heroIndex]?.classList.add('active');
    }

    function startHeroTimer() {
        clearInterval(heroTimer);
        if (heroSlides.length > 1) {
            heroTimer = setInterval(() => gotoSlide(heroIndex + 1), 5000);
        }
    }

    if (heroSlides.length > 0) {
        gotoSlide(0);
        startHeroTimer();
        heroDots.forEach((dot, i) => {
            dot.addEventListener('click', () => { gotoSlide(i); startHeroTimer(); });
        });
    }

    /* ============================================================
       CLASS TABS
       ============================================================ */
    const classTabs  = document.querySelectorAll('.class-tab');
    const classItems = document.querySelectorAll('.class-list-item');

    classTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            classTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            // Filter logic can be extended
        });
    });

    classItems.forEach((item, i) => {
        item.addEventListener('click', () => {
            classItems.forEach(it => it.classList.remove('active'));
            item.classList.add('active');
            // Load class detail
            const targetId = item.dataset.class;
            document.querySelectorAll('.class-detail-panel').forEach(p => {
                p.style.display = p.dataset.class === targetId ? 'block' : 'none';
            });
        });
    });

    // Activate first item by default
    if (classItems.length > 0) classItems[0].click();

    /* ============================================================
       TRAINER FILTER
       ============================================================ */
    const filterBtns = document.querySelectorAll('.trainer-filter-btn');
    const trainerCards = document.querySelectorAll('.trainer-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter || 'all';

            trainerCards.forEach(card => {
                const show = filter === 'all' || card.dataset.discipline === filter;
                card.style.display = show ? '' : 'none';
                if (show) {
                    card.style.animation = 'none';
                    requestAnimationFrame(() => {
                        card.style.animation = '';
                        card.classList.remove('animated');
                        setTimeout(() => card.classList.add('animated'), 50);
                    });
                }
            });
        });
    });

    /* ============================================================
       TESTIMONIALS SLIDER
       ============================================================ */
    const testiTrack  = document.querySelector('.testi-track');
    const testiPrev   = document.getElementById('testiPrev');
    const testiNext   = document.getElementById('testiNext');
    const testiCards  = document.querySelectorAll('.testi-card');
    let testiIndex = 0;

    function getVisibleTesti() {
        if (window.innerWidth <= 768)  return 1;
        if (window.innerWidth <= 1024) return 2;
        return 3;
    }

    function updateTesti() {
        if (!testiTrack || testiCards.length === 0) return;
        const visible = getVisibleTesti();
        const cardWidth = (testiTrack.offsetWidth - (visible - 1) * 24) / visible;
        const offset = testiIndex * (cardWidth + 24);
        testiTrack.style.transform = `translateX(-${offset}px)`;
        testiCards.forEach(c => {
            c.style.minWidth = cardWidth + 'px';
        });
    }

    function nextTesti() {
        const visible = getVisibleTesti();
        const max = testiCards.length - visible;
        testiIndex = testiIndex < max ? testiIndex + 1 : 0;
        updateTesti();
    }

    function prevTesti() {
        const visible = getVisibleTesti();
        const max = testiCards.length - visible;
        testiIndex = testiIndex > 0 ? testiIndex - 1 : max;
        updateTesti();
    }

    testiNext?.addEventListener('click', nextTesti);
    testiPrev?.addEventListener('click', prevTesti);
    window.addEventListener('resize', updateTesti, { passive: true });

    let testiAutoTimer = setInterval(nextTesti, 4500);
    testiTrack?.addEventListener('mouseenter', () => clearInterval(testiAutoTimer));
    testiTrack?.addEventListener('mouseleave', () => { testiAutoTimer = setInterval(nextTesti, 4500); });

    setTimeout(updateTesti, 100);

    /* ============================================================
       NOTIFICATION BUTTON (demo)
       ============================================================ */
    document.getElementById('notificationBtn')?.addEventListener('click', () => {
        showToast('info', 'Thông báo', 'Bạn có 3 thông báo chưa đọc!');
    });

}); // end DOMContentLoaded

/* ============================================================
   TOAST SYSTEM (Global)
   ============================================================ */
const TOAST_ICONS = {
    success: 'fas fa-check-circle',
    error:   'fas fa-times-circle',
    warning: 'fas fa-exclamation-triangle',
    info:    'fas fa-info-circle',
};

let toastStack = [];
const MAX_TOASTS = 3;

window.showToast = function(type = 'info', title = '', message = '', duration = 4000) {
    // Max 3 toasts
    if (toastStack.length >= MAX_TOASTS) {
        const oldest = toastStack.shift();
        dismissToast(oldest);
    }

    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <i class="toast-icon ${TOAST_ICONS[type] || 'fas fa-info-circle'}"></i>
        <div class="toast-content">
            ${title    ? `<div class="toast-title">${title}</div>` : ''}
            ${message  ? `<div class="toast-msg">${message}</div>` : ''}
        </div>
        <button class="toast-close" aria-label="Đóng"><i class="fas fa-times"></i></button>
    `;

    container.appendChild(toast);
    toastStack.push(toast);

    // Trigger animation
    requestAnimationFrame(() => {
        requestAnimationFrame(() => toast.classList.add('show'));
    });

    // Close button
    toast.querySelector('.toast-close').addEventListener('click', () => dismissToast(toast));

    // Auto dismiss
    const timer = setTimeout(() => dismissToast(toast), duration);
    toast._timer = timer;
};

function dismissToast(toast) {
    if (!toast) return;
    clearTimeout(toast._timer);
    toast.classList.remove('show');
    toast.classList.add('hide');
    toastStack = toastStack.filter(t => t !== toast);
    setTimeout(() => toast.remove(), 350);
}

/* ============================================================
   MODAL SYSTEM (Global)
   ============================================================ */
window.openModal = function(modalId) {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';

    overlay.addEventListener('click', function closeOnOverlay(e) {
        if (e.target === overlay) {
            window.closeModal(modalId);
            overlay.removeEventListener('click', closeOnOverlay);
        }
    });
};

window.closeModal = function(modalId) {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;
    overlay.classList.remove('active');
    document.body.style.overflow = '';
};

// ESC key closes modal
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(m => {
            m.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});

})(); // IIFE end
