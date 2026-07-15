<script setup>
import ApplyRequirementModal from '@/Components/Requirements/ApplyRequirementModal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue';

const props = defineProps({
    requirement: Object,
    hasApplied: Boolean
});

const showApplyModal = ref(false);
const isApplied = ref(props.hasApplied);

const handleApply = () => {
    isApplied.value = true;
}

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
                v-if="!isApplied"
                @click="showApplyModal = true"
                class="mt-8 rounded-md bg-amber-500 px-6 py-3 text-white hover:bg-amber-600"
            >
                Apply
            </button>

            <button v-else class="inline-flex items-center rounded-md bg-green-100 px-4 py-2 mt-4 cursor-not-allowed text-green-700 font-medium">
               ✓ Applied
            </button>
        </div>
        <ApplyRequirementModal @close="showApplyModal = false" @isApplied="handleApply" :requirementId="requirement.id" :show="showApplyModal" />
    </AuthenticatedLayout>
</template>