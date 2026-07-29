<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, usePage } from "@inertiajs/vue3";
import axios from "axios";
import { computed, onMounted, ref } from "vue";

const loading = ref(false);
const requirements = ref([]);
const error = ref("");
const filter = ref("all");
const page = usePage();
const user = page.props.auth.user;

const filteredRequirements = computed(() => {
    if (filter.value == "mine") {
        return requirements.value.filter(
            (requirement) => requirement.user_id === user.id,
        );
    }

    return requirements.value;
});

const fetchRequirements = async () => {
    loading.value = true;

    try {
        const { data } = await axios.get("api/requirements");

        requirements.value = data.data;
        console.log(requirements.value);
    } catch (err) {
        error.value = "Could not load requirements. Please try again.";
    } finally {
        loading.value = false;
    }
};

onMounted(fetchRequirements);
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl py-6">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-3xl font-bold">Requirements</h1>

                <Link :href="route('requirements.create')"
                    class="rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-600">
                    Post Requirement
                </Link>
            </div>

            <div class="flex gap-2 mb-4">
                <button @click="filter = 'all'" :class="[
                    'rounded-md px-4 py-2',
                    filter === 'all'
                        ? 'bg-amber-500 text-white'
                        : 'bg-gray-200',
                ]">
                    All Requirements
                </button>

                <button @click="filter = 'mine'" :class="[
                    'rounded-md px-4 py-2',
                    filter === 'mine'
                        ? 'bg-amber-500 text-white'
                        : 'bg-gray-200',
                ]">
                    My Requirements
                </button>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="requirement in filteredRequirements" :key="requirement.id"
                    class="flex flex-col rounded-lg border bg-white p-5 shadow-sm">
                    <div class="flex-1">
                        <div class="mb-4">
                            <img v-if="requirement.images.length" :src="`/storage/${requirement.images[0].image}`"
                                class="h-48 w-full rounded-lg object-cover" />

                            <div v-else
                                class="flex h-48 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                No Image
                            </div>
                        </div>
                        <h2 class="mb-2 text-xl font-semibold">
                            {{ requirement.title }}
                        </h2>

                        <span v-if="requirement.user_id === user.id"
                            class="inline-block mb-4 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                            Posted by You
                        </span>

                        <p class="mb-4 text-gray-600">
                            {{ requirement.description }}
                        </p>

                        <div class="flex justify-between text-sm text-gray-500">
                            <span>{{ requirement.location }}</span>
                            <span class="font-semibold text-amber-600">
                                {{ requirement.budget }}
                            </span>
                        </div>
                    </div>

                    <Link :href="route('requirements.show', requirement.id)"
                        class="mt-5 block w-full rounded-md bg-amber-500 py-2 text-center text-white hover:bg-amber-600">
                        View Details
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
