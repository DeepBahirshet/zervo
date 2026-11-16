
<script setup>
import { Head } from '@inertiajs/vue3';
import PublicHeader from '@/Components/Layout/PublicHeader.vue';
import { ref } from 'vue';
import ZervoChat from '@/Components/AI/ZervoChat.vue';

const categories = [
    { icon: '🚰', name: 'Plumbing', description: 'Pipes, taps and water repairs', color: 'orange' },
    { icon: '⚡', name: 'Electrical', description: 'Wiring, switches and lighting', color: 'green' },
    { icon: '🪚', name: 'Carpentry', description: 'Furniture and woodwork', color: 'orange' },
    { icon: '🖌️', name: 'Painting', description: 'Interior and exterior painting', color: 'green' },
    { icon: '❄️', name: 'AC & Appliances', description: 'AC and appliance servicing', color: 'orange' },
    { icon: '🧹', name: 'Home Cleaning', description: 'Deep cleaning and home care', color: 'green' },
    { icon: '🛡️', name: 'Pest Control', description: 'Pest prevention and treatment', color: 'orange' },
    { icon: '🏠', name: 'Home Renovation', description: 'Repairs and improvements', color: 'green' },
    { icon: '🌱', name: 'Gardening', description: 'Garden and outdoor maintenance', color: 'orange' },
    { icon: '🚚', name: 'Moving Services', description: 'Packing and house shifting', color: 'green' },
];

const steps = [
    {
        number: '01',
        icon: '📝',
        title: 'Post Your Requirement',
        description: 'Describe what you need, your location and preferred date.',
    },
    {
        number: '02',
        icon: '👥',
        title: 'Get Proposals',
        description: 'Receive proposals from relevant local professionals.',
    },
    {
        number: '03',
        icon: '🤝',
        title: 'Choose & Get It Done',
        description: 'Compare options, select a provider and get your work done.',
    },
];

const benefits = [
    {
        icon: '🛡️',
        title: 'Verified Professionals',
        description: 'Find trusted service providers with genuine profiles.',
    },
    {
        icon: '⭐',
        title: 'Real Reviews',
        description: 'Make confident decisions based on customer feedback.',
    },
    {
        icon: '⚡',
        title: 'Local & Convenient',
        description: 'Discover professionals serving your area.',
    },
    {
        icon: '₹',
        title: 'Transparent Pricing',
        description: 'Compare proposals and choose what fits your budget.',
    },
];

const footerGroups = [
    {
        title: 'Explore',
        links: [
            { label: 'Home', href: '/' },
            { label: 'Services', href: '#services' },
            { label: 'How it works', href: '#how-it-works' },
        ],
    },
    {
        title: 'Account',
        links: [
            { label: 'Sign in', href: '/login' },
            { label: 'Create account', href: '/register' },
            { label: 'Become a provider', href: '/register' },
        ],
    },
    {
        title: 'Support',
        links: [
            { label: 'Contact us', href: 'mailto:support@zervo.in' },
            { label: 'Help center', href: '#' },
            { label: 'Privacy policy', href: '#' },
        ],
    },
];

const selectedService = ref('');

function selectService(service) {
    selectedService.value = service;

    document.getElementById('assistant')?.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
    });
}
</script>

