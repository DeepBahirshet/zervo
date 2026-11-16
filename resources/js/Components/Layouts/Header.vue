
<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const mobileMenuOpen = ref(false);

const user = computed(() => page.props.auth.user);

const isActive = (path) => page.url.startsWith(path);

const navClass = (path) => [
    "rounded-xl px-3 py-2 text-sm font-semibold transition",
    isActive(path)
        ? "bg-white/10 text-[#FF9B38]"
        : "text-white/80 hover:bg-white/10 hover:text-[#FF9B38]",
];
</script>

<template>
    <header class="relative z-50 border-b border-white/10 bg-[#003528] text-white">
        <div class="mx-auto flex max-w-[1400px] items-center justify-between px-6 py-4 lg:px-12">

            <!-- Logo -->
            <Link :href="route('home')" class="flex items-center gap-2">
                <span class="text-4xl font-black text-[#FF7900]">Z</span>
                <span class="text-2xl font-extrabold tracking-tight">
                    Zervo<span class="text-[#FF7900]">.</span>
                </span>
            </Link>

            <!-- Desktop navigation -->
            <nav class="hidden items-center gap-2 lg:flex">
                <Link
                    v-if="user?.is_admin"
                    :href="route('admin.index')"
                    :class="navClass('/admin')"
                >
                    Admin
                </Link>

                <Link
                    :href="route('requirements.index')"
                    :class="navClass('/requirements')"
                >
                    Requirements
                </Link>

                <Link
                    :href="route('applications.index')"
                    :class="navClass('/applications')"
                >
                    My Applications
                </Link>

                <Link
                    :href="route('profile')"
                    :class="navClass('/profile')"
                >
                    Profile
                </Link>
            </nav>

            <!-- Desktop actions -->
            <div class="hidden items-center gap-3 lg:flex">
                <span class="text-sm font-medium text-white/70">
                    Hi, {{ user?.name }}
                </span>

                <Link
                    :href="route('requirements.create')"
                    class="rounded-xl bg-[#FF7900] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#F36B00]"
                >
                    Post a Requirement
                </Link>

                <Link
                    :href="route('logout')"
                    class="rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                >
                    Logout
                </Link>
            </div>

            <!-- Mobile menu button -->
            <button
                type="button"
                class="rounded-lg border border-white/20 px-4 py-2 text-sm lg:hidden"
                @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen"
                aria-label="Toggle navigation"
            >
                {{ mobileMenuOpen ? "Close" : "Menu" }}
            </button>
        </div>

        <!-- Mobile navigation -->
        <div
            v-if="mobileMenuOpen"
            class="border-t border-white/10 bg-[#003528] px-6 py-5 lg:hidden"
        >
            <nav class="flex flex-col gap-3">

                <Link
                    v-if="user?.is_admin"
                    :href="route('admin.index')"
                    :class="navClass('/admin')"
                    @click="mobileMenuOpen = false"
                >
                    Admin
                </Link>

                <Link
                    :href="route('requirements.index')"
                    :class="navClass('/requirements')"
                    @click="mobileMenuOpen = false"
                >
                    Requirements
                </Link>

                <Link
                    :href="route('applications.index')"
                    :class="navClass('/applications')"
                    @click="mobileMenuOpen = false"
                >
                    My Applications
                </Link>

                <Link
                    :href="route('profile')"
                    :class="navClass('/profile')"
                    @click="mobileMenuOpen = false"
                >
                    Profile
                </Link>

                <Link
                    :href="route('requirements.create')"
                    class="mt-2 rounded-xl bg-[#FF7900] px-5 py-3 text-center text-sm font-bold text-white"
                    @click="mobileMenuOpen = false"
                >
                    Post a Requirement
                </Link>

                <Link
                    :href="route('logout')"
                    class="rounded-xl border border-white/20 px-5 py-3 text-center text-sm font-semibold text-white"
                    @click="mobileMenuOpen = false"
                >
                    Logout
                </Link>
            </nav>
        </div>
    </header>
</template>
