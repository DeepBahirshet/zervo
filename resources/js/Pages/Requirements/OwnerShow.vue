<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ApplicationService from "@/Services/ApplicationService";
import RequirementService from "@/Services/RequirementService";
import { toast } from "vue-sonner";
import ReviewModal from "@/Components/Review/ReviewModal.vue";
import { computed, ref } from "vue";
import axios from "axios";

const aiLoading = ref(false);
const aiAnalysis = ref(null);
const aiError = ref("");


const props = defineProps({
    requirement: Object,
});

const analyzeApplications = async () => {
    aiLoading.value = true;
    aiError.value = "";

    try {
        const { data } = await axios.post(
            `/api/requirements/${props.requirement.id}/ai-analysis`,
        );

        aiAnalysis.value = data.data;
    } catch (error) {
        console.error(error);

        aiError.value =
            error.response?.data?.message || "Unable to analyze applications.";
    } finally {
        aiLoading.value = false;
    }
};

const rankedCandidates = computed(() => {
    if (!aiAnalysis.value?.candidates) {
        return [];
    }

    return [...aiAnalysis.value.candidates]
        .sort(
            (a, b) =>
                b.scores.overall -
                a.scores.overall,
        );
});

const showReviewModal = ref(false);

const accept = async (application) => {
    try {
        await ApplicationService.accept(application.id);

        application.status = "accepted";

        props.requirement.work_status = "in_progress";

        props.requirement.applications.forEach((item) => {
            if (item.id !== application.id && item.status === "pending") {
                item.status = "rejected";
            }
        });

        toast.success("Application accepted successfully.");
    } catch (error) {
        toast.error("Failed to accept application.");
    }
};

const reject = async (application) => {
    try {
        await ApplicationService.reject(application.id);

        application.status = "rejected";

        toast.success("Application rejected successfully.");
    } catch (error) {
        toast.error("Failed to reject application.");
    }
};

const markCompleted = async () => {
    try {
        showReviewModal.value = true;
    } catch (error) {
        toast.error("Failed to give rating.");
    }
};

const workStatus = (status) => {
    switch (status) {
        case "open":
            return "Open";

        case "in_progress":
            return "In Progress";

        case "completed":
            return "Completed";

        case "cancelled":
            return "Cancelled";

        default:
            return "Open";
    }
};

