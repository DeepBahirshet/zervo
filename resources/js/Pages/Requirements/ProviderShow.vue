
<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ApplyRequirementModal from "@/Components/Requirements/ApplyRequirementModal.vue";

import {
    ArrowLeft,
    MapPin,
    CalendarDays,
    IndianRupee,
    BriefcaseBusiness,
    Clock3,
    CheckCircle2,
    XCircle,
    UserRound,
    Mail,
    Phone,
    ShieldCheck,
} from "lucide-vue-next";

const props = defineProps({
    requirement: Object,
    hasApplied: Boolean,
    application: Object,
});

const showApplyModal = ref(false);
const isApplied = ref(props.hasApplied);
const currentApplication = ref(props.application);

const handleApply = (newApplication) => {
    isApplied.value = true;

    if (newApplication) {
        currentApplication.value = newApplication;
    }
};

const requirementStatus = (status) => {
    const statuses = {
        pending: "Pending",
        approved: "Approved",
        in_progress: "In Progress",
        completed: "Completed",
        cancelled: "Cancelled",
        rejected: "Rejected",
    };

    return statuses[status] || "Pending";
};

const formatDate = (date) => {
    if (!date) return "Recently posted";

    return new Date(date).toLocaleDateString("en-IN", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FFF9F0]">
            <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

                <!-- Back Button -->
                <Link
                    :href="route('requirements.index')"
                    class="mb-5 inline-flex cursor-pointer items-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm font-semibold text-[#557267] shadow-sm transition hover:bg-[#F2F7F2] hover:text-[#003D2D]"
                >
                    <ArrowLeft :size="16" />
                    Back to requirements
                </Link>

                <!-- Heading -->
                <div class="mb-8">
                    <div class="mb-3 flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-[#EAF1EB] px-3 py-1 text-xs font-semibold text-[#003D2D]">
                            {{ requirementStatus(requirement.status) }}
                        </span>

                        <span class="text-sm text-[#829087]">
                            Posted {{ formatDate(requirement.created_at) }}
                        </span>
                    </div>

                    <h1 class="max-w-3xl text-3xl font-bold tracking-tight text-[#173D30] sm:text-4xl">
                        {{ requirement.title }}
                    </h1>

                    <div class="mt-4 flex items-center gap-2 text-sm text-[#718078]">
                        <MapPin :size="17" class="text-[#F47700]" />
                        {{ requirement.location }}
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">

                    <!-- Main Content -->
                    <main class="space-y-8 lg:col-span-2">

                        <!-- Images -->
                        <section v-if="requirement.images?.length">
                            <h2 class="mb-4 text-lg font-bold text-[#173D30]">
                                Project images
                            </h2>

                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                                <img
                                    v-for="image in requirement.images"
                                    :key="image.id"
                                    :src="`/storage/${image.image}`"
                                    :alt="requirement.title"
                                    class="h-44 w-full rounded-2xl border border-[#E7E9DF] object-cover transition hover:opacity-90"
                                />
                            </div>
                        </section>

                        <!-- Description -->
                        <section>
                            <h2 class="mb-4 text-lg font-bold text-[#173D30]">
                                About this requirement
                            </h2>

                            <div class="rounded-2xl border border-[#E7E9DF] bg-white p-6">
                                <p class="whitespace-pre-line text-sm leading-7 text-[#63736A]">
                                    {{ requirement.description }}
                                </p>
                            </div>
                        </section>

                        <!-- Application -->
                        <section v-if="currentApplication">
                            <h2 class="mb-4 text-lg font-bold text-[#173D30]">
                                My application
                            </h2>

                            <div class="rounded-2xl border border-[#E7E9DF] bg-white p-6">

                                <!-- Pending -->
                                <div
                                    v-if="currentApplication.status === 'pending'"
                                    class="flex gap-3"
                                >
                                    <Clock3 class="mt-1 shrink-0 text-amber-600" :size="21" />

                                    <div>
                                        <h3 class="font-semibold text-[#173D30]">
                                            Application under review
                                        </h3>
                                        <p class="mt-1 text-sm leading-6 text-[#718078]">
                                            Your proposal has been submitted. The requirement owner will review your application.
                                        </p>
                                    </div>
                                </div>

                                <!-- Accepted -->
                                <div
                                    v-else-if="currentApplication.status === 'accepted'"
                                    class="flex gap-3"
                                >
                                    <CheckCircle2 class="mt-1 shrink-0 text-emerald-600" :size="21" />

                                    <div>
                                        <h3 class="font-semibold text-emerald-800">
                                            Your application has been accepted!
                                        </h3>
                                        <p class="mt-1 text-sm text-[#718078]">
                                            You can now contact the requirement owner.
                                        </p>
                                    </div>
                                </div>

                                <!-- Rejected -->
                                <div
                                    v-else-if="currentApplication.status === 'rejected'"
                                    class="flex gap-3"
                                >
                                    <XCircle class="mt-1 shrink-0 text-red-600" :size="21" />

                                    <div>
                                        <h3 class="font-semibold text-red-800">
                                            Application not selected
                                        </h3>
                                        <p class="mt-1 text-sm text-[#718078]">
                                            Unfortunately, your application was not selected for this requirement.
                                        </p>
                                    </div>
                                </div>

                                <!-- Contact Details -->
                                <div
                                    v-if="currentApplication.status === 'accepted'"
                                    class="mt-6 border-t border-[#EDF0EB] pt-6"
                                >
                                    <h3 class="mb-4 font-bold text-[#173D30]">
                                        Requirement owner contact
                                    </h3>

                                    <div class="space-y-4 text-sm">
                                        <div class="flex items-center gap-3">
                                            <UserRound :size="17" class="text-[#829087]" />
                                            <span class="text-[#173D30]">
                                                {{ requirement.user.name }}
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <Mail :size="17" class="text-[#829087]" />
                                            <a
                                                :href="`mailto:${requirement.user.email}`"
                                                class="break-all text-[#003D2D] hover:underline"
                                            >
                                                {{ requirement.user.email }}
                                            </a>
                                        </div>

                                        <div
                                            v-if="requirement.user.phone"
                                            class="flex items-center gap-3"
                                        >
                                            <Phone :size="17" class="text-[#829087]" />
                                            <a
                                                :href="`tel:${requirement.user.phone}`"
                                                class="text-[#003D2D] hover:underline"
                                            >
                                                {{ requirement.user.phone }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </main>

                    <!-- Sidebar -->
                    <aside class="lg:sticky lg:top-6 lg:self-start">

                        <!-- Budget -->
                        <div class="rounded-2xl border border-[#E7E9DF] bg-white p-6">
                            <p class="text-sm font-medium text-[#829087]">
                                Proposed budget
                            </p>

                            <div class="mt-2 flex items-center gap-1 text-[#003D2D]">
                                <IndianRupee :size="25" />
                                <span class="text-3xl font-bold">
                                    {{ Number(requirement.budget).toLocaleString("en-IN") }}
                                </span>
                            </div>

                            <div class="my-5 border-t border-[#EDF0EB]"></div>

                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF1EB]">
                                    <MapPin :size="19" class="text-[#003D2D]" />
                                </div>

                                <div>
                                    <p class="text-xs text-[#829087]">Location</p>
                                    <p class="text-sm font-semibold text-[#173D30]">
                                        {{ requirement.location }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF1E5]">
                                    <CalendarDays :size="19" class="text-[#F47700]" />
                                </div>

                                <div>
                                    <p class="text-xs text-[#829087]">Posted on</p>
                                    <p class="text-sm font-semibold text-[#173D30]">
                                        {{ formatDate(requirement.created_at) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Apply Button -->
                            <button
                                v-if="!isApplied"
                                type="button"
                                @click="showApplyModal = true"
                                class="mt-7 w-full rounded-xl bg-[#F47700] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[#DE6900]"
                            >
                                Apply for this work
                            </button>

                            <div
                                v-else
                                class="mt-7 flex items-center justify-center gap-2 rounded-xl bg-[#EAF1EB] px-5 py-3.5 text-sm font-semibold text-[#003D2D]"
                            >
                                <CheckCircle2 :size="18" />
                                {{ currentApplication?.status === "accepted" ? "Application accepted" : "Already applied" }}
                            </div>

                            <div class="mt-5 flex gap-2 border-t border-[#EDF0EB] pt-5">
                                <ShieldCheck :size="17" class="mt-0.5 shrink-0 text-[#003D2D]" />

                                <p class="text-xs leading-5 text-[#829087]">
                                    Your contact details stay private. Owner contact information is revealed after acceptance.
                                </p>
                            </div>
                        </div>

                    </aside>
                </div>
            </div>
        </div>

        <!-- Apply Modal -->
        <ApplyRequirementModal
            :requirementId="requirement.id"
            :show="showApplyModal"
            @close="showApplyModal = false"
            @isApplied="handleApply"
        />
    </AuthenticatedLayout>
</template>
