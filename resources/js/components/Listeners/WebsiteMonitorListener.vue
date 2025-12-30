<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Initialize Pusher
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

const notifications = ref([]);
const showNotification = ref(false);
const currentNotification = ref(null);

onMounted(() => {
    // Listen to website down events on public channel
    window.Echo.channel('website-monitoring')
        .listen('.website.down', (event) => {
            console.log('Website Down Event:', event);

            // Add to notifications array
            notifications.value.unshift({
                id: Date.now(),
                website: event.website,
                client: event.client,
                timestamp: event.timestamp,
                message: event.message
            });

            // Show notification
            currentNotification.value = event;
            showNotification.value = true;

            // Auto hide after 10 seconds
            setTimeout(() => {
                showNotification.value = false;
            }, 10000);

            // Play alert sound (optional)
            playAlertSound();
        });

});

onUnmounted(() => {
    window.Echo.leaveChannel('website-monitoring');
});

const playAlertSound = () => {
    const audio = new Audio('/sounds/alert.mp3');
    audio.play().catch(e => console.log('Could not play sound:', e));
};

const dismissNotification = () => {
    showNotification.value = false;
};

const clearAllNotifications = () => {
    notifications.value = [];
};
</script>

<template>
    <div>
        <!-- Floating Notification -->
        <div
            v-if="showNotification && currentNotification"
            class="notification-toast"
        >
            <div class="toast-header">
                <i class="pi pi-exclamation-triangle text-danger"></i>
                <strong class="ms-2">Website Down Alert!</strong>
                <button @click="dismissNotification" class="btn-close ms-auto"></button>
            </div>
            <div class="toast-body">
                <p><strong>{{ currentNotification.website.name }}</strong></p>
                <p class="text-muted mb-1">{{ currentNotification.website.url }}</p>
                <p class="mb-0">
                    <small>Client: {{ currentNotification.client.email }}</small>
                </p>
                <p class="text-muted mb-0">
                    <small>{{ currentNotification.timestamp }}</small>
                </p>
            </div>
        </div>

        <!-- Notification List (Optional) -->
        <div v-if="notifications.length > 0" class="notifications-panel">
            <div class="panel-header">
                <h6>Website Alerts ({{ notifications.length }})</h6>
                <button @click="clearAllNotifications" class="btn btn-sm btn-link">Clear All</button>
            </div>
            <div class="panel-body">
                <div
                    v-for="notification in notifications.slice(0, 5)"
                    :key="notification.id"
                    class="notification-item"
                >
                    <div class="d-flex align-items-center">
                        <i class="pi pi-times-circle text-danger me-2"></i>
                        <div>
                            <strong>{{ notification.website.name }}</strong>
                            <p class="text-muted mb-0">
                                <small>{{ notification.timestamp }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.notification-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 350px;
    background: white;
    border: 1px solid #dc3545;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.toast-header {
    padding: 12px 16px;
    background: #dc3545;
    color: white;
    border-radius: 8px 8px 0 0;
    display: flex;
    align-items: center;
}

.toast-body {
    padding: 16px;
}

.btn-close {
    background: transparent;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}

.notifications-panel {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    max-height: 400px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.panel-header {
    padding: 12px 16px;
    background: #f8f9fa;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.panel-body {
    max-height: 350px;
    overflow-y: auto;
}

.notification-item {
    padding: 12px 16px;
    border-bottom: 1px solid #f0f0f0;
}

.notification-item:hover {
    background: #f8f9fa;
}
</style>
