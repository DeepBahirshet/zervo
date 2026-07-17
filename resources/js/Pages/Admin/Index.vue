<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-6xl py-8">

            <h1 class="text-3xl font-bold mb-8">
                Admin Panel
            </h1>

            <div class="grid gap-6 md:grid-cols-3">

                <Link
                    :href="route('admin.requirements.index')"
                    class="rounded-lg bg-white p-6 shadow hover:shadow-lg transition"
                >
                    <h2 class="text-xl font-semibold">
                        Requirements
                    </h2>

                    <p class="mt-2 text-gray-600">
                        Approve or reject newly submitted requirements.
                    </p>
                </Link>

            </div>

        </div>
    </AuthenticatedLayout>
</template>