
<script setup>
import { ref } from 'vue';

const mobileMenuOpen = ref(false);

const navLinks = [
    { label: 'Explore Services', href: '/#services' },
    { label: 'Find Professionals', href: '/#services' },
    { label: 'Requirements', href: '/login' },
    { label: 'How It Works', href: '/#how-it-works' },
];
</script>

<template>
    <header class="relative z-50 border-b border-white/10 bg-[#003528] text-white">
        <div class="mx-auto flex max-w-[1400px] items-center justify-between px-6 py-4 lg:px-12">

            <a href="/" class="flex items-center gap-3">
                <span class="text-4xl font-black text-[#FF7900]">Z</span>
                <span class="text-2xl font-extrabold tracking-tight">
                    Zervo<span class="text-[#FF7900]">.</span>
                </span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                <a
                    v-for="link in navLinks"
                    :key="link.label"
                    :href="link.href"
                    class="text-sm font-semibold text-white/80 transition hover:text-[#FF9B38]"
                >
                    {{ link.label }}
                </a>
                <a href="/register" class="text-sm font-semibold text-white/80 hover:text-[#FF9B38]">
                    For Providers
                </a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                <a href="/login" class="rounded-xl border border-white/30 px-6 py-3 text-sm font-semibold transition hover:bg-white/10">
                    Sign In
                </a>
                <a href="/register" class="rounded-xl bg-[#FF7900] px-6 py-3 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[#F36B00]">
                    + Post a Requirement
                </a>
            </div>

            <button
                type="button"
                class="rounded-lg border border-white/20 px-4 py-2 lg:hidden"
                @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen"
                aria-label="Toggle navigation"
            >
                {{ mobileMenuOpen ? '✕' : '☰' }}
            </button>
        </div>

        <div v-if="mobileMenuOpen" class="border-t border-white/10 bg-[#003528] px-6 py-5 lg:hidden">
            <nav class="flex flex-col gap-5">
                <a
                    v-for="link in navLinks"
                    :key="link.label"
                    :href="link.href"
                    class="text-sm font-semibold text-white/80"
                    @click="mobileMenuOpen = false"
                >
                    {{ link.label }}
                </a>

                <a href="/register" class="text-sm font-semibold text-white/80">
                    For Providers
                </a>

                <a href="/login" class="text-sm font-semibold text-white/80">
                    Sign In
                </a>

                <a href="/register" class="rounded-xl bg-[#FF7900] px-5 py-3 text-center font-bold">
                    Post a Requirement
                </a>
            </nav>
        </div>
    </header>
</template>
