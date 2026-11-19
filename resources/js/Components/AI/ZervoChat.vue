
<script setup>
import { ref, nextTick, watch } from 'vue';
import {
    Bot,
    Sparkles,
    Wrench,
    Paintbrush,
    Zap,
    Sparkle,
    MapPin,
    Wallet,
    CalendarDays,
    Plus,
    Send,
    ArrowUpRight,
    Star,
    Clock3,
    MessageCircle,
} from 'lucide-vue-next';

const props = defineProps({
    initialService: {
        type: String,
        default: '',
    },
});

const input = ref('');
const loading = ref(false);
const conversation = ref(null);

const suggestions = [
    { label: 'Plumbing', icon: Wrench, prompt: 'I need plumbing services.' },
    { label: 'Electrical', icon: Zap, prompt: 'I need an electrician.' },
    { label: 'Painting', icon: Paintbrush, prompt: 'I need home painting services.' },
    { label: 'Home cleaning', icon: Sparkle, prompt: 'I need home cleaning services.' },
];

const quickActions = [
    { label: 'Add location', icon: MapPin, prompt: 'I want to add my location.' },
    { label: 'Set budget', icon: Wallet, prompt: 'I want to set my budget.' },
    { label: 'Timeline', icon: CalendarDays, prompt: 'I want to discuss the timeline.' },
    { label: 'More details', icon: Plus, prompt: 'I want to add more details.' },
];

const messages = ref([
    {
        id: 1,
        role: 'assistant',
        text: "Hey there! 👋 What can I help you with today? Tell me what you need fixed, installed, cleaned or improved at home. I'll help you find the right professional.",
        kind: 'text',
    },
]);

const providers = [
    {
        name: 'Rohit Plumbing Services',
        rating: '4.8',
        reviews: '124',
        location: 'Kolhapur · 4.5 km',
        initials: 'RP',
        color: '#DCEDE7',
    },
    {
        name: 'Sahyadri Services',
        rating: '4.6',
        reviews: '98',
        location: 'Kolhapur · 6.7 km',
        initials: 'SS',
        color: '#FBEBD6',
    },
    {
        name: 'Shree Plumbing Works',
        rating: '4.7',
        reviews: '76',
        location: 'Kolhapur · 8.1 km',
        initials: 'SW',
        color: '#E5EDF0',
    },
];

watch(
    () => props.initialService,
    (service) => {
        if (!service) return;

        sendMessage(`I need ${service.toLowerCase()} services.`);
    }
);

async function scrollToBottom() {
    await nextTick();

    conversation.value?.scrollTo({
        top: conversation.value.scrollHeight,
        behavior: 'smooth',
    });
}

async function sendMessage(value = input.value) {
    const text = value.trim();

    if (!text || loading.value) return;

    messages.value.push({
        id: Date.now(),
        role: 'user',
        text,
        kind: 'text',
    });

    input.value = '';
    loading.value = true;

    await scrollToBottom();

    // Demo response only. Connect this to the FastAPI chat endpoint later.
    window.setTimeout(async () => {
        messages.value.push({
            id: Date.now() + 1,
            role: 'assistant',
            text: `Thanks! I'll use "${text}" to understand your requirement. You can add your location, budget or preferred timeline next.`,
            kind: 'text',
        });

        loading.value = false;
        await scrollToBottom();
    }, 650);
}

function useQuickAction(action) {
    sendMessage(action.prompt);
}
</script>

