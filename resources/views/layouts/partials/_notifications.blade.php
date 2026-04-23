<div class="notif-wrapper" x-data="{ 
    notifOpen: false, 
    unreadCount: 0, 
    notifications: [],
    
    init() {
        this.fetchNotifications();
        setInterval(() => this.fetchNotifications(), 120000);
    },

    fetchNotifications() {
        fetch('/api/notifications/recent')
            .then(res => res.json())
            .then(data => {
                this.notifications = data.notifications;
                this.unreadCount = data.unread_count;
            });
    },

    markAsRead(id, link) {
        fetch(`/api/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            }
        }).then(() => {
            window.location.href = link;
        });
    },

    markAllRead() {
        fetch('/api/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            }
        }).then(() => {
            this.unreadCount = 0;
            this.notifications.forEach(n => n.read_at = true);
        });
    }
}">
    <!-- Bell Icon Modern -->
    <button @click="notifOpen = !notifOpen" class="notif-btn" :class="unreadCount > 0 ? 'has-unread' : ''">
        <i class="fa-regular fa-bell"></i>
        <span x-show="unreadCount > 0" class="notif-badge" x-text="unreadCount"></span>
    </button>

    <!-- Dropdown Modern -->
    <div x-show="notifOpen" 
         @click.away="notifOpen = false"
         x-transition:enter="notif-enter"
         class="notif-dropdown"
         style="display: none;">
        
        <div class="notif-header">
            <h3>Thông báo</h3>
            <button @click="markAllRead()" class="mark-all-btn">Đọc tất cả</button>
        </div>

        <div class="notif-body no-scrollbar">
            <template x-if="notifications.length === 0">
                <div class="notif-empty">
                    <div class="empty-icon">
                        <i class="fa-regular fa-bell-slash"></i>
                    </div>
                    <p>Hiện không có thông báo nào</p>
                </div>
            </template>

            <template x-for="n in notifications" :key="n.id">
                <button @click="markAsRead(n.id, n.link)" 
                        class="notif-item"
                        :class="!n.read_at ? 'unread' : ''">
                    <div class="notif-icon"
                         :style="
                            n.type === 'booking_confirmed' ? 'background: #ECFDF5; color: #10B981;' :
                            n.type === 'booking_cancelled' ? 'background: #FEF2F2; color: #EF4444;' :
                            n.type === 'payment_success' ? 'background: #EFF6FF; color: #2563EB;' :
                            'background: #F1F5F9; color: #64748B;'
                         ">
                        <i :class="{
                            'fa-solid fa-calendar-check': n.type === 'booking_confirmed',
                            'fa-solid fa-calendar-xmark': n.type === 'booking_cancelled',
                            'fa-solid fa-file-invoice-dollar': n.type === 'payment_success',
                            'fa-solid fa-circle-info': !['booking_confirmed', 'booking_cancelled', 'payment_success'].includes(n.type)
                        }"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-title-row">
                            <span class="notif-title" x-text="n.title"></span>
                            <span class="notif-time" x-text="n.created_at"></span>
                        </div>
                        <p class="notif-msg" x-text="n.message"></p>
                    </div>
                </button>
            </template>
        </div>

        <a href="{{ route('notifications.index') }}" class="notif-footer">
            XEM TẤT CẢ
        </a>
    </div>
</div>

<style>
    .notif-wrapper { position: relative; display: inline-block; }
    
    .notif-btn {
        width: 44px; height: 44px;
        border-radius: 14px;
        background: white;
        border: 2px solid #F1F5F9;
        color: var(--text-muted);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; position: relative;
        transition: all 0.2s;
    }
    
    .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
    .notif-btn i { font-size: 20px; }
    
    .has-unread i {
        animation: bell-shake 2s infinite ease-in-out;
    }

    @keyframes bell-shake {
        0%, 100% { transform: rotate(0); }
        5%, 15%, 25% { transform: rotate(10deg); }
        10%, 20%, 30% { transform: rotate(-10deg); }
        35% { transform: rotate(0); }
    }

    .notif-badge {
        position: absolute; top: -5px; right: -5px;
        background: var(--danger);
        color: white; font-size: 10px; font-weight: 800;
        padding: 2px 6px; border-radius: 10px;
        border: 3px solid white;
        min-width: 20px; text-align: center;
    }

    .notif-dropdown {
        position: absolute; top: 100%; right: 0;
        margin-top: 12px; width: 320px;
        background: white; border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border: 1px solid white; z-index: 1000;
        overflow: hidden;
    }

    .notif-header {
        padding: 16px 20px; border-bottom: 1px solid #F1F5F9;
        display: flex; justify-content: space-between; align-items: center;
    }
    .notif-header h3 { font-size: 16px; font-weight: 800; color: var(--text-main); }
    .mark-all-btn { 
        background: none; border: none; 
        color: var(--primary); font-size: 11px; font-weight: 700;
        cursor: pointer; text-transform: uppercase;
    }

    .notif-body { max-height: 380px; overflow-y: auto; }
    .notif-item {
        width: 100%; padding: 16px 20px;
        border: none; background: white;
        display: flex; gap: 14px; text-align: left;
        border-bottom: 1px solid #F8FAFC;
        cursor: pointer; transition: background 0.2s;
    }
    .notif-item:hover { background: #F8FAFC; }
    .notif-item.unread { background: #FFF9F7; }

    .notif-icon {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 16px;
    }

    .notif-content { flex: 1; min-width: 0; }
    .notif-title-row { display: flex; justify-content: space-between; gap: 8px; margin-bottom: 4px; }
    .notif-title { font-size: 14px; font-weight: 700; color: var(--text-main); }
    .notif-time { font-size: 10px; color: var(--text-muted); font-weight: 600; white-space: nowrap; }
    .notif-msg { font-size: 12px; color: var(--text-muted); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .notif-footer {
        display: block; padding: 14px; text-align: center;
        background: #F8FAFC; color: var(--text-muted);
        font-size: 11px; font-weight: 800; text-decoration: none;
        letter-spacing: 0.5px;
    }

    .notif-empty { padding: 40px 20px; text-align: center; color: var(--text-muted); }
    .empty-icon { font-size: 32px; margin-bottom: 12px; opacity: 0.3; }

    .notif-enter { animation: notif-slide 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    @keyframes notif-slide {
        from { opacity: 0; transform: translateY(10px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>
