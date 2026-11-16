
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, usePage } from "@inertiajs/vue3";
import axios from "axios";
import { computed, onMounted, ref } from "vue";

const loading = ref(false);
const requirements = ref([]);
const error = ref("");
const filter = ref("all");
const search = ref("");
const selectedCategory = ref("All");

const page = usePage();
const user = page.props.auth.user;

const categories = [
    "All",
    "Plumbing",
    "Electrical",
    "Carpentry",
    "Painting",
    "AC & Appliances",
    "Home Cleaning",
    "Pest Control",
    "Home Renovation",
    "Gardening",
    "Moving Services",
];

const filteredRequirements = computed(() => {
    let result = requirements.value;

    if (filter.value === "mine") {
        result = result.filter(
            (requirement) => requirement.user_id === user.id
        );
    }

    if (selectedCategory.value !== "All") {
        result = result.filter(
            (requirement) =>
                requirement.category === selectedCategory.value
        );
    }

    if (search.value.trim()) {
        const query = search.value.toLowerCase().trim();

        result = result.filter((requirement) =>
            [
                requirement.title,
                requirement.description,
                requirement.location,
                requirement.category,
            ].some((value) => value?.toLowerCase().includes(query))
        );
    }

    return result;
});

const fetchRequirements = async () => {
    loading.value = true;
    error.value = "";

    try {
        const { data } = await axios.get("/api/requirements");
        requirements.value = data.data;
    } catch (err) {
        error.value = "Could not load requirements. Please try again.";
    } finally {
        loading.value = false;
    }
};

const formatBudget = (budget) => {
    return new Intl.NumberFormat("en-IN", {
        style: "currency",
        currency: "INR",
        maximumFractionDigits: 0,
    }).format(budget);
};