<template>
    <section class="overflow-hidden rounded-[26px] border border-[#DCE8E0] bg-white shadow-[0_25px_80px_rgba(7,59,58,0.16)]">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-[#E9EFEB] px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="relative flex h-9 w-9 items-center justify-center rounded-xl bg-[#003D2D] text-[#FF9B38] shadow-sm">
                    <Bot :size="23" stroke-width="1.8" />

                    <span class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-white bg-emerald-500"></span>
                </div>

                <div>
                    <h3 class="text-base font-extrabold tracking-tight text-[#123E2E]">
                        Zervo AI Assistant
                    </h3>

                    <p class="mt-0.5 flex items-center gap-1.5 text-xs text-gray-500">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        </span>
                        Your home service companion
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-1.5 rounded-full border border-orange-100 bg-orange-50 px-2.5 py-1.5 text-xs font-bold text-[#C66A00]">
                <Sparkles :size="14" />
                AI Powered
            </div>
        </div>

       
        <!-- Conversation -->
        <div
            ref="conversation"
            class="h-[190px] space-y-4 overflow-y-auto bg-gradient-to-b from-[#F5FAF6] to-[#FAFCFA] px-4 py-4 sm:h-[210px]"
        >
            <TransitionGroup name="chat-message">
                <div
                    v-for="message in messages"
                    :key="message.id"
                    class="flex items-end gap-2.5"
                    :class="message.role === 'user' ? 'justify-end' : 'justify-start'"
                >
                    <!-- AI Avatar -->
                    <div
                        v-if="message.role === 'assistant'"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#003D2D] text-[#FF9B38] shadow-sm"
                    >
                        <Bot :size="19" />
                    </div>

                    <!-- Message -->
                    <div
                        class="max-w-[85%] rounded-2xl px-3.5 py-2.5 text-sm leading-5 shadow-sm"
                        :class="message.role === 'user'
                            ? 'rounded-br-sm bg-gradient-to-br from-[#07563A] to-[#003D2D] text-white'
                            : 'rounded-bl-sm border border-[#E4ECE6] bg-white text-[#263B35]'"
                    >
                        {{ message.text }}
                    </div>

                    <!-- User Avatar -->
                    <div
                        v-if="message.role === 'user'"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#FFEAD7] text-xs font-bold text-[#D96B00]"
                    >
                        You
                    </div>
                </div>
            </TransitionGroup>

            <!-- Typing indicator -->
            <div v-if="loading" class="flex items-end gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#003D2D] text-[#FF9B38]">
                    <Bot :size="19" />
                </div>

                <div class="flex items-center gap-1.5 rounded-2xl rounded-bl-sm border border-[#E4ECE6] bg-white px-4 py-3 shadow-sm">
                    <span
                        v-for="n in 3"
                        :key="n"
                        class="h-2 w-2 animate-bounce rounded-full bg-[#08744D]"
                        :style="{ animationDelay: `${(n - 1) * 150}ms` }"
                    ></span>
                    <span class="ml-1 text-xs text-gray-400">Zervo is typing</span>
                </div>
            </div>
        </div>


        <!-- Quick suggestions -->
        <div class="border-t border-[#E9EFEB] bg-white px-5 py-5 sm:px-7">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h4 class="text-base font-extrabold text-[#123E2E] sm:text-lg">
                        What do you need help with?
                    </h4>
                    <p class="mt-1 text-sm text-gray-500">
                        Choose a service to get started.
                    </p>
                </div>

                <Sparkles :size="22" class="text-[#F47700]" />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button
                    v-for="suggestion in suggestions"
                    :key="suggestion.label"
                    type="button"
                    :disabled="loading"
                    class="group cursor-pointer flex min-h-[46px] items-center gap-2 rounded-xl border border-[#E5EDE7] bg-[#FAFCFA] px-3 py-2 text-left transition duration-200 hover:border-[#F47700]/50 hover:bg-orange-50 disabled:opacity-50"
                    @click="sendMessage(suggestion.prompt)"
                >
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E8F2EC] text-[#08744D] transition group-hover:bg-[#07563A] group-hover:text-white">
                        <component :is="suggestion.icon" :size="21" />
                    </span>

                    <span class="text-sm font-bold text-[#234238] sm:text-base">
                        {{ suggestion.label }}
                    </span>
                </button>
            </div>
        </div>

        <!-- Message composer -->
        <form
            class="border-t border-[#E9EFEB] bg-white p-4 sm:p-5"
            @submit.prevent="sendMessage()"
        >
            <div class="flex items-center gap-3 rounded-2xl border-2 border-[#E5EDE7] bg-[#FAFCFA] p-2 transition focus-within:border-[#08744D] focus-within:ring-4 focus-within:ring-emerald-50">
                <MessageCircle :size="23" class="ml-2 shrink-0 text-[#82958A]" />

                <input
                    v-model="input"
                    type="text"
                    placeholder="Tell us what you need..."
                    :disabled="loading"
                    class="min-w-0 flex-1 border-0 bg-transparent px-1 py-2 text-sm text-[#172B36] outline-none ring-0 placeholder:text-gray-400 focus:border-0 focus:outline-none focus:ring-0 sm:text-lg"
                />

                <button
                    type="submit"
                    :disabled="!input.trim() || loading"
                    aria-label="Send message"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#FF7900] text-white shadow-md shadow-orange-900/15 transition hover:-translate-y-0.5 hover:bg-[#E86D00] disabled:cursor-not-allowed disabled:opacity-40"
                >
                    <Send :size="21"/>
                </button>
            </div>

            <p class="mt-3 text-center text-xs text-gray-400">
                Just describe your problem. Zervo AI will guide you.
            </p>
        </form>
    </section>
</template>

<style scoped>
/* Animate new chat messages */
.chat-message-enter-active {
    transition: all 0.3s ease-out;
}

.chat-message-enter-from {
    opacity: 0;
    transform: translateY(12px) scale(0.97);
}

.chat-message-enter-to {
    opacity: 1;
    transform: translateY(0) scale(1);
}
</style>