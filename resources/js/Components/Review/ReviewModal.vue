<script setup>
import { ref } from "vue";
import ReviewService from "@/Services/ReviewService";
import { toast } from "vue-sonner";
import RequirementService from "../../Services/RequirementService";

const props = defineProps({
    show: Boolean,
    requirementId: Number,
});

const emit = defineEmits(["close", "submitted"]);

const rating = ref(0);
const review = ref("");
const loading = ref(false);

const submit = async () => {
    if (!rating.value) {
        toast.error("Please select a rating.");
        return;
    }

    loading.value = true;

    try {
        await ReviewService.store(props.requirementId, {
            rating: rating.value,
            review: review.value,
        });

        await RequirementService.complete(props.requirementId);

        toast.success("Project completed successfully.");

        emit("submitted");
        emit("close");
        
    } catch (e) {
        toast.error(
            e.response?.data?.message ?? "Unable to submit review."
        );
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-lg rounded-xl bg-white p-6">

            <h2 class="text-2xl font-bold">
                Rate Provider
            </h2>

            <p class="mt-2 text-gray-500">
                How was your experience?
            </p>

            <!-- Stars -->

            <div class="mt-6 flex gap-2">

                <button
                    v-for="star in 5"
                    :key="star"
                    @click="rating = star"
                    class="text-4xl transition"
                >
                    {{ star <= rating ? "⭐" : "☆" }}
                </button>

            </div>

            <textarea
                v-model="review"
                rows="5"
                class="mt-6 w-full rounded-lg border p-3"
                placeholder="Write your review..."
            />

            <div class="mt-6 flex justify-end gap-3">

                <button
                    @click="$emit('close')"
                    class="rounded bg-gray-200 px-4 py-2"
                >
                    Cancel
                </button>

                <button
                    @click="submit"
                    :disabled="loading"
                    class="rounded bg-blue-600 px-4 py-2 text-white"
                >
                    {{ loading ? "Submitting..." : "Submit Review" }}
                </button>

            </div>

        </div>
    </div>
</template>