
<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X } from 'lucide-vue-next';

const mobileMenuOpen = ref(false);
const page = usePage();

const user = computed(() => page.props.auth?.user ?? null);
const isLoggedIn = computed(() => !!user.value);

const isActive = (href) => {
    const currentPath = page.url.split('?')[0];

    if (href === '/') {
        return currentPath === '/';
    }

    return currentPath === href || currentPath.startsWith(`${href}/`);
};

const isAdmin = computed(() => user.value?.is_admin === true);

const navLinks = [
    { label: 'Home', href: '/' },
    { label: 'Find Services', href: '/requirements' },
    { label: 'Categories', href: '/categories' },
    { label: 'About', href: '/about' },
    { label: 'Insights', href: '/insights' },
    { label: 'For Providers', href: '/register' },
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
                    class="h-15 w-auto object-contain"
                />
            </Link>

            <!-- Desktop Navigation -->
            <nav class="hidden items-center gap-8 lg:flex">
                <Link
                    v-for="link in navLinks"
                    :key="link.label"
                    :href="link.href"
                    :class="[
                        'border-b-2 py-2 text-sm font-semibold transition',
                        isActive(link.href)
                            ? 'border-[#FF7900] text-[#FF9B38]'
                            : 'border-transparent text-white/80 hover:text-[#FF9B38]'
                    ]"
                >
                    {{ link.label }}
                </Link>
            </nav>

            <Link
                v-if="isAdmin"
                href="/admin/index"
                :class="[
                    'border-b-2 py-2 text-sm font-semibold transition',
                    isActive('/admin')
                        ? 'border-[#FF7900] text-[#FF9B38]'
                        : 'border-transparent text-white/80 hover:text-[#FF9B38]'
                ]"
            >
                Control Center
            </Link>

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
                        method="get"
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
                class="rounded-lg border border-white/20 p-2 transition hover:bg-white/10 lg:hidden"
                @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen"
                aria-label="Toggle navigation"
            >
                <X v-if="mobileMenuOpen" class="h-6 w-6" />
                <Menu v-else class="h-6 w-6" />
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div
            v-if="mobileMenuOpen"
            class="border-t border-white/10 bg-[#003528] px-6 py-5 lg:hidden"
        >
            <nav class="flex flex-col gap-3">
                <Link
                    v-for="link in navLinks"
                    :key="link.label"
                    :href="link.href"
                    :class="[
                        'rounded-lg px-4 py-3 text-sm font-semibold transition',
                        isActive(link.href)
                            ? 'bg-white/10 text-[#FF9B38]'
                            : 'text-white/80 hover:bg-white/5 hover:text-[#FF9B38]'
                    ]"
                    @click="mobileMenuOpen = false"
                >
                    {{ link.label }}
                </Link>

                <Link
                    v-if="isAdmin"
                    href="/admin/index"
                    :class="[
                        'rounded-lg px-4 py-3 text-sm font-semibold transition',
                        isActive('/admin')
                            ? 'bg-white/10 text-[#FF9B38]'
                            : 'text-white/80 hover:bg-white/5 hover:text-[#FF9B38]'
                    ]"
                    @click="mobileMenuOpen = false"
                >
                    Control Center
                </Link>

                <template v-if="isLoggedIn">
                    <span class="px-4 pt-2 text-sm font-medium text-white/70">
                        Hi, {{ user.name }}
                    </span>

                    <Link
                        :href="route('requirements.create')"
                        class="rounded-xl bg-[#FF7900] px-5 py-3 text-center font-bold text-white"
                        @click="mobileMenuOpen = false"
                    >
                        Post a Requirement
                    </Link>

                    <Link
                        :href="route('logout')"
                        method="get"
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
                        class="rounded-lg px-4 py-3 text-sm font-semibold text-white/80 hover:bg-white/5"
                        @click="mobileMenuOpen = false"
                    >
                        Sign In
                    </Link>

                    <Link
                        :href="route('requirements.create')"
                        class="rounded-xl bg-[#FF7900] px-5 py-3 text-center font-bold text-white"
                        @click="mobileMenuOpen = false"
                    >
                        Post a Requirement
                    </Link>
                </template>
            </nav>
        </div>
    </header>
</template>