const reviewSubmitted = () => {
    props.requirement.work_status = "completed";
    props.requirement.review = true;
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-5xl space-y-8">
            <!-- Requirement -->

            <div class="rounded-lg bg-white p-6 shadow">
                <h1 class="text-3xl font-bold">
                    {{ requirement.title }}
                </h1>

                <div
                    v-if="requirement.images && requirement.images.length"
                    class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-3"
                >
                    <img
                        v-for="image in requirement.images"
                        :key="image.id"
                        :src="`/storage/${image.image}`"
                        :alt="requirement.title"
                        class="h-48 w-full rounded-lg border object-cover transition hover:scale-105"
                    />
                </div>

                <p class="mt-4 text-gray-700">
                    {{ requirement.description }}
                </p>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <p>
                        <strong>Budget:</strong>
                        ₹{{ requirement.budget }}
                    </p>

                    <p>
                        <strong>Location:</strong>
                        {{ requirement.location }}
                    </p>

                    <p>
                        <strong>Admin Status:</strong>
                        {{ requirement.status }}
                    </p>

                    <p>
                        <strong>Work Status:</strong>
                        {{ workStatus(requirement.work_status) }}
                    </p>

                    <p>
                        <strong>Created:</strong>

                        {{
                            new Date(requirement.created_at).toLocaleDateString(
                                "en-IN",
                            )
                        }}
                    </p>
                </div>
            </div>

            <div class="mt-8 border-t pt-6">
                <button
                    @click="analyzeApplications"
                    :disabled="aiLoading"
                    class="rounded-md bg-purple-600 px-6 py-3 text-white hover:bg-purple-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span v-if="aiLoading"> Analyzing Applications... </span>

                    <span v-else> ✨ Analyze Applications with AI </span>
                </button>

                <p v-if="aiError" class="mt-3 text-sm text-red-600">
                    {{ aiError }}
                </p>
            </div>

            <div
    v-if="aiAnalysis"
    class="mt-6 rounded-lg border bg-gray-50 p-6"
>
    <div class="mb-6">
        <h2 class="text-2xl font-bold">
            ✨ AI Application Analysis
        </h2>

        <p class="mt-3 text-gray-600">
            {{ aiAnalysis.summary }}
        </p>
    </div>

    <!-- Candidate Table -->

    <div class="overflow-x-auto rounded-lg border bg-white">
        <table class="w-full min-w-[1000px] text-sm">
            <thead class="bg-gray-50">
                <tr class="border-b text-left">
                    <th class="px-4 py-3">
                        Rank
                    </th>

                    <th class="px-4 py-3">
                        Candidate
                    </th>

                    <th class="px-4 py-3">
                        Overall
                    </th>

                    <th class="px-4 py-3">
                        Success
                    </th>

                    <th class="px-4 py-3">
                        Skills
                    </th>

                    <th class="px-4 py-3">
                        Experience
                    </th>

                    <th class="px-4 py-3">
                        Affordability
                    </th>

                    <th class="px-4 py-3">
                        Communication
                    </th>

                    <th class="px-4 py-3">
                        Availability
                    </th>

                    <th class="px-4 py-3">
                        Recommendation
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="(candidate, index) in rankedCandidates"
                    :key="candidate.id"
                    class="border-b last:border-0"
                >
                    <!-- Rank -->

                    <td class="px-4 py-4">
                        <span
                            class="font-bold"
                        >
                            #{{ index + 1 }}
                        </span>
                    </td>

                    <!-- Candidate -->

                    <td class="px-4 py-4">
                        <div class="font-semibold">
                            Candidate #{{ candidate.id }}
                        </div>
                    </td>

                    <!-- Overall -->

                    <td class="px-4 py-4">
                        <span class="font-bold">
    {{ candidate.scores.overall }}%
</span>
                    </td>

                    <!-- Success -->

                    <td class="px-4 py-4">
                        {{ candidate.scores.success_rate }}%
                    </td>

                    <!-- Skills -->

                    <td class="px-4 py-4">
                        {{ candidate.scores.skill_match }}%
                    </td>

                    <!-- Experience -->

                    <td class="px-4 py-4">
                        {{ candidate.scores.experience }}%
                    </td>

                    <!-- Affordability -->

                    <td class="px-4 py-4">
                        {{ candidate.scores.affordability }}%
                    </td>

                    <!-- Communication -->

                    <td class="px-4 py-4">
                        {{ candidate.scores.communication }}%
                    </td>

                    <!-- Availability -->

                    <td class="px-4 py-4">
                        {{ candidate.scores.availability }}%
                    </td>

                    <!-- Recommendation -->

                    <td class="px-4 py-4">
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium"
                        >
                            {{ candidate.recommendation }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

            <!-- Applications -->

            <div class="rounded-lg bg-white p-6 shadow">
                <h2 class="mb-6 text-2xl font-semibold">Applications</h2>

                <div v-if="requirement.applications.length" class="space-y-6">
                    <div
                        v-for="application in requirement.applications"
                        :key="application.id"
                        class="rounded-lg border p-5"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">
                                    {{ application.user.name }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ application.user.email }}
                                </p>
                            </div>

                            <span
                                class="rounded-full bg-gray-100 px-3 py-1 text-sm capitalize"
                            >
                                {{ application.status }}
                            </span>
                        </div>

                        <div class="mt-4 grid gap-3 md:grid-cols-2">
                            <p>
                                <strong>Quoted Price:</strong>

                                ₹{{ application.quoted_price }}
                            </p>

                            <p>
                                <strong>Estimated Days:</strong>

                                {{ application.estimated_days }} Days
                            </p>
                        </div>

                        <div class="mt-4">
                            <p class="font-medium">Cover Message</p>

                            <p class="mt-1 text-gray-700">
                                {{ application.message }}
                            </p>
                        </div>

                        <!-- Provider Contact -->

                        <div
                            v-if="application.status === 'accepted'"
                            class="mt-6 rounded-lg bg-green-50 p-5"
                        >
                            <h3
                                class="mb-4 text-lg font-semibold text-green-700"
                            >
                                Provider Contact Details
                            </h3>

                            <div class="space-y-2">
                                <p>
                                    <strong>Name:</strong>
                                    {{ application.user.name }}
                                </p>

                                <p>
                                    <strong>Email:</strong>
                                    {{ application.user.email }}
                                </p>

                                <p v-if="application.user.phone">
                                    <strong>Phone:</strong>
                                    {{ application.user.phone }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->

                        <div class="mt-6 flex flex-wrap gap-3">
                            <button
                                v-if="application.status === 'pending'"
                                @click="accept(application)"
                                class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                            >
                                Accept
                            </button>

                            <button
                                v-if="application.status === 'pending'"
                                @click="reject(application)"
                                class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                            >
                                Reject
                            </button>

                            <span
                                v-if="
                                    application.status === 'accepted' &&
                                    requirement.work_status !== 'completed'
                                "
                                class="rounded-md bg-green-100 px-4 py-2 font-medium text-green-700"
                            >
                                ✓ Accepted
                            </span>

                            <span
                                v-if="application.status === 'rejected'"
                                class="rounded-md bg-red-100 px-4 py-2 font-medium text-red-700"
                            >
                                Rejected
                            </span>

                            <button
                                v-if="
                                    application.status === 'accepted' &&
                                    requirement.work_status === 'in_progress'
                                "
                                @click="markCompleted"
                                class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                Mark as Completed
                            </button>

                            <span
                                v-if="
                                    application.status === 'accepted' &&
                                    requirement.work_status === 'completed'
                                "
                                class="rounded-md bg-blue-100 px-4 py-2 font-medium text-blue-700"
                            >
                                ✓ Project Completed
                            </span>

                            <span
                                v-if="
                                    application.status === 'accepted' &&
                                    requirement.review
                                "
                                class="rounded bg-green-100 px-4 py-2 text-green-700"
                            >
                                ⭐ Review Submitted
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    v-else
                    class="rounded-lg border border-dashed p-8 text-center text-gray-500"
                >
                    No applications received yet.
                </div>
            </div>

            <ReviewModal
                :show="showReviewModal"
                :requirement-id="requirement.id"
                @close="showReviewModal = false"
                @submitted="reviewSubmitted"
            />
        </div>
    </AuthenticatedLayout>
</template>
