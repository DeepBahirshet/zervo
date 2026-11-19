
<script setup>
import { Link } from '@inertiajs/vue3';
import {
    MapPin,
    Wallet,
    Clock3,
    ArrowRight,
    BriefcaseBusiness,
} from 'lucide-vue-next';

defineProps({
    requirements: {
        type: Array,
        default: () => [],
    },
});

const formatBudget = (requirement) => {
    const min = requirement.budget_min;
    const max = requirement.budget_max;

    if (min && max) {
        return `₹${Number(min).toLocaleString('en-IN')} - ₹${Number(max).toLocaleString('en-IN')}`;
    }

    if (max) {
        return `Up to ₹${Number(max).toLocaleString('en-IN')}`;
    }

    if (min) {
        return `From ₹${Number(min).toLocaleString('en-IN')}`;
    }

    return 'Budget not specified';
};

const formatDate = (date) => {
    if (!date) return '';

    return new Date(date).toLocaleDateString('en-IN', {
        day: 'numeric',
        month: 'short',
    });
};
</script>

<template>
    <section class="bg-[#FFF9F0] py-20 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <!-- Section heading -->
            <div class="mb-12 flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                <div>

                    <h2 class="text-3xl font-bold tracking-tight text-[#003528] sm:text-4xl">
                        Find Work Around
                        <span class="text-[#FF7900]">Your Area</span>
                    </h2>

                    <p class="mt-4 max-w-2xl text-base leading-7 text-gray-600">
                        Discover local service requests from people who need
                        skilled professionals in their area.
                    </p>
                </div>

                <Link
                    href="/requirements"
                    class="inline-flex shrink-0 items-center gap-2 font-semibold text-[#003D2D] transition hover:text-[#FF7900]"
                >
                    Browse all requirements
                    
                </Link>
            </div>

            <!-- Requirements -->
            <div
                v-if="requirements.length"
                class="grid gap-6 md:grid-cols-2 lg:grid-cols-4"
            >
                
            <article
                v-for="requirement in requirements.slice(0, 4)"
                :key="requirement.id"
                class="group flex min-w-0 flex-col rounded-2xl border border-[#003D2D]/10 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#FF7900]/40 hover:shadow-xl sm:p-5 lg:p-6"
            >
                <!-- Card top -->
                <div class="mb-4 flex flex-wrap items-center justify-between gap-2 sm:mb-5">
                    <span class="max-w-[75%] truncate rounded-full bg-[#003D2D]/10 px-3 py-1.5 text-[11px] font-semibold text-[#003D2D] sm:text-xs">
                        {{ requirement.service_category?.name ?? 'Local Service' }}
                    </span>

                    <span class="flex shrink-0 items-center gap-1.5 text-xs font-medium text-emerald-700">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Open
                    </span>
                </div>

                <!-- Title -->
                <h3 class="mb-2 line-clamp-2 text-base font-bold leading-snug text-gray-900 transition group-hover:text-[#003D2D] sm:mb-3 sm:text-lg">
                    {{ requirement.title }}
                </h3>

                <!-- Description -->
                <p class="mb-5 line-clamp-3 flex-grow text-[13px] leading-5 text-gray-500 sm:mb-6 sm:text-sm sm:leading-6">
                    {{ requirement.description || 'A local service requirement is waiting for a suitable professional.' }}
                </p>

                <!-- Details -->
                <div class="space-y-3 border-t border-gray-100 pt-4 sm:pt-5">
                    <div class="flex min-w-0 items-center gap-2 text-xs text-gray-600 sm:text-sm">
                        <MapPin class="h-4 w-4 shrink-0 text-[#FF7900]" />
                        <span class="min-w-0 truncate">
                            {{ requirement.location || 'Location not specified' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-gray-600 sm:text-sm">
                        <Wallet class="h-4 w-4 shrink-0 text-[#FF7900]" />
                        <span class="min-w-0 truncate">{{ formatBudget(requirement) }}</span>
                    </div>

                    <div
                        v-if="requirement.created_at"
                        class="flex items-center gap-2 text-xs text-gray-500 sm:text-sm"
                    >
                        <Clock3 class="h-4 w-4 shrink-0" />
                        <span>Posted {{ formatDate(requirement.created_at) }}</span>
                    </div>
                </div>

                <!-- Action -->
                <Link
                    :href="`/requirements/${requirement.id}`"
                    class="mt-5 flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#003D2D] px-4 py-3 text-sm font-semibold text-white transition duration-300 hover:bg-[#FF7900] active:scale-[0.98] sm:mt-6"
                >
                    View Requirement
                </Link>
            </article>

            </div>

            <!-- Empty state -->
            <div
                v-else
                class="rounded-2xl border border-dashed border-[#003D2D]/20 bg-white px-6 py-16 text-center"
            >
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#003D2D]/10">
                    <BriefcaseBusiness class="h-8 w-8 text-[#003D2D]" />
                </div>

                <h3 class="text-xl font-bold text-[#003528]">
                    No requirements available yet
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    New local opportunities will appear here when they are posted.
                </p>

                <Link
                    href="/requirements"
                    class="mt-6 inline-flex items-center gap-2 font-semibold text-[#003D2D] hover:text-[#FF7900]"
                >
                    Explore requirements
                    <ArrowRight class="h-4 w-4" />
                </Link>
            </div>

        </div>
    </section>
</template>
