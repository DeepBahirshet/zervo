
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RequirementService from "@/Services/RequirementService";
import { Link } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import { toast } from "vue-sonner";

import {
    ArrowLeft,
    ClipboardList,
    CheckCircle2,
    Clock3,
    XCircle,
    MapPin,
    Wallet,
    Check,
    X,
    Eye,
    LoaderCircle,
    RefreshCw,
} from "lucide-vue-next";

const requirements = ref([]);
const status = ref("pending");
const loading = ref(false);
const processingId = ref(null);

const filters = [
    {
        label: "Pending",
        value: "pending",
        icon: Clock3,
        activeClass: "bg-amber-500 text-white",
    },
    {
        label: "Approved",
        value: "approved",
        icon: CheckCircle2,
        activeClass: "bg-emerald-600 text-white",
    },
    {
        label: "Rejected",
        value: "cancelled",
        icon: XCircle,
        activeClass: "bg-red-600 text-white",
    },
];

const fetchRequirements = async () => {
    loading.value = true;

    try {
        const { data } = await RequirementService.index(status.value);
        requirements.value = data.data || [];
    } catch (error) {
        toast.error("Failed to load requirements.");
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const changeStatus = async (value) => {
    if (status.value === value) return;

    status.value = value;
    await fetchRequirements();
};

const emptyMessage = computed(() => {
    switch (status.value) {
        case "pending":
            return "No pending requirements found.";

        case "approved":
            return "No approved requirements found.";

        case "cancelled":
            return "No rejected requirements found.";

        default:
            return "No requirements found.";
    }
});

const approve = async (requirement) => {
    processingId.value = requirement.id;

    try {
        await RequirementService.approve(requirement.id);

        toast.success("Requirement approved successfully.");
        await fetchRequirements();
    } catch (error) {
        toast.error("Failed to approve requirement.");
        console.error(error);
    } finally {
        processingId.value = null;
    }
};

const reject = async (requirement) => {
    processingId.value = requirement.id;

    try {
        await RequirementService.reject(requirement.id);

        toast.success("Requirement rejected successfully.");
        await fetchRequirements();
    } catch (error) {
        toast.error("Failed to reject requirement.");
        console.error(error);
    } finally {
        processingId.value = null;
    }
};

const statusClasses = (value) => {
    const classes = {
        pending: "bg-amber-50 text-amber-700 ring-amber-600/20",
        approved: "bg-emerald-50 text-emerald-700 ring-emerald-600/20",
        cancelled: "bg-red-50 text-red-700 ring-red-600/20",
    };

    return classes[value] || "bg-gray-100 text-gray-600 ring-gray-500/20";
};

const statusLabel = (value) => {
    return value === "cancelled" ? "Rejected" : value;
};

onMounted(fetchRequirements);
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FFF9F0]">
            <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

                <!-- Page Header -->
                <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#FF7900]">
                            <ClipboardList class="h-4 w-4" />
                            Marketplace Management
                        </div>

                        <h1 class="text-3xl font-bold tracking-tight text-[#003D2D]">
                            Manage Requirements
                        </h1>

                        <p class="mt-2 text-sm text-gray-500">
                            Review and manage service requirements submitted by customers.
                        </p>
                    </div>

                    <Link
                        :href="route('admin.index')"
                        class="inline-flex w-fit items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Back to Dashboard
                    </Link>
                </div>

                <!-- Requirements Section -->
                <div class="overflow-hidden rounded-2xl border border-[#003D2D]/10 bg-white shadow-sm">

                    <!-- Section Header -->
                    <div class="flex flex-col gap-4 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-[#003528]">
                                Submitted Requirements
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Review submissions and take appropriate action.
                            </p>
                        </div>

                        <button
                            @click="fetchRequirements"
                            :disabled="loading"
                            class="inline-flex w-fit items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 disabled:opacity-50"
                        >
                            <RefreshCw
                                :class="['h-4 w-4', loading && 'animate-spin']"
                            />
                            Refresh
                        </button>
                    </div>

                    <!-- Status Filters -->
                    <div class="border-b border-gray-100 px-6 py-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <button
                                v-for="filter in filters"
                                :key="filter.value"
                                @click="changeStatus(filter.value)"
                                :class="[
                                    'inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold transition',
                                    status === filter.value
                                        ? filter.activeClass
                                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                                ]"
                            >
                                <component :is="filter.icon" class="h-4 w-4" />
                                {{ filter.label }}
                            </button>
                        </div>
                    </div>

                    <!-- Requirements Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-[1050px] w-full text-left">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Requirement
                                    </th>

                                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Owner
                                    </th>

                                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Budget
                                    </th>

                                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Location
                                    </th>

                                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">

                                <!-- Loading State -->
                                <tr v-if="loading">
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <LoaderCircle class="h-8 w-8 animate-spin text-[#FF7900]" />

                                            <p class="mt-3 text-sm font-medium text-gray-600">
                                                Loading requirements...
                                            </p>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Requirement Rows -->
                                <template v-else-if="requirements.length > 0">
                                    <tr
                                        v-for="requirement in requirements"
                                        :key="requirement.id"
                                        class="transition hover:bg-[#FFF9F0]/60"
                                    >
                                        <!-- Requirement -->
                                        <td class="px-6 py-5">
                                            <div class="max-w-xs">
                                                <h3 class="font-semibold text-gray-800">
                                                    {{ requirement.title }}
                                                </h3>

                                                <p class="mt-1 line-clamp-2 text-xs leading-5 text-gray-500">
                                                    {{ requirement.description }}
                                                </p>
                                            </div>
                                        </td>

                                        <!-- Owner -->
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-2">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#003D2D]/10 text-sm font-bold text-[#003D2D]">
                                                    {{ requirement.user?.name?.charAt(0)?.toUpperCase() || "U" }}
                                                </div>

                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ requirement.user?.name || "Unknown" }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Budget -->
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-1.5 text-sm font-semibold text-gray-800">
                                                <Wallet class="h-4 w-4 text-gray-400" />
                                                ₹{{ requirement.budget }}
                                            </div>
                                        </td>

                                        <!-- Location -->
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                                <MapPin class="h-4 w-4 shrink-0 text-gray-400" />
                                                {{ requirement.location }}
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-5">
                                            <span
                                                :class="[
                                                    'inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold capitalize ring-1 ring-inset',
                                                    statusClasses(requirement.status),
                                                ]"
                                            >
                                                {{ statusLabel(requirement.status) }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-5">
                                            <div class="flex items-center justify-end gap-2">

                                                <!-- View Details -->
                                                <Link
                                                    :href="route('requirements.show', requirement.id)"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-[#003D2D] hover:bg-[#003D2D]/5 hover:text-[#003D2D]"
                                                >
                                                    <Eye class="h-3.5 w-3.5" />
                                                    View
                                                </Link>

                                                <!-- Approve: Pending Only -->
                                                <button
                                                    v-if="requirement.status === 'pending'"
                                                    @click="approve(requirement)"
                                                    :disabled="processingId === requirement.id"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
                                                >
                                                    <Check class="h-3.5 w-3.5" />
                                                    Approve
                                                </button>

                                                <!-- Reject: Pending and Approved -->
                                                <button
                                                    v-if="['pending', 'approved'].includes(requirement.status)"
                                                    @click="reject(requirement)"
                                                    :disabled="processingId === requirement.id"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-100 disabled:cursor-not-allowed disabled:opacity-50"
                                                >
                                                    <X class="h-3.5 w-3.5" />
                                                    Reject
                                                </button>

                                                <span
                                                    v-if="processingId === requirement.id"
                                                    class="text-xs text-gray-400"
                                                >
                                                    Processing...
                                                </span>

                                            </div>
                                        </td>
                                    </tr>
                                </template>

                                <!-- Empty State -->
                                <tr v-else>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100">
                                                <ClipboardList class="h-7 w-7 text-gray-400" />
                                            </div>

                                            <h3 class="mt-4 font-semibold text-gray-800">
                                                {{ emptyMessage }}
                                            </h3>

                                            <p class="mt-1 text-sm text-gray-500">
                                                Requirements matching this filter will appear here.
                                            </p>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer -->
                    <div class="flex flex-col gap-2 border-t border-gray-100 bg-gray-50/70 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs text-gray-500">
                            Showing
                            <span class="font-semibold text-gray-700">
                                {{ requirements.length }}
                            </span>
                            requirements
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
