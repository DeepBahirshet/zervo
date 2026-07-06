<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    requirement: Object
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-4xl rounded-lg bg-white p-6 shadow">
            <h1 class="text-3xl font-bold">
                {{ requirement.title }}
            </h1>

            <p class="mt-4 text-gray-700">
                {{ requirement.description }}
            </p>

            <div class="mt-6 space-y-2">
                <p><strong>Budget:</strong> ₹{{ requirement.budget }}</p>
                <p><strong>Location:</strong> {{ requirement.location }}</p>
                <p><strong>Status:</strong> {{ requirement.status }}</p>
            </div>

            <button
                class="mt-8 rounded-md bg-amber-500 px-6 py-3 text-white hover:bg-amber-600"
            >
                Apply
            </button>
        </div>
    </AuthenticatedLayout>
</template>