<template>
    <Head title="Zervo | Home Services Made Simple" />

    <div class="min-h-screen overflow-hidden bg-[#FFF9F0] text-[#172B25]">

        <PublicHeader />

        <!-- HERO -->
        <section class="hero-section relative isolate overflow-hidden">
            <div class="hero-glow hero-glow-one"></div>
            <div class="hero-glow hero-glow-two"></div>

            <div class="absolute -right-32 bottom-[-200px] h-[450px] w-[450px] rounded-full bg-[#FF7900] opacity-90 blur-[1px]"></div>

            <div class="relative mx-auto grid max-w-[1400px] items-center gap-12 px-6 py-16 lg:grid-cols-[0.95fr_1.05fr] lg:px-12 lg:py-20">

                <!-- Hero content -->
                <div class="relative z-10 text-white">

                    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-5 py-3 text-sm font-semibold text-[#FFD18A] backdrop-blur">
                        <span class="text-lg">✦</span>
                        Your Local Home Services Marketplace
                    </div>

                    <h1 class="mt-8 max-w-2xl text-5xl font-extrabold leading-[1.08] tracking-tight sm:text-6xl xl:text-7xl">
                        Find Trusted
                        <br />
                        Home Service
                        <br />
                        Professionals
                        <span class="text-[#FF850D]">with AI.</span>
                    </h1>

                    <p class="mt-7 max-w-xl text-lg leading-8 text-white/80 sm:text-xl">
                        Describe what you need, and Zervo AI will understand
                        your requirement, suggest the right professionals,
                        and help you get it done — quickly and reliably.
                    </p>

                    <!-- Benefits -->
                    <div class="mt-9 space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-2xl">
                                ⚡
                            </div>
                            <div>
                                <h3 class="font-bold text-white">AI-Assisted Requests</h3>
                                <p class="text-sm text-white/65">Describe your needs in simple words.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-2xl">
                                🛡️
                            </div>
                            <div>
                                <h3 class="font-bold text-white">Trusted Professionals</h3>
                                <p class="text-sm text-white/65">Connect with skilled local providers.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-2xl">
                                🕒
                            </div>
                            <div>
                                <h3 class="font-bold text-white">Quick Responses</h3>
                                <p class="text-sm text-white/65">Get proposals from relevant professionals.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-9 flex flex-wrap gap-4">
                        <a
                            href="/register"
                            class="rounded-xl bg-[#FF7900] px-7 py-4 font-bold text-white shadow-lg shadow-orange-950/20 transition hover:-translate-y-1 hover:bg-[#F36B00]"
                        >
                            Post a Requirement →
                        </a>

                        <a
                            href="#services"
                            class="rounded-xl border border-white/30 px-7 py-4 font-semibold text-white transition hover:bg-white/10"
                        >
                            Explore Services
                        </a>
                    </div>
                </div>

                <!-- Existing interactive chat -->
                <div class="relative z-10" id="assistant">
                    <div class="absolute -inset-5 rounded-[2.5rem] bg-gradient-to-br from-[#FF7900]/20 via-white/10 to-emerald-300/20 blur-2xl"></div>

                    <div class="relative rounded-[2rem] border border-white/50 bg-[#FFF8EF] p-2 shadow-[0_30px_100px_rgba(0,0,0,0.3)]">
                        <ZervoChat :initial-service="selectedService" />
                    </div>
                </div>

            </div>
        </section>

        <!-- SERVICES -->
        <section id="services" class="relative py-24">
            <div class="pointer-events-none absolute -right-32 top-0 h-96 w-96 rounded-full bg-orange-200/30 blur-[100px]"></div>

            <div class="relative mx-auto max-w-[1400px] px-6 lg:px-12">

                <div class="mb-12 flex flex-col justify-between gap-5 md:flex-row md:items-end">
                    <div>
                        <span class="text-sm font-bold uppercase tracking-[0.2em] text-[#D66A00]">
                            Explore our services
                        </span>

                        <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-[#123E2E] md:text-5xl">
                            Home Services
                            <br class="sm:hidden" />
                            You Can <span class="text-[#F47700]">Rely On.</span>
                        </h2>

                        <p class="mt-4 max-w-xl text-lg text-gray-500">
                            Choose from a wide range of home services
                            offered by local professionals.
                        </p>
                    </div>

                    <a href="/register" class="font-bold text-[#0C6246] transition hover:text-[#F47700]">
                        View all services →
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                    <button
                            v-for="(category, index) in categories"
                            :key="category.name"
                            type="button"
                            @click="selectService(category.name)"
                            class="service-card group relative w-full overflow-hidden rounded-2xl border border-[#EDE4D8] bg-white p-5 text-left shadow-sm transition duration-300 hover:-translate-y-2 hover:border-[#F47700]/30 hover:shadow-xl sm:p-6"
                        >
                        <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-[#FF7900]/5 transition-transform duration-500 group-hover:scale-[2]"></div>

                        <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl text-3xl transition duration-300 group-hover:scale-110"
                            :class="category.color === 'orange' ? 'bg-orange-100' : 'bg-emerald-100'"
                        >
                            {{ category.icon }}
                        </div>

                        <h3 class="relative mt-5 text-base font-bold text-[#123E2E] sm:text-lg">
                            {{ category.name }}
                        </h3>

                        <p class="relative mt-2 min-h-10 text-xs leading-5 text-gray-500 sm:text-sm">
                            {{ category.description }}
                        </p>

                        <div class="relative mt-5 flex items-center justify-between">
                            <span class="text-xs font-bold text-[#0C6246]">Explore service</span>
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#FFF1E1] text-[#F47700] transition group-hover:bg-[#F47700] group-hover:text-white">
                                →
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </section>

        <!-- HOW IT WORKS -->
        <section id="how-it-works" class="px-6 pb-20 lg:px-12">
            <div class="relative mx-auto max-w-[1400px] overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#003D2D] via-[#064B35] to-[#003528] px-7 py-14 text-white shadow-xl sm:px-12">

                <div class="pointer-events-none absolute -right-20 -top-32 h-80 w-80 rounded-full bg-[#FF7900]/20 blur-[100px]"></div>

                <div class="relative grid gap-10 lg:grid-cols-[0.8fr_2fr] lg:items-center">

                    <div>
                        <span class="text-sm font-bold uppercase tracking-widest text-[#FFB45D]">
                            Simple process
                        </span>

                        <h2 class="mt-4 text-4xl font-extrabold">
                            How <span class="text-[#FF850D]">Zervo</span> Works?
                        </h2>

                        <p class="mt-4 max-w-xs leading-7 text-white/70">
                            Get your home tasks done in three simple steps.
                        </p>
                    </div>

                    <div class="grid gap-8 md:grid-cols-3">
                        <div
                            v-for="step in steps"
                            :key="step.number"
                            class="group text-center"
                        >
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full border border-[#FF7900]/30 bg-white/10 text-4xl transition duration-300 group-hover:scale-110 group-hover:bg-[#FF7900]/20">
                                {{ step.icon }}
                            </div>

                            <p class="mt-5 text-xs font-bold tracking-widest text-[#FFB45D]">
                                STEP {{ step.number }}
                            </p>

                            <h3 class="mt-2 text-lg font-bold">
                                {{ step.title }}
                            </h3>

                            <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-white/65">
                                {{ step.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WHY ZERVO -->
        <section class="py-16">
            <div class="mx-auto max-w-[1400px] px-6 lg:px-12">

                <div class="text-center">
                    <span class="text-sm font-bold uppercase tracking-widest text-[#D66A00]">
                        The Zervo difference
                    </span>

                    <h2 class="mt-4 text-4xl font-extrabold text-[#123E2E]">
                        Why Choose <span class="text-[#F47700]">Zervo?</span>
                    </h2>
                </div>

                <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="benefit in benefits"
                        :key="benefit.title"
                        class="group flex gap-4 rounded-2xl p-5 transition duration-300 hover:-translate-y-1 hover:bg-white hover:shadow-lg"
                    >
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-orange-100 text-2xl transition group-hover:rotate-6">
                            {{ benefit.icon }}
                        </div>

                        <div>
                            <h3 class="font-bold text-[#123E2E]">
                                {{ benefit.title }}
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                {{ benefit.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="px-6 py-16 lg:px-12">
            <div class="relative mx-auto max-w-[1400px] overflow-hidden rounded-[2rem] bg-gradient-to-r from-[#003D2D] via-[#07563A] to-[#003D2D] px-8 py-12 text-white shadow-xl md:px-16">

                <div class="absolute -right-20 -top-32 h-72 w-72 rounded-full bg-[#FF7900]/30 blur-[90px]"></div>

                <div class="relative flex flex-col items-center justify-between gap-8 md:flex-row">
                    <div>
                        <span class="text-sm font-bold uppercase tracking-widest text-[#FFB45D]">
                            Your home, taken care of
                        </span>

                        <h2 class="mt-3 text-3xl font-extrabold md:text-4xl">
                            Need a home service now?
                        </h2>

                        <p class="mt-4 max-w-xl text-white/70">
                            Post your requirement and connect with trusted
                            local professionals.
                        </p>
                    </div>

                    <a
                        href="/register"
                        class="shrink-0 rounded-xl bg-[#FF7900] px-8 py-4 font-bold text-white shadow-lg transition hover:-translate-y-1 hover:bg-[#F36B00]"
                    >
                        + Post a Requirement →
                    </a>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="relative overflow-hidden bg-[#002F25] text-white">
            <div class="pointer-events-none absolute -right-20 -top-40 h-96 w-96 rounded-full bg-[#087E55]/20 blur-[100px]"></div>

            <div class="relative mx-auto max-w-[1400px] px-6 pb-8 pt-16 lg:px-12">

                <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">

                    <div>
                        <a href="/" class="text-4xl font-extrabold tracking-tight">
                            <span class="text-[#FF7900]">Z</span>ervo<span class="text-[#FF7900]">.</span>
                        </a>

                        <p class="mt-5 max-w-sm leading-7 text-white/60">
                            Your local home services marketplace.
                            Find trusted professionals and get your
                            everyday home needs taken care of.
                        </p>

                        <div class="mt-6 flex gap-3">
                            <a href="#" aria-label="Instagram" class="social-link">IG</a>
                            <a href="#" aria-label="LinkedIn" class="social-link">in</a>
                        </div>
                    </div>

                    <div v-for="group in footerGroups" :key="group.title">
                        <h3 class="font-bold text-white">{{ group.title }}</h3>

                        <ul class="mt-6 space-y-4">
                            <li v-for="link in group.links" :key="link.label">
                                <a
                                    :href="link.href"
                                    class="text-sm text-white/60 transition hover:text-[#FF9B38]"
                                >
                                    {{ link.label }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-16 flex flex-col justify-between gap-4 border-t border-white/10 pt-7 text-sm text-white/50 sm:flex-row">
                    <p>© {{ new Date().getFullYear() }} Zervo. All rights reserved.</p>
                    <p>Made with <span class="text-[#FF7900]">♥</span> in Kolhapur.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.hero-section {
    background:
        radial-gradient(ellipse at 15% 80%, rgba(9, 113, 67, 0.45), transparent 40%),
        linear-gradient(120deg, #002F24 0%, #00432E 55%, #003326 100%);
}

.hero-glow {
    position: absolute;
    pointer-events: none;
    border-radius: 9999px;
    filter: blur(90px);
}

.hero-glow-one {
    width: 350px;
    height: 350px;
    top: -150px;
    left: 35%;
    background: rgba(255, 121, 0, 0.12);
}

.hero-glow-two {
    width: 350px;
    height: 350px;
    bottom: -200px;
    left: -100px;
    background: rgba(8, 126, 85, 0.35);
}

.service-card {
    transform-style: preserve-3d;
}

.service-card:focus-visible {
    outline: 3px solid #F47700;
    outline-offset: 4px;
}

.social-link {
    display: flex;
    width: 40px;
    height: 40px;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.08);
    font-size: 12px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: #FF7900;
    color: white;
    transform: translateY(-3px);
}

@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        transition-duration: 0.01ms !important;
        animation-duration: 0.01ms !important;
    }
}
</style>