onMounted(fetchRequirements);
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FFF9F0] px-4 py-8 sm:px-6 lg:py-10">
            <div class="mx-auto max-w-7xl">

                <!-- Header -->
                <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="mb-3 inline-flex rounded-full bg-[#E4EEE7] px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#003D2D]">
                            Local services marketplace
                        </span>

                        <h1 class="text-3xl font-bold tracking-tight text-[#003D2D] sm:text-4xl">
                            Explore Requirements
                        </h1>

                        <p class="mt-2 text-sm leading-6 text-[#64766E] sm:text-base">
                            Discover local service requests and find opportunities
                            that match your expertise.
                        </p>
                    </div>

                    <Link
                        :href="route('requirements.create')"
                        class="inline-flex cursor-pointer items-center justify-center rounded-xl bg-[#FF7900] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#FF7900]/20 transition hover:bg-[#E86E00] hover:shadow-xl"
                    >
                        Post a Requirement
                    </Link>
                </div>

                <!-- Search and filters -->
                <div class="mb-7 rounded-3xl border border-[#E9E5DC] bg-white p-5 shadow-sm sm:p-6">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        <!-- Search -->
                        <div class="w-full lg:max-w-md">
                            <label class="mb-2 block text-sm font-semibold text-[#24483B]">
                                Search requirements
                            </label>

                            <input
                                v-model="search"
                                type="search"
                                placeholder="Search by title, service or location..."
                                class="w-full rounded-xl border border-[#E5E9E3] bg-[#FCFDFB] px-4 py-3 text-sm text-[#24483B] outline-none transition placeholder:text-[#A5ADA7] focus:border-[#FF7900] focus:ring-4 focus:ring-[#FF7900]/10"
                            />
                        </div>

                        <!-- Ownership filter -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#24483B]">
                                Show requirements
                            </label>

                            <div class="flex rounded-xl bg-[#F3F5F0] p-1">
                                <button
                                    type="button"
                                    @click="filter = 'all'"
                                    :class="[
                                        'cursor-pointer rounded-lg px-4 py-2.5 text-sm font-semibold transition',
                                        filter === 'all'
                                            ? 'bg-[#003D2D] text-white shadow-sm'
                                            : 'text-[#64766E] hover:text-[#003D2D]',
                                    ]"
                                >
                                    All
                                </button>

                                <button
                                    type="button"
                                    @click="filter = 'mine'"
                                    :class="[
                                        'cursor-pointer rounded-lg px-4 py-2.5 text-sm font-semibold transition',
                                        filter === 'mine'
                                            ? 'bg-[#003D2D] text-white shadow-sm'
                                            : 'text-[#64766E] hover:text-[#003D2D]',
                                    ]"
                                >
                                    My Requirements
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Category filters -->
                    <div class="mt-6 border-t border-[#F0EEE8] pt-5">
                        <p class="mb-3 text-sm font-semibold text-[#24483B]">
                            Browse by category
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="category in categories"
                                :key="category"
                                type="button"
                                @click="selectedCategory = category"
                                :class="[
                                    'cursor-pointer rounded-full border px-4 py-2 text-xs font-semibold transition',
                                    selectedCategory === category
                                        ? 'border-[#003D2D] bg-[#003D2D] text-white'
                                        : 'border-[#E5E9E3] bg-white text-[#64766E] hover:border-[#003D2D] hover:text-[#003D2D]',
                                ]"
                            >
                                {{ category }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Results heading -->
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-[#003D2D]">
                            {{ filter === 'mine' ? 'My Requirements' : 'Available Requirements' }}
                        </h2>

                        <p class="mt-1 text-sm text-[#89958D]">
                            {{ filteredRequirements.length }}
                            {{ filteredRequirements.length === 1 ? 'requirement' : 'requirements' }} found
                        </p>
                    </div>

                    <button
                        v-if="search || selectedCategory !== 'All' || filter !== 'all'"
                        type="button"
                        @click="search = ''; selectedCategory = 'All'; filter = 'all'"
                        class="cursor-pointer text-sm font-semibold text-[#D96B00] hover:text-[#003D2D]"
                    >
                        Clear filters
                    </button>
                </div>

                <!-- Loading -->
                <div
                    v-if="loading"
                    class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="n in 6"
                        :key="n"
                        class="animate-pulse overflow-hidden rounded-3xl border border-[#E9E5DC] bg-white"
                    >
                        <div class="h-52 bg-[#EAEDE7]"></div>
                        <div class="space-y-3 p-5">
                            <div class="h-4 w-1/3 rounded bg-[#EAEDE7]"></div>
                            <div class="h-5 w-3/4 rounded bg-[#EAEDE7]"></div>
                            <div class="h-4 w-full rounded bg-[#EAEDE7]"></div>
                            <div class="h-4 w-2/3 rounded bg-[#EAEDE7]"></div>
                        </div>
                    </div>
                </div>

                <!-- Error -->
                <div
                    v-else-if="error"
                    class="rounded-3xl border border-red-100 bg-white px-6 py-12 text-center"
                >
                    <p class="font-semibold text-red-600">{{ error }}</p>

                    <button
                        type="button"
                        @click="fetchRequirements"
                        class="mt-4 cursor-pointer rounded-xl bg-[#003D2D] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#00523D]"
                    >
                        Try Again
                    </button>
                </div>

                <!-- Empty state -->
                <div
                    v-else-if="filteredRequirements.length === 0"
                    class="rounded-3xl border border-[#E9E5DC] bg-white px-6 py-16 text-center"
                >
                    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E7F0E8] text-3xl">
                        🏠
                    </div>

                    <h3 class="text-xl font-bold text-[#003D2D]">
                        No requirements found
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#89958D]">
                        Try changing your search or category filters.
                        You can also post a new requirement.
                    </p>

                    <Link
                        :href="route('requirements.create')"
                        class="mt-6 inline-flex cursor-pointer rounded-xl bg-[#FF7900] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#E86E00]"
                    >
                        Post a Requirement
                    </Link>
                </div>

                <!-- Requirement cards -->
                <div
                    v-else
                    class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="requirement in filteredRequirements"
                        :key="requirement.id"
                        class="group flex flex-col overflow-hidden rounded-3xl border border-[#E9E5DC] bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#D5DFD4] hover:shadow-xl"
                    >
                        <!-- Image -->
                        <div class="relative h-52 overflow-hidden bg-[#F0F2EC]">
                            <img
                                v-if="requirement.images?.length"
                                :src="`/storage/${requirement.images[0].image}`"
                                :alt="requirement.title"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            />

                            <div
                                v-else
                                class="flex h-full items-center justify-center text-5xl text-[#B5C1B6]"
                            >
                                🏠
                            </div>

                            <div class="absolute left-4 top-4">
                                <span class="rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-[#003D2D] shadow-sm">
                                    {{ requirement.category || 'Service' }}
                                </span>
                            </div>

                            <div
                                v-if="requirement.user_id === user.id"
                                class="absolute right-4 top-4"
                            >
                                <span class="rounded-full bg-[#E4EEE7] px-3 py-1.5 text-xs font-bold text-[#003D2D] shadow-sm">
                                    Posted by You
                                </span>
                            </div>
                        </div>

                        <!-- Card content -->
                        <div class="flex flex-1 flex-col p-5">

                            <h3 class="text-lg font-bold leading-6 text-[#003D2D] transition group-hover:text-[#D96B00]">
                                {{ requirement.title }}
                            </h3>

                            <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-[#748279]">
                                {{ requirement.description }}
                            </p>

                            <!-- Location and budget -->
                            <div class="mt-5 space-y-3 border-t border-[#F0EEE8] pt-4">

                                <div class="flex items-center gap-2 text-sm text-[#64766E]">
                                    <span>📍</span>
                                    <span class="truncate">
                                        {{ requirement.location }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-medium uppercase tracking-wide text-[#9AA59D]">
                                        Estimated budget
                                    </span>

                                    <span class="text-lg font-bold text-[#003D2D]">
                                        {{ formatBudget(requirement.budget) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Details button -->
                            <Link
                                :href="route('requirements.show', requirement.id)"
                                class="mt-5 flex w-full cursor-pointer items-center justify-center rounded-xl bg-[#003D2D] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#00523D]"
                            >
                                View Details
                            </Link>
                        </div>
                    </article>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
