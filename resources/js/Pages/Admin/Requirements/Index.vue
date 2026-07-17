<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RequirementService from '@/Services/RequirementService';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { toast } from 'vue-sonner';

const requirements = ref([]);
const status = ref('pending');

const fetchRequirements = async () => {
    const {data} = await RequirementService.index(status.value);
    requirements.value = data.data;
}

const changeStatus = async (value) => {
    status.value = value;
    await fetchRequirements();
};

const approve = async (requirement) => {
    try {
        await RequirementService.approve(requirement.id);

        toast.success('Requirement approved successfully.');

        await fetchRequirements();
    } catch (error) {
        toast.error(
           'Failed to approve requirement.'
        );
    }
};

const reject = async (requirement) => {
    try {
        await RequirementService.reject(requirement.id);

        toast.success('Requirement rejected successfully.');

        await fetchRequirements();
    } catch (error) {
        toast.error(
            'Failed to reject requirement.'
        );
    }
};

onMounted(fetchRequirements);

</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl py-8">

            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold">
                    Pending Requirements
                </h1>

                <Link
                    :href="route('admin.index')"
                    class="rounded-md border px-4 py-2 hover:bg-gray-100"
                >
                    Back
                </Link>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Title
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Owner
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Budget
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Location
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Status
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        <tr
                            v-for="requirement in requirements"
                            :key="requirement.id"
                        >
                            <td class="px-6 py-4">
                                <div class="font-semibold">
                                    {{ requirement.title }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ requirement.description }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                {{ requirement.user.name }}
                            </td>

                            <td class="px-6 py-4">
                                ₹{{ requirement.budget }}
                            </td>

                            <td class="px-6 py-4">
                                {{ requirement.location }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-700"
                                >
                                    {{ requirement.status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <button
                                        @click="approve(requirement)"
                                        class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                                    >
                                        Approve
                                    </button>

                                    <button
                                        @click="reject(requirement)"
                                        class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                                    >
                                        Reject
                                    </button>

                                    <Link
                                       
                                        class="rounded-md border px-4 py-2 hover:bg-gray-100"
                                    >
                                        View
                                    </Link>

                                </div>

                            </td>

                        </tr>

                        <tr v-if="requirements.length === 0">
                            <td
                                colspan="6"
                                class="py-10 text-center text-gray-500"
                            >
                                No pending requirements found.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </AuthenticatedLayout>
</template>