
<script setup>
import { Link } from '@inertiajs/vue3';
import {
        Instagram,
        Linkedin,
    } from 'lucide-vue-next';

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
</script>

<template>
    <!-- FOOTER -->
    <footer class="relative overflow-hidden bg-[#002F25] text-white">
        <div class="pointer-events-none absolute -right-20 -top-40 h-96 w-96 rounded-full bg-[#087E55]/20 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1400px] px-6 pb-8 pt-16 lg:px-12">
            <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">

                <div>
                    <!-- Logo -->
                    <Link href="/" class="flex items-center">
                        <img
                            src="/images/zervo-logo-white.png"
                            alt="Zervo"
                            class="h-15 w-auto object-contain"
                        />
                    </Link>

                    <p class="mt-5 max-w-sm leading-7 text-white/60">
                        Your local home services marketplace.
                        Find trusted professionals and get your
                        everyday home needs taken care of.
                    </p>

                    <div class="mt-6 flex gap-3">
                        <a
                            href="#"
                            aria-label="Instagram"
                            class="social-link"
                        >
                            <Instagram :size="18" />
                        </a>

                        <a
                            href="#"
                            aria-label="LinkedIn"
                            class="social-link"
                        >
                            <Linkedin :size="18" />
                        </a>
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

                <p>Made for better living. <span class="text-[#FF7900]"></span></p>

            </div>
        </div>
    </footer>
</template>

<style scoped>
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
</style>
