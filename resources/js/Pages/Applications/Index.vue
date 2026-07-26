<script setup>
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ApplicationService from '@/Services/ApplicationService';

const applications = ref([]);

const fetchApplications = async () => {
    const { data } = await ApplicationService.index();

    applications.value = data.data;
};

onMounted(fetchApplications);
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl py-8">

            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold">
                    My Applications
                </h1>

                <Link
                    :href="route('requirements.index')"
                    class="rounded-md border px-4 py-2 hover:bg-gray-100"
                >
                    Browse Requirements
                </Link>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Requirement
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Owner
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Budget
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Applied On
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Status
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase">
                                Action
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        <tr
                            v-for="application in applications"
                            :key="application.id"
                        >

                            <td class="px-6 py-4">

                                <div class="font-semibold">
                                    {{ application.requirement.title }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ application.requirement.location }}
                                </div>

                            </td>

                            <td class="px-6 py-4">
                                {{ application.requirement.user.name }}
                            </td>

                            <td class="px-6 py-4">
                                ₹{{ application.requirement.budget }}
                            </td>

                            <td class="px-6 py-4">
                                {{
                                    new Date(application.created_at)
                                        .toLocaleDateString()
                                }}
                            </td>

                            <td class="px-6 py-4">

                                <span
                                    v-if="application.status === 'pending'"
                                    class="rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-700"
                                >
                                    Pending
                                </span>

                                <span
                                    v-else-if="application.status === 'accepted'"
                                    class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700"
                                >
                                    Accepted
                                </span>

                                <span
                                    v-else-if="application.status === 'rejected'"
                                    class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700"
                                >
                                    Rejected
                                </span>

                            </td>

                            <td class="px-6 py-4 text-right">

                                <Link
                                    :href="route('requirements.show', application.requirement.id)"
                                    class="rounded-md border px-4 py-2 hover:bg-gray-100"
                                >
                                    View Requirement
                                </Link>

                            </td>

                        </tr>

                        <tr v-if="applications.length === 0">
                            <td
                                colspan="6"
                                class="py-10 text-center text-gray-500"
                            >
                                You haven't applied to any requirements yet.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </AuthenticatedLayout>
</template>