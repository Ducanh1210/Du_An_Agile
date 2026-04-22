<div class="relative inline-block" x-data="{ 
    notifOpen: false, 
    unreadCount: 0, 
    notifications: [],
    loading: false,
    
    init() {
        this.fetchNotifications();
        // Cập nhật ngầm mỗi 2 phút
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
    <!-- Bell Icon -->
    <button @click="notifOpen = !notifOpen" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-gray-100 transition relative">
        <i class="fa-regular fa-bell text-lg"></i>
        <span x-show="unreadCount > 0" x-text="unreadCount" 
              class="absolute top-1 right-1 px-1.5 py-0.5 min-w-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full border-2 border-white flex items-center justify-center">
        </span>
    </button>

    <!-- Dropdown -->
    <div x-show="notifOpen" 
         @click.away="notifOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl shadow-slate-200 border border-slate-100 z-50 overflow-hidden"
         style="display: none;">
        
        <div class="p-4 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-slate-900">Thông báo</h3>
            <button @click="markAllRead()" class="text-[11px] font-bold text-primary hover:underline uppercase tracking-wider">Đọc tất cả</button>
        </div>

        <div class="max-h-96 overflow-y-auto no-scrollbar">
            <template x-if="notifications.length === 0">
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-regular fa-bell-slash text-slate-300"></i>
                    </div>
                    <p class="text-sm text-slate-400">Bạn chưa có thông báo nào</p>
                </div>
            </template>

            <template x-for="n in notifications" :key="n.id">
                <button @click="markAsRead(n.id, n.link)" 
                        class="w-full text-left p-4 hover:bg-slate-50 transition-colors border-b border-slate-50 flex gap-4 group"
                        :class="!n.read_at ? 'bg-orange-50/30' : ''">
                    <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center"
                         :class="{
                            'bg-orange-100 text-orange-600': n.type === 'booking_confirmed' || n.type === 'booking_cancelled',
                            'bg-green-100 text-green-600': n.type === 'payment_success',
                            'bg-blue-100 text-blue-600': n.type === 'session_report',
                            'bg-slate-100 text-slate-600': !['booking_confirmed', 'booking_cancelled', 'payment_success', 'session_report'].includes(n.type)
                         }">
                        <i :class="{
                            'fa-solid fa-calendar-check': n.type === 'booking_confirmed',
                            'fa-solid fa-calendar-xmark': n.type === 'booking_cancelled',
                            'fa-solid fa-file-invoice-dollar': n.type === 'payment_success',
                            'fa-solid fa-clipboard-check': n.type === 'session_report',
                            'fa-solid fa-info-circle': !['booking_confirmed', 'booking_cancelled', 'payment_success', 'session_report'].includes(n.type)
                        }"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <span class="text-sm font-bold text-slate-900 truncate" x-text="n.title"></span>
                            <span class="text-[10px] text-slate-400 whitespace-nowrap" x-text="n.created_at"></span>
                        </div>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed" x-text="n.message"></p>
                    </div>
                </button>
            </template>
        </div>

        <a href="{{ route('notifications.index') }}" class="block p-3 text-center text-xs font-bold text-slate-500 hover:text-primary transition-colors bg-slate-50/50">
            Xem tất cả thông báo
        </a>
    </div>
</div>
