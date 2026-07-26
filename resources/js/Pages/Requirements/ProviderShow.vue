<script setup>
import ApplyRequirementModal from "@/Components/Requirements/ApplyRequirementModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";

const props = defineProps({
    requirement: Object,
    hasApplied: Boolean,
    application: Object,
});

const showApplyModal = ref(false);
const isApplied = ref(props.hasApplied);

const handleApply = () => {
    isApplied.value = true;
};

const requirementStatus = (status) => {
    switch (status) {
        case "pending":
            return "Pending";

        case "approved":
            return "Approved";

        case "in_progress":
            return "In Progress";

        case "completed":
            return "Completed";

        case "cancelled":
            return "Cancelled";

        case "rejected":
            return "Rejected";

        default:
            return "Pending";
    }
};
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
                <p>
                    <strong>Status:</strong>
                    {{ requirementStatus(requirement.status) }}
                </p>
            </div>

            <div v-if="application" class="mt-8 rounded-lg border p-5">
                <h2 class="mb-4 text-xl font-semibold">My Application</h2>

                <div class="mb-4">
                    <span
                        v-if="application.status === 'pending'"
                        class="rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-700"
                    >
                        Pending Review
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
                </div>

                <p
                    v-if="application.status === 'pending'"
                    class="text-gray-600"
                >
                    Your application is waiting for the requirement owner to
                    review it.
                </p>

                <p
                    v-else-if="application.status === 'accepted'"
                    class="text-green-700 font-medium"
                >
                    🎉 Congratulations! Your application has been accepted.
                </p>

                <p v-else class="text-red-700">
                    Your application was not selected for this requirement.
                </p>

                <!-- Contact Details -->

                <div
                    v-if="application.status === 'accepted'"
                    class="mt-6 rounded-lg bg-green-50 p-4"
                >
                    <h3 class="mb-3 text-lg font-semibold">
                        Requirement Owner Contact Details
                    </h3>

                    <div class="space-y-2">
                        <p>
                            <strong>Name:</strong>
                            {{ requirement.user.name }}
                        </p>

                        <p>
                            <strong>Email:</strong>
                            {{ requirement.user.email }}
                        </p>

                        <p v-if="requirement.user.phone">
                            <strong>Phone:</strong>
                            {{ requirement.user.phone }}
                        </p>
                    </div>
                </div>
            </div>

            <button
                v-if="!isApplied"
                @click="showApplyModal = true"
                class="mt-8 rounded-md bg-amber-500 px-6 py-3 text-white hover:bg-amber-600"
            >
                Apply
            </button>

            <button
                v-else-if="application && application.status != 'accepted'"
                class="inline-flex items-center rounded-md bg-green-100 px-4 py-2 mt-4 cursor-not-allowed text-green-700 font-medium"
            >
                ✓ Applied
            </button>
        </div>
        <ApplyRequirementModal
            @close="showApplyModal = false"
            @isApplied="handleApply"
            :requirementId="requirement.id"
            :show="showApplyModal"
        />
    </AuthenticatedLayout>
</template>
