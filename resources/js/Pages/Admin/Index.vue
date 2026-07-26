<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl py-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold">Admin Dashboard</h1>
                <p class="mt-2 text-gray-500">
                    Manage marketplace resources and moderate requirements.
                </p>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                Module
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                Description
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-5 font-medium">
                                Requirements
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                Review, approve or reject submitted requirements.
                            </td>

                            <td class="px-6 py-5 text-center">
                                <Link
                                    :href="route('admin.requirements.index')"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                                >
                                    Manage
                                </Link>
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

        </div>
    </AuthenticatedLayout>
</template>