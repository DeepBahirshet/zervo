
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ApplicationService from "@/Services/ApplicationService";
import ReviewModal from "@/Components/Review/ReviewModal.vue";

import { computed, ref } from "vue";
import { toast } from "vue-sonner";
import axios from "axios";

import {
    MapPin,
    CalendarDays,
    Wallet,
    Users,
    Sparkles,
    Clock3,
    Check,
    X,
    Star,
    Image as ImageIcon,
    LoaderCircle,
    CheckCircle2,
    CircleAlert,
    BriefcaseBusiness,
    UserRound,
    Mail,
    Phone,
    ClipboardList,
    ArrowUpRight,
} from "lucide-vue-next";

const props = defineProps({
    requirement: {
        type: Object,
        required: true,
    },
});

// Local reactive state
const requirementData = ref({
    ...props.requirement,
    applications: [...(props.requirement.applications ?? [])],
});

const aiLoading = ref(false);
const aiAnalysis = ref(null);
const aiError = ref("");

const showReviewModal = ref(false);
const processingApplications = ref([]);

// Ranked AI candidates
const rankedCandidates = computed(() => {
    return [...(aiAnalysis.value?.candidates ?? [])].sort(
        (a, b) =>
            (b.scores?.overall ?? 0) -
            (a.scores?.overall ?? 0)
    );
});

