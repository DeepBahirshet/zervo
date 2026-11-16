
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
    { label: 'Cleaning', icon: Sparkle, prompt: 'I need home cleaning services.' },
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
        text: 'Hi! I’m Zervo. What do you need help with at home today?',
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
        <div class="flex items-center justify-between border-b border-[#E9EFEB] px-5 py-5 sm:px-7">
            <div class="flex items-center gap-4">
                <div class="relative flex h-10 w-10 items-center justify-center rounded-2xl bg-[#003D2D] text-[#FF9B38] shadow-lg shadow-emerald-950/15">
                    <Bot :size="30" stroke-width="1.8" />
                    <span class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-[3px] border-white bg-emerald-500"></span>
                </div>

                <div>
                    <h3 class="text-lg font-extrabold tracking-tight text-[#123E2E] sm:text-xl">
                        Zervo AI Assistant
                    </h3>
                    <p class="mt-1 flex items-center gap-2 text-sm font-medium text-gray-500">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Here to help with your home
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 rounded-full border border-orange-100 bg-orange-50 px-3 py-2 text-xs font-bold text-[#C66A00] sm:px-4 sm:text-sm">
                <Sparkles :size="16" />
                AI Powered
            </div>
        </div>

        <!-- Conversation -->
        <div
            ref="conversation"
            class="h-[200px] space-y-6 overflow-y-auto bg-[#FAFCFA] px-5 py-6 sm:h-[240px] sm:px-7"
        >
            <div
                v-for="message in messages"
                :key="message.id"
                class="flex gap-3"
                :class="message.role === 'user' ? 'justify-end' : 'justify-start'"
            >
                <div
                    v-if="message.role === 'assistant'"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E6F1EB] text-[#08744D]"
                >
                    <Bot :size="23" />
                </div>

                <div class="min-w-0 max-w-[88%]">
                    <div
                        class="rounded-2xl px-5 py-4 text-[15px] leading-7 sm:text-base"
                        :class="message.role === 'user'
                            ? 'rounded-br-sm bg-[#07563A] text-white shadow-md shadow-emerald-950/10'
                            : 'rounded-bl-sm border border-[#E7EEE9] bg-white text-[#263B35] shadow-sm'"
                    >
                        {{ message.text }}
                    </div>

                    <!-- Provider cards -->
                    <div
                        v-if="message.kind === 'providers'"
                        class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3"
                    >
                        <article
                            v-for="provider in providers"
                            :key="provider.name"
                            class="overflow-hidden rounded-2xl border border-[#E6ECE7] bg-white"
                        >
                            <div
                                class="flex h-20 items-center justify-center"
                                :style="{ backgroundColor: provider.color }"
                            >
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-base font-extrabold text-[#073B3A]">
                                    {{ provider.initials }}
                                </div>
                            </div>

                            <div class="p-3">
                                <h4 class="text-sm font-bold text-[#172B36]">
                                    {{ provider.name }}
                                </h4>

                                <p class="mt-2 flex items-center gap-1 text-sm font-semibold text-[#9A6B13]">
                                    <Star :size="15" class="fill-[#E9A008]" />
                                    {{ provider.rating }}
                                    <span class="font-normal text-gray-400">({{ provider.reviews }} reviews)</span>
                                </p>

                                <p class="mt-2 flex items-center gap-1 text-xs text-gray-500">
                                    <MapPin :size="14" />
                                    {{ provider.location }}
                                </p>

                                <button
                                    type="button"
                                    class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-[#EAF3EF] py-2.5 text-sm font-bold text-[#075B53] transition hover:bg-[#D6E9E1]"
                                    @click="sendMessage(`I want to know more about ${provider.name}.`)"
                                >
                                    View profile
                                    <ArrowUpRight :size="15" />
                                </button>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <!-- Loading -->
            <div v-if="loading" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E6F1EB] text-[#08744D]">
                    <Bot :size="22" />
                </div>

                <div class="flex items-center gap-1.5 rounded-2xl border border-[#E7EEE9] bg-white px-5 py-4">
                    <span
                        v-for="n in 3"
                        :key="n"
                        class="h-2 w-2 animate-bounce rounded-full bg-[#08744D]"
                        :style="{ animationDelay: `${n * 120}ms` }"
                    ></span>
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
                    class="group flex min-h-[46px] items-center gap-2 rounded-xl border border-[#E5EDE7] bg-[#FAFCFA] px-3 py-2 text-left transition duration-200 hover:border-[#F47700]/50 hover:bg-orange-50 disabled:opacity-50"
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

        <!-- Quick actions -->
        <div class="border-t border-[#EDF0EC] bg-[#FAFCFA] px-5 py-4 sm:px-7">
            <p class="mb-3 text-xs font-bold uppercase tracking-wider text-gray-400">
                Add more details
            </p>

            <div class="flex flex-wrap gap-2">
                <button
                    v-for="action in quickActions"
                    :key="action.label"
                    type="button"
                    :disabled="loading"
                    class="inline-flex items-center gap-1.5 rounded-full border border-[#E3EAE4] bg-white px-3 py-1.5 text-xs font-semibold text-[#456156] transition hover:border-[#F47700]/40 hover:bg-orange-50 disabled:opacity-50"
                    @click="useQuickAction(action)"
                >
                    <component :is="action.icon" :size="16" />
                    {{ action.label }}
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
                Zervo AI helps you describe your requirement and find suitable professionals.
            </p>
        </form>
    </section>
</template>
