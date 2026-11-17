
<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import {
    ShieldCheck,
    ClipboardList,
    UserCheck,
    ChartNoAxesCombined,
    Newspaper,
    Activity,
    CheckCircle2,
} from 'lucide-vue-next';

const modules = [
    {
        title: 'Manage Requirements',
        description: 'Review, approve, reject and monitor service requirements submitted by customers.',
        icon: ClipboardList,
        href: route('admin.requirements.index'),
        color: 'green',
        label: 'Marketplace',
    },
    {
        title: 'Approve Profiles',
        description: 'Review provider profiles, verify submitted information and manage profile approvals.',
        icon: UserCheck,
        href: '/admin/profiles',
        color: 'orange',
        label: 'Verification',
    },
    {
        title: 'Statistics & Analytics',
        description: 'Monitor users, requirements, applications, completed projects and marketplace growth.',
        icon: ChartNoAxesCombined,
        href: '/admin/statistics',
        color: 'blue',
        label: 'Analytics',
    },
    {
        title: 'Manage Blogs',
        description: 'Create articles, edit existing content, publish posts and manage Zervo insights.',
        icon: Newspaper,
        href: '/admin/blogs',
        color: 'purple',
        label: 'Content',
    },
];
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FFF9F0]">
            <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

                <!-- Welcome Banner -->
                <section class="relative mb-10 overflow-hidden rounded-3xl bg-gradient-to-br from-[#003D2D] via-[#004B36] to-[#07563A] p-8 text-white shadow-lg sm:p-10">

                    <div class="relative z-10 max-w-2xl">
                        <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium">
                            <ShieldCheck class="h-4 w-4 text-[#FF9B38]" />
                            Administration Center
                        </div>

                        <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                            Welcome to Zervo Admin
                        </h1>

                        <p class="mt-4 max-w-xl text-sm leading-7 text-white/70 sm:text-base">
                            Manage your marketplace, oversee service providers,
                            monitor platform performance and keep your community
                            running smoothly.
                        </p>

                        <div class="mt-7 flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-2 rounded-xl bg-white/10 px-4 py-3 text-sm">
                                <Activity class="h-4 w-4 text-[#FF9B38]" />
                                <span>Platform Management</span>
                            </div>

                            <div class="flex items-center gap-2 rounded-xl bg-white/10 px-4 py-3 text-sm">
                                <ShieldCheck class="h-4 w-4 text-[#FF9B38]" />
                                <span>Admin Access</span>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-20 -top-28 h-80 w-80 rounded-full border-[45px] border-white/5"></div>
                    <div class="pointer-events-none absolute -bottom-32 right-40 h-72 w-72 rounded-full bg-[#FF7900]/10 blur-3xl"></div>

                    <ShieldCheck class="pointer-events-none absolute bottom-8 right-12 hidden h-36 w-36 text-white/[0.07] lg:block" />
                </section>

                <!-- Section Heading -->
                <div class="mb-7">
                    <h2 class="text-2xl font-bold text-[#003528]">
                        Management Modules
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Access and manage different areas of the Zervo platform.
                    </p>
                </div>

                <!-- Management Cards -->
                <div class="grid gap-6 sm:grid-cols-2">

                    <div
                        v-for="module in modules"
                        :key="module.title"
                        class="group flex flex-col rounded-2xl border border-[#003D2D]/10 bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#FF7900]/40 hover:shadow-xl"
                    >
                        <!-- Card Header -->
                        <div class="flex items-start justify-between">
                            <div
                                :class="[
                                    'flex h-14 w-14 items-center justify-center rounded-2xl',
                                    module.color === 'green' && 'bg-[#003D2D]/10 text-[#003D2D]',
                                    module.color === 'orange' && 'bg-orange-50 text-[#FF7900]',
                                    module.color === 'blue' && 'bg-blue-50 text-blue-600',
                                    module.color === 'purple' && 'bg-purple-50 text-purple-600',
                                ]"
                            >
                                <component :is="module.icon" class="h-7 w-7" />
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="mt-7 flex-grow">
                            <span class="text-xs font-semibold uppercase tracking-wider text-[#FF7900]">
                                {{ module.label }}
                            </span>

                            <h3 class="mt-2 text-xl font-bold text-[#003528]">
                                {{ module.title }}
                            </h3>

                            <p class="mt-3 text-sm leading-7 text-gray-500">
                                {{ module.description }}
                            </p>
                        </div>

                        <!-- Card Action -->
                        <div class="mt-7 border-t border-gray-100 pt-5">
                            <Link
                                :href="module.href"
                                class="inline-flex items-center justify-center rounded-lg bg-[#003D2D] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#07563A]"
                            >
                                Manage
                            </Link>
                        </div>
                    </div>

                </div>

                <!-- Bottom Information -->
                <div class="mt-10 flex flex-col gap-4 rounded-2xl border border-[#003D2D]/10 bg-white p-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#003D2D]/10">
                            <CheckCircle2 class="h-6 w-6 text-[#003D2D]" />
                        </div>

                        <div>
                            <h3 class="font-bold text-[#003528]">
                                Keep Zervo running smoothly
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Review marketplace submissions and maintain platform quality.
                            </p>
                        </div>
                    </div>

                    <Link
                        :href="route('admin.requirements.index')"
                        class="inline-flex shrink-0 items-center justify-center font-semibold text-[#003D2D] transition hover:text-[#FF7900]"
                    >
                        Review Requirements
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