// Helpers
const formatDate = (date) => {
    if (!date) return "N/A";

    return new Date(date).toLocaleDateString("en-IN", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat("en-IN", {
        maximumFractionDigits: 0,
    }).format(amount ?? 0);
};

const getWorkStatus = (status) => {
    const statuses = {
        open: "Open",
        in_progress: "In Progress",
        completed: "Completed",
        cancelled: "Cancelled",
    };

    return statuses[status] ?? "Open";
};

const getStatusClass = (status) => {
    const classes = {
        pending: "bg-amber-50 text-amber-700",
        accepted: "bg-green-50 text-green-700",
        rejected: "bg-red-50 text-red-600",
    };

    return classes[status] ?? "bg-gray-100 text-gray-600";
};

const getWorkStatusClass = (status) => {
    const classes = {
        open: "bg-blue-50 text-blue-700",
        in_progress: "bg-amber-50 text-amber-700",
        completed: "bg-green-50 text-green-700",
        cancelled: "bg-red-50 text-red-700",
    };

    return classes[status] ?? "bg-gray-100 text-gray-600";
};

// AI application analysis
const analyzeApplications = async () => {
    if (!requirementData.value.applications.length) return;

    aiLoading.value = true;
    aiError.value = "";

    try {
        const { data } = await axios.post(
            `/api/requirements/${requirementData.value.id}/ai-analysis`
        );

        aiAnalysis.value = data.data;

        toast.success("Application analysis completed.");
    } catch (error) {
        console.error(error);

        aiError.value =
            error.response?.data?.message ||
            "Unable to analyze applications. Please try again.";

        toast.error(aiError.value);
    } finally {
        aiLoading.value = false;
    }
};

// Application actions
const accept = async (application) => {
    if (processingApplications.value.includes(application.id)) return;

    processingApplications.value.push(application.id);

    try {
        await ApplicationService.accept(application.id);

        requirementData.value.applications.forEach((item) => {
            if (item.id === application.id) {
                item.status = "accepted";
            } else if (item.status === "pending") {
                item.status = "rejected";
            }
        });

        requirementData.value.work_status = "in_progress";

        toast.success("Provider accepted successfully.");
    } catch (error) {
        console.error(error);
        toast.error("Failed to accept application.");
    } finally {
        processingApplications.value =
            processingApplications.value.filter(
                (id) => id !== application.id
            );
    }
};

const reject = async (application) => {
    if (processingApplications.value.includes(application.id)) return;

    processingApplications.value.push(application.id);

    try {
        await ApplicationService.reject(application.id);

        application.status = "rejected";

        toast.success("Application rejected.");
    } catch (error) {
        console.error(error);
        toast.error("Failed to reject application.");
    } finally {
        processingApplications.value =
            processingApplications.value.filter(
                (id) => id !== application.id
            );
    }
};

// Review workflow
const markCompleted = () => {
    showReviewModal.value = true;
};

const reviewSubmitted = () => {
    requirementData.value.work_status = "completed";
    requirementData.value.review = true;
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#f7f8f6]">
            <div class="mx-auto max-w-7xl space-y-7 px-4 py-7 sm:px-6 lg:px-8">

                <!-- Page heading -->
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-[#FF7900]">
                        My requirements
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-[#003D2D] sm:text-3xl">
                        Manage your project
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage applications, compare providers and track your project.
                    </p>
                </div>

                <!-- Requirement overview -->
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-start">

                        <!-- Requirement image -->
                        <div class="h-28 w-full shrink-0 overflow-hidden rounded-xl bg-gray-100 sm:h-28 sm:w-36">
                            <img
                                :src="
                                    requirementData.images?.length
                                        ? `/storage/${requirementData.images[0].image}`
                                        : '/images/zervo-placeholder.png'
                                "
                                :alt="requirementData.title"
                                class="h-full w-full object-cover"
                            />
                        </div>

                        <!-- Requirement details -->
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold"
                                    :class="getWorkStatusClass(requirementData.work_status)"
                                >
                                    {{ getWorkStatus(requirementData.work_status) }}
                                </span>

                                <span
                                    class="inline-flex items-center rounded-full border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium capitalize text-gray-500"
                                >
                                    {{ requirementData.status }}
                                </span>
                            </div>

                            <h2 class="mt-3 text-xl font-bold text-gray-900">
                                {{ requirementData.title }}
                            </h2>

                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                                {{ requirementData.description }}
                            </p>

                            <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2 text-sm text-gray-500">

                                <span class="flex items-center gap-1.5">
                                    <MapPin :size="15" />
                                    {{ requirementData.location }}
                                </span>

                                <span class="flex items-center gap-1.5">
                                    <CalendarDays :size="15" />
                                    {{ formatDate(requirementData.created_at) }}
                                </span>

                                <span class="flex items-center gap-1.5">
                                    <Users :size="15" />
                                    {{ requirementData.applications.length }} applications
                                </span>

                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="shrink-0 rounded-xl bg-[#f2f7f4] px-4 py-3 sm:min-w-36">
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <Wallet :size="14" />
                                Your budget
                            </div>

                            <p class="mt-1 text-xl font-bold text-[#003D2D]">
                                ₹{{ formatCurrency(requirementData.budget) }}
                            </p>
                        </div>
                    </div>

                    <!-- Additional images -->
                    <div
                        v-if="requirementData.images?.length > 1"
                        class="flex gap-2 overflow-x-auto border-t border-gray-100 px-5 py-3"
                    >
                        <img
                            v-for="image in requirementData.images.slice(1)"
                            :key="image.id"
                            :src="`/storage/${image.image}`"
                            :alt="requirementData.title"
                            class="h-14 w-16 shrink-0 rounded-lg object-cover"
                        />
                    </div>
                </section>

                <!-- AI Analysis -->
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center">

                        <div class="flex items-start gap-3">
                            <div class="rounded-xl bg-purple-50 p-3 text-purple-600">
                                <Sparkles :size="22" />
                            </div>

                            <div>
                                <h2 class="font-bold text-gray-900">
                                    AI Provider Analysis
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Compare applicants and find the best match for your project.
                                </p>
                            </div>
                        </div>

                        <button
                            @click="analyzeApplications"
                            :disabled="aiLoading || !requirementData.applications.length"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#003D2D] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#00513c] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <LoaderCircle
                                v-if="aiLoading"
                                :size="17"
                                class="animate-spin"
                            />

                            <Sparkles v-else :size="17" />

                            {{ aiLoading ? "Analyzing..." : aiAnalysis ? "Refresh analysis" : "Analyze applicants" }}
                        </button>
                    </div>

                    <!-- AI error -->
                    <div
                        v-if="aiError"
                        class="mx-5 mb-5 flex items-center gap-2 rounded-lg bg-red-50 p-3 text-sm text-red-600"
                    >
                        <CircleAlert :size="17" />
                        {{ aiError }}
                    </div>

                    <!-- AI results -->
                    <div
                        v-if="aiAnalysis"
                        class="space-y-6 border-t border-gray-100 p-5"
                    >

                        <!-- Summary -->
                        <div class="rounded-xl border border-purple-100 bg-purple-50/50 p-5">
                            <div class="flex items-center gap-2 text-purple-700">
                                <Sparkles :size="16" />
                                <h3 class="text-sm font-bold">
                                    AI Summary
                                </h3>
                            </div>

                            <p class="mt-3 text-sm leading-7 text-gray-700">
                                {{ aiAnalysis.summary }}
                            </p>
                        </div>

                        <!-- Comparison -->
                        <div>
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <h3 class="font-bold text-gray-900">
                                        Candidate comparison
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Ranked by overall evaluation score
                                    </p>
                                </div>

                                <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                                    {{ rankedCandidates.length }} candidates
                                </span>
                            </div>

                            <div
                                v-if="rankedCandidates.length"
                                class="overflow-x-auto rounded-xl border border-gray-100"
                            >
                                <table class="w-full min-w-[850px] text-left text-sm">

                                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                                        <tr>
                                            <th class="px-5 py-4">Rank</th>
                                            <th class="px-5 py-4">Candidate</th>
                                            <th class="px-5 py-4">Overall</th>
                                            <th class="px-5 py-4">Success</th>
                                            <th class="px-5 py-4">Skills</th>
                                            <th class="px-5 py-4">Experience</th>
                                            <th class="px-5 py-4">Affordability</th>
                                            <th class="px-5 py-4">Communication</th>
                                            <th class="px-5 py-4">Availability</th>
                                            <th class="px-5 py-4">Recommendation</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-100">
                                        <tr
                                            v-for="(candidate, index) in rankedCandidates"
                                            :key="candidate.id"
                                            class="transition hover:bg-gray-50"
                                        >
                                            <td class="px-5 py-4">
                                                <span
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg font-bold"
                                                    :class="index === 0
                                                        ? 'bg-amber-100 text-amber-700'
                                                        : 'bg-gray-100 text-gray-600'"
                                                >
                                                    #{{ index + 1 }}
                                                </span>
                                            </td>

                                            <td class="px-5 py-4 font-semibold text-gray-800">
                                                Candidate #{{ candidate.id }}
                                            </td>

                                            <td class="px-5 py-4 font-bold text-[#003D2D]">
                                                {{ candidate.scores?.overall ?? 0 }}%
                                            </td>

                                            <td class="px-5 py-4">
                                                {{ candidate.scores?.success_rate ?? 0 }}%
                                            </td>

                                            <td class="px-5 py-4">
                                                {{ candidate.scores?.skill_match ?? 0 }}%
                                            </td>

                                            <td class="px-5 py-4">
                                                {{ candidate.scores?.experience ?? 0 }}%
                                            </td>

                                            <td class="px-5 py-4">
                                                {{ candidate.scores?.affordability ?? 0 }}%
                                            </td>

                                            <td class="px-5 py-4">
                                                {{ candidate.scores?.communication ?? 0 }}%
                                            </td>

                                            <td class="px-5 py-4">
                                                {{ candidate.scores?.availability ?? 0 }}%
                                            </td>

                                            <td class="px-5 py-4">
                                                <span class="inline-flex rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                                                    {{ candidate.recommendation }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div
                                v-else
                                class="rounded-xl border border-dashed p-8 text-center text-sm text-gray-500"
                            >
                                No candidate analysis available.
                            </div>
                        </div>
                    </div>

                    <!-- Empty AI state -->
                    <div
                        v-else-if="!aiLoading"
                        class="border-t border-gray-100 px-5 py-6 text-center"
                    >
                        <p class="text-sm text-gray-400">
                            Run AI analysis to compare your applicants.
                        </p>
                    </div>
                </section>

                <!-- Applications -->
                <section>
                    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-xl font-bold text-[#003D2D]">
                                Applications
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Review providers and manage their applications.
                            </p>
                        </div>

                        <span class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-600 shadow-sm">
                            {{ requirementData.applications.length }} total
                        </span>
                    </div>

                    <!-- Empty state -->
                    <div
                        v-if="!requirementData.applications.length"
                        class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center"
                    >
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-green-50 text-[#003D2D]">
                            <BriefcaseBusiness :size="25" />
                        </div>

                        <h3 class="mt-4 font-bold text-gray-900">
                            No applications yet
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Providers will appear here when they apply to your requirement.
                        </p>
                    </div>

                    <!-- Application cards -->
                    <div v-else class="space-y-4">
                        <article
                            v-for="application in requirementData.applications"
                            :key="application.id"
                            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md"
                        >
                            <div class="p-5 sm:p-6">

                                <!-- Provider heading -->
                                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">

                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#eaf2ed] text-lg font-bold text-[#003D2D]">
                                            {{ application.user.name?.charAt(0)?.toUpperCase() }}
                                        </div>

                                        <div class="min-w-0">
                                            <h3 class="font-bold text-gray-900">
                                                {{ application.user.name }}
                                            </h3>

                                            <p class="mt-1 flex items-center gap-1.5 truncate text-sm text-gray-500">
                                                <Mail :size="13" />
                                                {{ application.user.email }}
                                            </p>
                                        </div>
                                    </div>

                                    <span
                                        class="w-fit rounded-full px-3 py-1.5 text-xs font-semibold capitalize"
                                        :class="getStatusClass(application.status)"
                                    >
                                        {{ application.status }}
                                    </span>
                                </div>

                                <!-- Application information -->
                                <div class="mt-6 grid grid-cols-2 gap-4 rounded-xl bg-gray-50 p-4 sm:grid-cols-3">

                                    <div>
                                        <p class="flex items-center gap-1.5 text-xs text-gray-400">
                                            <Wallet :size="13" />
                                            Quoted price
                                        </p>

                                        <p class="mt-1 font-bold text-gray-900">
                                            ₹{{ formatCurrency(application.quoted_price) }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="flex items-center gap-1.5 text-xs text-gray-400">
                                            <Clock3 :size="13" />
                                            Estimated time
                                        </p>

                                        <p class="mt-1 font-bold text-gray-900">
                                            {{ application.estimated_days }} days
                                        </p>
                                    </div>

                                    <div
                                        v-if="application.user.phone"
                                        class="col-span-2 sm:col-span-1"
                                    >
                                        <p class="flex items-center gap-1.5 text-xs text-gray-400">
                                            <Phone :size="13" />
                                            Phone number
                                        </p>

                                        <p class="mt-1 font-bold text-gray-900">
                                            {{ application.user.phone }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Cover message -->
                                <div class="mt-5">
                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                        Cover message
                                    </p>

                                    <p class="mt-2 text-sm leading-6 text-gray-600">
                                        {{ application.message || "No message provided." }}
                                    </p>
                                </div>

                                <!-- Accepted provider information -->
                                <div
                                    v-if="application.status === 'accepted'"
                                    class="mt-5 rounded-xl border border-green-100 bg-green-50 p-4"
                                >
                                    <div class="flex items-center gap-2 text-green-700">
                                        <CheckCircle2 :size="17" />
                                        <h4 class="font-semibold">
                                            Provider selected
                                        </h4>
                                    </div>

                                    <p class="mt-2 text-sm text-green-700">
                                        You can contact {{ application.user.name }}
                                        to coordinate the project.
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-100 pt-4">

                                    <template v-if="application.status === 'pending'">
                                        <button
                                            @click="accept(application)"
                                            :disabled="processingApplications.includes(application.id)"
                                            class="inline-flex items-center gap-2 rounded-lg bg-[#003D2D] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#00513c] disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            <LoaderCircle
                                                v-if="processingApplications.includes(application.id)"
                                                :size="16"
                                                class="animate-spin"
                                            />

                                            <Check v-else :size="16" />

                                            {{
                                                processingApplications.includes(application.id)
                                                    ? "Processing..."
                                                    : "Accept"
                                            }}
                                        </button>

                                        <button
                                            @click="reject(application)"
                                            :disabled="processingApplications.includes(application.id)"
                                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            <X :size="16" />
                                            Reject
                                        </button>
                                    </template>

                                    <template v-if="application.status === 'accepted'">
                                        <button
                                            v-if="requirementData.work_status === 'in_progress'"
                                            @click="markCompleted"
                                            class="inline-flex items-center gap-2 rounded-lg bg-[#FF7900] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600"
                                        >
                                            <CheckCircle2 :size="16" />
                                            Mark completed
                                        </button>

                                        <span
                                            v-else-if="requirementData.work_status === 'completed'"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-green-700"
                                        >
                                            <CheckCircle2 :size="17" />
                                            Project completed
                                        </span>

                                        <span
                                            v-if="requirementData.review"
                                            class="inline-flex items-center gap-2 text-sm font-medium text-amber-600"
                                        >
                                            <Star :size="16" />
                                            Review submitted
                                        </span>
                                    </template>

                                    <span
                                        v-if="application.status === 'rejected'"
                                        class="inline-flex items-center gap-2 text-sm text-gray-500"
                                    >
                                        <CircleAlert :size="16" />
                                        Application rejected
                                    </span>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>

                <!-- Review modal -->
                <ReviewModal
                    :show="showReviewModal"
                    :requirement-id="requirementData.id"
                    @close="showReviewModal = false"
                    @submitted="reviewSubmitted"
                />

            </div>
        </div>
    </AuthenticatedLayout>
</template>
