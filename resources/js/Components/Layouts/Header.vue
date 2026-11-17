
<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const mobileMenuOpen = ref(false);
const page = usePage();

const user = computed(() => page.props.auth?.user ?? null);
const isLoggedIn = computed(() => !!user.value);

const navLinks = [
    { label: 'Explore Services', href: '/#services' },
    { label: 'Find Services', href: '/requirements' },
    { label: 'How It Works', href: '/#how-it-works' },
];
</script>

<template>
    <header class="relative z-50 border-b border-white/10 bg-[#003528] text-white">
        <div class="mx-auto flex max-w-[1400px] items-center justify-between px-6 py-4 lg:px-12">

            <!-- Logo -->
            <Link href="/" class="flex items-center">
                <img
                    src="/images/zervo-logo-white.png"
                    alt="Zervo"
                    class="h-12 w-auto object-contain"
                />
            </Link>

            <!-- Desktop Navigation -->
            <nav class="hidden items-center gap-8 lg:flex">
                <Link
                    v-for="link in navLinks"
                    :key="link.label"
                    :href="link.href"
                    class="text-sm font-semibold text-white/80 transition hover:text-[#FF9B38]"
                >
                    {{ link.label }}
                </Link>

                <Link
                    href="/register"
                    class="text-sm font-semibold text-white/80 transition hover:text-[#FF9B38]"
                >
                    For Providers
                </Link>
            </nav>

            <!-- Desktop Actions -->
            <div class="hidden items-center gap-3 lg:flex">
                <template v-if="isLoggedIn">
                    <span class="text-sm font-medium text-white/70">
                        Hi, {{ user.name }}
                    </span>

                    <Link
                        :href="route('requirements.create')"
                        class="rounded-xl bg-[#FF7900] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#F36B00]"
                    >
                        + Post a Requirement
                    </Link>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="cursor-pointer rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                    >
                        Logout
                    </Link>
                </template>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-xl border border-white/30 px-6 py-3 text-sm font-semibold transition hover:bg-white/10"
                    >
                        Sign In
                    </Link>

                    <Link
                        :href="route('requirements.create')"
                        class="rounded-xl bg-[#FF7900] px-6 py-3 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[#F36B00]"
                    >
                        + Post a Requirement
                    </Link>
                </template>
            </div>

            <!-- Mobile Toggle -->
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

        <!-- Mobile Navigation -->
        <div
            v-if="mobileMenuOpen"
            class="border-t border-white/10 bg-[#003528] px-6 py-5 lg:hidden"
        >
            <nav class="flex flex-col gap-5">
                <Link
                    v-for="link in navLinks"
                    :key="link.label"
                    :href="link.href"
                    class="text-sm font-semibold text-white/80"
                    @click="mobileMenuOpen = false"
                >
                    {{ link.label }}
                </Link>

                <Link
                    href="/register"
                    class="text-sm font-semibold text-white/80"
                    @click="mobileMenuOpen = false"
                >
                    For Providers
                </Link>

                <template v-if="isLoggedIn">
                    <span class="text-sm font-medium text-white/70">
                        Hi, {{ user.name }}
                    </span>

                    <Link
                        :href="route('requirements.create')"
                        class="rounded-xl bg-[#FF7900] px-5 py-3 text-center font-bold"
                        @click="mobileMenuOpen = false"
                    >
                        Post a Requirement
                    </Link>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="cursor-pointer rounded-xl border border-white/30 px-5 py-3 text-center font-semibold"
                        @click="mobileMenuOpen = false"
                    >
                        Logout
                    </Link>
                </template>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="text-sm font-semibold text-white/80"
                        @click="mobileMenuOpen = false"
                    >
                        Sign In
                    </Link>

                    <Link
                        :href="route('requirements.create')"
                        class="rounded-xl bg-[#FF7900] px-5 py-3 text-center font-bold"
                        @click="mobileMenuOpen = false"
                    >
                        Post a Requirement
                    </Link>
                </template>
            </nav>
        </div>
    </header>
</template>
