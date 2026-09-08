import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

window.Echo = echo;

let conversationChannel = null;
let presenceChannel = null;

function dispatch(name, detail = {}) {
    if (window.Livewire?.dispatch) {
        window.Livewire.dispatch(name, detail);
    }
}

function subscribeConversation(conversationId) {
    if (!conversationId) {
        return;
    }

    if (conversationChannel) {
        conversationChannel.stopListening('.message.sent');
        conversationChannel.stopListening('.message.read');
        conversationChannel.stopListening('.message.updated');
        conversationChannel.stopListening('.message.deleted');
        echo.leave(conversationChannel.name);
        conversationChannel = null;
    }

    conversationChannel = echo.private(`conversation.${conversationId}`);

    conversationChannel
        .listen('.message.sent', (e) => dispatch('message-sent', { message: e.message }))
        .listen('.message.read', (e) => dispatch('message-read', {
            messageIds: e.messageIds,
            conversationId: e.conversationId,
        }))
        .listen('.message.updated', (e) => dispatch('message-updated', {
            messageId: e.messageId,
            conversationId: e.conversationId,
            content: e.content,
        }))
        .listen('.message.deleted', (e) => dispatch('message-deleted', {
            messageId: e.messageId,
            conversationId: e.conversationId,
        }));
}

const onlineUserIdSet = new Set();

function presenceUserIds() {
    return [...onlineUserIdSet].map(Number);
}

function memberId(member) {
    return Number(member?.id ?? member?.user_id ?? member);
}

function subscribePresence() {
    if (presenceChannel) {
        echo.leave(presenceChannel.name);
    }

    const publish = () => dispatch('presence-updated', { onlineUserIds: presenceUserIds() });

    presenceChannel = echo.join('presence.online');

    presenceChannel.here((members) => {
        onlineUserIdSet.clear();
        (members ?? []).forEach((member) => onlineUserIdSet.add(memberId(member)));
        publish();
    });

    presenceChannel.joining((member) => {
        onlineUserIdSet.add(memberId(member));
        publish();
    });

    presenceChannel.leaving((member) => {
        onlineUserIdSet.delete(memberId(member));
        publish();
    });
}

document.addEventListener('livewire:init', () => {
    subscribePresence();

    if (window.chatConversationId) {
        subscribeConversation(window.chatConversationId);
    }
});

window.ChatEcho = {
    subscribeConversation,
    subscribePresence,
};

window.addEventListener(`chat:activate-conversation`, (event) => {
    const { detail } = event;
    const conversationId = detail.conversationId;
    subscribeConversation(conversationId);
});

window.addEventListener(`chat:subscribe-presence`, () => {
    subscribePresence();
});
