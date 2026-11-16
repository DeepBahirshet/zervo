
<script setup>
import { ref, nextTick } from 'vue';

const input = ref('');
const loading = ref(false);
const conversation = ref(null);

const suggestions = [
    'Find a plumber',
    'Home painting',
    'Build a website',
    'Find an electrician',
];

const quickActions = ['Set budget', 'Timeline', 'Add details', 'Compare'];

const messages = ref([
    {
        id: 1,
        role: 'assistant',
        text: "Hi! I'm Zervo 👋 What service are you looking for today?",
        kind: 'text',
    },
    {
        id: 2,
        role: 'user',
        text: 'I need a plumber for my home in Kolhapur.',
        kind: 'text',
    },
    {
        id: 3,
        role: 'assistant',
        text: "Got it! Let's find a suitable plumber. Here are sample professionals to show how recommendations will appear.",
        kind: 'providers',
    },
]);

const providers = [
    { name: 'Rohit Plumbing Services', rating: '4.8', reviews: '124', location: 'Kolhapur · 4.5 km', initials: 'RP', color: '#DCEDE7' },
    { name: 'Sahyadri Services', rating: '4.6', reviews: '98', location: 'Kolhapur · 6.7 km', initials: 'SS', color: '#FBEBD6' },
    { name: 'Shree Plumbing Works', rating: '4.7', reviews: '76', location: 'Kolhapur · 8.1 km', initials: 'SW', color: '#E5EDF0' },
];

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
    const prompts = {
        'Set budget': 'I want to set my budget.',
        'Timeline': 'I would like to discuss the timeline.',
        'Add details': 'I want to add more details to my requirement.',
        'Compare': 'I want to compare professionals.',
    };

    sendMessage(prompts[action]);
}
</script>

<template>
    <section class="overflow-hidden rounded-[25px] border border-[#D9E5DF] bg-white shadow-[0_28px_80px_rgba(7,59,58,0.17)]">

        <!-- Chat top bar -->
        <div class="flex items-center justify-between border-b border-[#E9EFEB] px-4 py-4 sm:px-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#073B3A] text-xl font-black text-[#F59E0B]">
                    Z
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-[#172B36] sm:text-base">Zervo Assistant</h3>
                    <p class="mt-0.5 flex items-center gap-1.5 text-[11px] text-[#64766E]">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Online · Your personal service companion
                    </p>
                </div>
            </div>
            <span class="rounded-full bg-[#FFF3DA] px-3 py-1.5 text-[10px] font-bold text-[#9A5B00] sm:text-xs">
                ✦ AI Powered
            </span>
        </div>

        <!-- Conversation -->
        <div ref="conversation" class="h-[330px] space-y-5 overflow-y-auto bg-[#FBFCFA] px-4 py-5 sm:h-[390px] sm:px-5">
            <div
                v-for="message in messages"
                :key="message.id"
                class="flex gap-2.5"
                :class="message.role === 'user' ? 'justify-end' : 'justify-start'"
            >
                <div
                    v-if="message.role === 'assistant'"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#E5F0EC] text-sm font-black text-[#087E78]"
                >
                    Z
                </div>

                <div class="min-w-0 max-w-[90%]">
                    <div
                        class="rounded-2xl px-4 py-3 text-[12px] leading-6 sm:text-[13px]"
                        :class="message.role === 'user'
                            ? 'rounded-br-sm bg-[#087E78] text-white'
                            : 'rounded-bl-sm border border-[#E8EEEA] bg-white text-[#263B3B] shadow-sm'"
                    >
                        {{ message.text }}
                    </div>

                    <div v-if="message.kind === 'providers'" class="mt-3 grid grid-cols-1 gap-2.5 sm:grid-cols-3">
                        <article
                            v-for="provider in providers"
                            :key="provider.name"
                            class="overflow-hidden rounded-xl border border-[#E6ECE7] bg-white"
                        >
                            <div
                                class="flex h-[70px] items-center justify-center"
                                :style="{ backgroundColor: provider.color }"
                            >
                                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/80 text-sm font-extrabold text-[#073B3A]">
                                    {{ provider.initials }}
                                </div>
                            </div>
                            <div class="p-2.5">
                                <h4 class="line-clamp-1 text-[11px] font-extrabold text-[#172B36]">
                                    {{ provider.name }}
                                </h4>
                                <p class="mt-1 text-[10px] text-[#8A6418]">★ {{ provider.rating }} <span class="text-[#89958F]">({{ provider.reviews }})</span></p>
                                <p class="mt-1 text-[10px] text-[#718078]">{{ provider.location }}</p>
                                <button
                                    type="button"
                                    class="mt-2 w-full rounded-lg bg-[#EAF3EF] py-2 text-[10px] font-bold text-[#075B53] transition hover:bg-[#D6E9E1]"
                                    @click="sendMessage(`I want to know more about ${provider.name}.`)"
                                >
                                    View profile →
                                </button>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div v-if="loading" class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#E5F0EC] text-sm font-black text-[#087E78]">Z</div>
                <div class="flex gap-1 rounded-xl border border-[#E8EEEA] bg-white px-4 py-3">
                    <span v-for="n in 3" :key="n" class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#087E78]" :style="{ animationDelay: `${n * 120}ms` }"></span>
                </div>
            </div>
        </div>

        <!-- Suggested prompts -->
        <div class="border-t border-[#E9EFEB] px-4 pt-4 sm:px-5">
            <div class="mb-3 flex items-center justify-between">
                <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#829087]">Try asking Zervo</p>
                <span class="text-[10px] text-[#A1AAA4]">Tap to start</span>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-4">
                <button
                    v-for="suggestion in suggestions"
                    :key="suggestion"
                    type="button"
                    class="shrink-0 rounded-full border border-[#DCE8E1] bg-[#F7FAF7] px-3 py-2 text-[10px] font-semibold text-[#315B50] transition hover:border-[#087E78] hover:bg-[#EAF4EF]"
                    @click="sendMessage(suggestion)"
                >
                    + {{ suggestion }}
                </button>
            </div>
        </div>

        <!-- Quick actions -->
        <div class="flex flex-wrap gap-2 border-t border-[#EDF0EC] px-4 py-3 sm:px-5">
            <button
                v-for="(action, index) in quickActions"
                :key="action"
                type="button"
                class="rounded-full bg-[#FFF5E3] px-3 py-2 text-[10px] font-bold text-[#79500F] transition hover:bg-[#FCE8BF]"
                @click="useQuickAction(action)"
            >
                {{ ['◈', '◷', '☷', '⇄'][index] }} {{ action }}
            </button>
        </div>

        <!-- Composer -->
        <form class="flex items-center gap-2 border-t border-[#E9EFEB] bg-white p-3 sm:p-4" @submit.prevent="sendMessage()">
            <span class="pl-1 text-xl text-[#82958A]">⌁</span>
            <input
                v-model="input"
                type="text"
                placeholder="Describe your requirement..."
                class="min-w-0 flex-1 border-0 bg-transparent text-xs text-[#172B36] outline-none ring-0 placeholder:text-[#9AA69F] focus:border-0 focus:outline-none focus:ring-0 sm:text-sm"
            />
            <button
                type="submit"
                :disabled="!input.trim() || loading"
                aria-label="Send message"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F59E0B] text-lg font-bold text-[#073B3A] transition hover:bg-[#E9A008] disabled:cursor-not-allowed disabled:opacity-40"
            >
                ↑
            </button>
        </form>
        <p class="bg-white pb-3 text-center text-[9px] text-[#A0AAA3]">
            AI-assisted requirement discovery · Demo recommendations
        </p>
    </section>
</template>
