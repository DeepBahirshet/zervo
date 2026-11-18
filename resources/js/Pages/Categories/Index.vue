
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";

import {
    Wrench,
    Zap,
    Hammer,
    Paintbrush,
    AirVent,
    Sparkles,
    Bug,
    House,
    Flower2,
    Truck,
    ArrowRight,
    Search,
} from "lucide-vue-next";

defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});

const categoryDetails = {
    plumbing: {
        icon: Wrench,
        description: "Repairs, installations and maintenance for your plumbing needs.",
    },
    electrical: {
        icon: Zap,
        description: "Find professionals for wiring, electrical repairs and installations.",
    },
    carpentry: {
        icon: Hammer,
        description: "Custom furniture, woodwork, repairs and home installations.",
    },
    painting: {
        icon: Paintbrush,
        description: "Give your home a fresh look with professional painting services.",
    },
    "ac-appliances": {
        icon: AirVent,
        description: "AC servicing, appliance repairs and home equipment maintenance.",
    },
    "home-cleaning": {
        icon: Sparkles,
        description: "Keep your home fresh with reliable cleaning professionals.",
    },
    "pest-control": {
        icon: Bug,
        description: "Protect your home with professional pest control services.",
    },
    "home-renovation": {
        icon: House,
        description: "Upgrade, remodel and transform your living spaces.",
    },
    gardening: {
        icon: Flower2,
        description: "Garden maintenance, landscaping and plant care services.",
    },
    "moving-services": {
        icon: Truck,
        description: "Make relocation easier with dependable moving professionals.",
    },
};

const getCategoryDetails = (slug) => {
    return categoryDetails[slug] ?? {
        icon: Wrench,
        description: "Find trusted professionals for your service needs.",
    };
};
</script>

<template>
    <AuthenticatedLayout>
        <main class="min-h-screen bg-[#f8faf8]">

            <!-- Hero -->
            <section class="relative overflow-hidden bg-[#003528] px-5 py-20 text-white sm:py-24">
                <div class="absolute -right-20 -top-32 h-80 w-80 rounded-full bg-[#FF7900]/10 blur-3xl"></div>
                <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>

                <div class="relative mx-auto max-w-5xl text-center">
                    <span class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold tracking-wide text-white/80">
                        EXPLORE ZERVO SERVICES
                    </span>

                    <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                        What do you need
                        <span class="text-[#FF9B38]">help with?</span>
                    </h1>

                    <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-white/65 sm:text-lg">
                        From everyday repairs to complete home transformations,
                        discover the right professionals for your needs.
                    </p>

                    <Link
                        href="/requirements"
                        class="mt-8 inline-flex items-center gap-2 rounded-xl bg-[#FF7900] px-6 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[#F36B00]"
                    >
                        Explore all services
                        <ArrowRight :size="17" />
                    </Link>
                </div>
            </section>

            <!-- Categories -->
            <section class="mx-auto max-w-7xl px-5 py-16 sm:px-8 lg:px-12">

                <div class="mb-9 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-widest text-[#FF7900]">
                            Browse by category
                        </p>

                        <h2 class="mt-2 text-2xl font-bold text-[#003D2D] sm:text-3xl">
                            Explore our services
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Choose a category to find the right service professionals.
                        </p>
                    </div>

                    <span class="text-sm font-medium text-gray-400">
                        {{ categories.length }} categories
                    </span>
                </div>

                <div
                    v-if="categories.length"
                    class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <Link
                        v-for="category in categories"
                            :key="category.id"
                            :href="`/requirements?category_id=${category.id}`"
                            class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-[#003D2D]/30 hover:shadow-lg"
                        >
                        <div class="flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#edf5ef] text-[#003D2D] transition group-hover:bg-[#003D2D] group-hover:text-white">
                                <component
                                    :is="getCategoryDetails(category.slug).icon"
                                    :size="23"
                                    :stroke-width="1.8"
                                />
                            </div>

                        </div>

                        <h3 class="mt-5 text-lg font-bold text-gray-900">
                            {{ category.name }}
                        </h3>

                        <p class="mt-2 min-h-12 text-sm leading-6 text-gray-500">
                            {{ getCategoryDetails(category.slug).description }}
                        </p>

                        <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="text-xs font-medium text-gray-400">
                                {{ category.requirements_count }}
                                {{ category.requirements_count === 1 ? 'requirement' : 'requirements' }}
                            </span>

                            <span class="text-xs font-semibold text-[#003D2D] group-hover:text-[#FF7900]">
                                Explore services
                            </span>
                        </div>
                    </Link>
                </div>

                <!-- Empty state -->
                <div
                    v-else
                    class="rounded-2xl border border-dashed border-gray-300 bg-white py-16 text-center"
                >
                    <Search :size="32" class="mx-auto text-gray-400" />

                    <h3 class="mt-4 font-bold text-gray-900">
                        No categories available
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Please check back later for available services.
                    </p>
                </div>
            </section>

            <!-- CTA -->
            <section class="mx-auto max-w-7xl px-5 pb-16 sm:px-8 lg:px-12">
                <div class="flex flex-col items-center justify-between gap-6 rounded-2xl bg-[#003528] p-8 text-center sm:flex-row sm:p-10 sm:text-left">
                    <div>
                        <h2 class="text-2xl font-bold text-white">
                            Can't find what you're looking for?
                        </h2>

                        <p class="mt-2 text-sm text-white/65">
                            Post your requirement and connect with professionals.
                        </p>
                    </div>

                    <Link
                        :href="route('requirements.create')"
                        class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-[#FF7900] px-6 py-3.5 text-sm font-bold text-white transition hover:bg-[#F36B00]"
                    >
                        Post a requirement
                    </Link>
                </div>
            </section>

        </main>
    </AuthenticatedLayout>
</template>
