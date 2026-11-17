
<script setup>
import { ref, onBeforeUnmount } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { RequirementSchema } from "@/Schemas/RequirementSchema";
import InputError from "@/Components/InputError.vue";
import { getFormErrors } from "@/Utils/validation";
import { toast } from "vue-sonner";
import { ArrowLeft } from "lucide-vue-next";    

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    category_id: "",
    title: "",
    description: "",
    budget: "",
    location: "",
    images: [],
});

const previews = ref([]);

const clearPreviews = () => {
    previews.value.forEach((preview) => {
        URL.revokeObjectURL(preview.url);
    });

    previews.value = [];
};

const handleImages = (event) => {
    const files = Array.from(event.target.files || []);

    if (files.length > 5) {
        toast.error("You can upload a maximum of 5 images.");
        event.target.value = "";
        form.images = [];
        clearPreviews();
        return;
    }

    const invalidFile = files.find(
        (file) =>
            !["image/jpeg", "image/png", "image/webp"].includes(file.type) ||
            file.size > 2 * 1024 * 1024
    );

    if (invalidFile) {
        toast.error("Use JPG, PNG or WEBP images up to 2 MB each.");
        event.target.value = "";
        form.images = [];
        clearPreviews();
        return;
    }

    clearPreviews();

    form.images = files;

    previews.value = files.map((file) => ({
        name: file.name,
        url: URL.createObjectURL(file),
    }));
};

const submit = () => {
    form.clearErrors();

    const result = RequirementSchema.safeParse({
        category_id: form.category_id,
        title: form.title,
        description: form.description,
        budget: form.budget,
        location: form.location,
    });

    if (!result.success) {
        form.setError(getFormErrors(result.error));
        return;
    }

    form.post(route("api.requirements.store"), {
        forceFormData: true,

        onSuccess: () => {
            toast.success("Requirement posted successfully!");
            clearPreviews();
        },

        onError: (errors) => {
            const firstError = Object.values(errors)[0];
            toast.error(firstError || "Something went wrong!");
        },
    });
};

onBeforeUnmount(() => {
    clearPreviews();
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FFF9F0] px-4 py-8 sm:px-6 lg:py-12">

            <div class="mx-auto max-w-5xl">

                <!-- Page heading -->
                <div class="mb-8">
                   <Link
                        :href="route('requirements.index')"
                        class="mb-5 inline-flex cursor-pointer items-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm font-semibold text-[#557267] shadow-sm transition hover:bg-[#F2F7F2] hover:text-[#003D2D]"
                    >
                        <ArrowLeft :size="16" />
                        Back to requirements
                    </Link>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <span class="mb-3 inline-flex rounded-full bg-[#E4EEE7] px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#003D2D]">
                                Find the right professional
                            </span>

                            <h1 class="text-3xl font-bold tracking-tight text-[#003D2D] sm:text-4xl">
                                Post a requirement
                            </h1>

                            <p class="mt-3 max-w-xl text-sm leading-6 text-[#64766E] sm:text-base">
                                Tell us what you need. Local service professionals
                                can review your requirement and send you proposals.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-[1fr_290px]">

                    <!-- Main form -->
                    <div class="overflow-hidden rounded-3xl border border-[#E9E5DC] bg-white shadow-[0_12px_40px_rgba(0,45,32,0.06)]">

                        <div class="border-b border-[#F0EEE8] px-6 py-5 sm:px-8">
                            <h2 class="text-lg font-bold text-[#003D2D]">
                                Requirement details
                            </h2>

                            <p class="mt-1 text-sm text-[#819087]">
                                Fields marked with * are required.
                            </p>
                        </div>

                        <form @submit.prevent="submit" class="space-y-7 p-6 sm:p-8">

                            <!-- Category -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-[#24483B]">
                                    Service category <span class="text-[#FF7900]">*</span>
                                </label>

                                <select
                                    v-model="form.category_id"
                                    class="w-full rounded-xl border border-[#E5E9E3] bg-[#FCFDFB] px-4 py-3 text-sm text-[#24483B] outline-none transition focus:border-[#FF7900] focus:ring-4 focus:ring-[#FF7900]/10"
                                >
                                    <option value="" disabled>
                                        Choose the service you need
                                    </option>

                                    <option
                                        v-for="category in props.categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>

                                <InputError :message="form.errors.category_id" />

                            </div>

                            <!-- Title -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-[#24483B]">
                                    Requirement title <span class="text-[#FF7900]">*</span>
                                </label>

                                <input
                                    v-model="form.title"
                                    type="text"
                                    maxlength="255"
                                    placeholder="e.g. Need a plumber to fix a leaking bathroom pipe"
                                    class="w-full rounded-xl border border-[#E5E9E3] bg-[#FCFDFB] px-4 py-3 text-sm text-[#24483B] outline-none transition placeholder:text-[#A5ADA7] focus:border-[#FF7900] focus:ring-4 focus:ring-[#FF7900]/10"
                                />

                                <InputError :message="form.errors.title" />
                            </div>

                            <!-- Description -->
                            <div>
                                <div class="mb-2 flex items-center justify-between gap-2">
                                    <label class="text-sm font-semibold text-[#24483B]">
                                        Describe your requirement <span class="text-[#FF7900]">*</span>
                                    </label>

                                    <span class="text-xs text-[#9AA59D]">
                                        Min. 20 characters
                                    </span>
                                </div>

                                <textarea
                                    v-model="form.description"
                                    rows="5"
                                    maxlength="1000"
                                    placeholder="Explain the work you need done, the problem you're facing, and any important details..."
                                    class="w-full resize-y rounded-xl border border-[#E5E9E3] bg-[#FCFDFB] px-4 py-3 text-sm leading-6 text-[#24483B] outline-none transition placeholder:text-[#A5ADA7] focus:border-[#FF7900] focus:ring-4 focus:ring-[#FF7900]/10"
                                ></textarea>

                                <div class="mt-1 flex justify-between gap-2">
                                    <InputError :message="form.errors.description" />
                                    <span class="shrink-0 text-xs text-[#A5ADA7]">
                                        {{ form.description.length }}/1000
                                    </span>
                                </div>
                            </div>

                            <!-- Budget and location -->
                            <div class="grid gap-5 sm:grid-cols-2">

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-[#24483B]">
                                        Your budget (₹) <span class="text-[#FF7900]">*</span>
                                    </label>

                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-[#829087]">
                                            ₹
                                        </span>

                                        <input
                                            v-model="form.budget"
                                            type="number"
                                            min="1"
                                            placeholder="e.g. 5000"
                                            class="w-full rounded-xl border border-[#E5E9E3] bg-[#FCFDFB] py-3 pl-9 pr-4 text-sm text-[#24483B] outline-none transition placeholder:text-[#A5ADA7] focus:border-[#FF7900] focus:ring-4 focus:ring-[#FF7900]/10"
                                        />
                                    </div>

                                    <p class="mt-1.5 text-xs text-[#9AA59D]">
                                        Your estimated spending budget.
                                    </p>

                                    <InputError :message="form.errors.budget" />
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-[#24483B]">
                                        Service location <span class="text-[#FF7900]">*</span>
                                    </label>

                                    <input
                                        v-model="form.location"
                                        type="text"
                                        maxlength="255"
                                        placeholder="Area, city or PIN code"
                                        class="w-full rounded-xl border border-[#E5E9E3] bg-[#FCFDFB] px-4 py-3 text-sm text-[#24483B] outline-none transition placeholder:text-[#A5ADA7] focus:border-[#FF7900] focus:ring-4 focus:ring-[#FF7900]/10"
                                    />

                                    <p class="mt-1.5 text-xs text-[#9AA59D]">
                                        Where should the professional visit?
                                    </p>

                                    <InputError :message="form.errors.location" />
                                </div>
                            </div>

                            <!-- Images -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-[#24483B]">
                                    Add photos <span class="font-normal text-[#9AA59D]">(optional)</span>
                                </label>

                                <label
                                    class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-[#DCE5DC] bg-[#FAFCF9] px-5 py-8 text-center transition hover:border-[#FF7900] hover:bg-[#FFF9F0]"
                                >
                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-[#E7F0E8] text-xl text-[#003D2D]">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L7 9m5-5 5 5M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3" />
                                        </svg>
                                    </div>

                                    <span class="text-sm font-semibold text-[#24483B]">
                                        Click to upload photos
                                    </span>

                                    <span class="mt-1 text-xs text-[#929E95]">
                                        JPG, PNG or WEBP · Maximum 5 images · 2 MB each
                                    </span>

                                    <input
                                        type="file"
                                        multiple
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="hidden"
                                        @change="handleImages"
                                    />
                                </label>

                                <InputError :message="form.errors.images" />

                                <!-- Image previews -->
                                <div
                                    v-if="previews.length"
                                    class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3"
                                >
                                    <div
                                        v-for="(preview, index) in previews"
                                        :key="preview.url"
                                        class="overflow-hidden rounded-xl border border-[#E5E9E3] bg-white"
                                    >
                                        <img
                                            :src="preview.url"
                                            :alt="preview.name"
                                            class="h-28 w-full object-cover"
                                        />

                                        <p class="truncate px-2 py-2 text-xs text-[#64766E]">
                                            {{ preview.name }}
                                        </p>

                                        <InputError :message="form.errors[`images.${index}`]" />
                                    </div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="border-t border-[#F0EEE8] pt-6">
                                    <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-[#FF7900] px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-[#FF7900]/20 transition hover:bg-[#E86E00] hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                            >
                                <span v-if="form.processing">
                                    Posting requirement...
                                </span>

                                <template v-else>
                                    Post Requirement
                                </template>
                            </button>

                                <p class="mt-3 text-xs leading-5 text-[#929E95]">
                                    By posting, you agree to provide accurate details
                                    so local professionals can respond to your requirement.
                                </p>
                            </div>

                        </form>
                    </div>

                    <!-- Sidebar -->
                    <aside class="space-y-5">

                        <div class="overflow-hidden rounded-3xl bg-[#003D2D] p-6 text-white shadow-lg">
                            <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-xl">
                                ✦
                            </div>

                            <h3 class="text-xl font-bold">
                                How Zervo works
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-white/65">
                                Finding the right local professional is simple.
                            </p>

                            <div class="mt-6 space-y-5">
                                <div class="flex gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#FF7900] text-sm font-bold">
                                        1
                                    </span>

                                    <div>
                                        <p class="text-sm font-semibold">Post your requirement</p>
                                        <p class="mt-1 text-xs leading-5 text-white/60">
                                            Tell us what service you need.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-sm font-bold">
                                        2
                                    </span>

                                    <div>
                                        <p class="text-sm font-semibold">Receive proposals</p>
                                        <p class="mt-1 text-xs leading-5 text-white/60">
                                            Local professionals can respond.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-sm font-bold">
                                        3
                                    </span>

                                    <div>
                                        <p class="text-sm font-semibold">Choose your professional</p>
                                        <p class="mt-1 text-xs leading-5 text-white/60">
                                            Compare proposals and get the work done.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-[#E9E5DC] bg-white p-6">
                            <h3 class="font-bold text-[#003D2D]">
                                Tips for a better response
                            </h3>

                            <ul class="mt-4 space-y-4 text-sm leading-5 text-[#64766E]">
                                <li class="flex gap-3">
                                    <span class="text-[#FF7900]">✓</span>
                                    Be specific about the work you need.
                                </li>

                                <li class="flex gap-3">
                                    <span class="text-[#FF7900]">✓</span>
                                    Mention your exact service location.
                                </li>

                                <li class="flex gap-3">
                                    <span class="text-[#FF7900]">✓</span>
                                    Set a realistic estimated budget.
                                </li>

                                <li class="flex gap-3">
                                    <span class="text-[#FF7900]">✓</span>
                                    Add photos to explain the problem.
                                </li>
                            </ul>
                        </div>

                        <div class="rounded-2xl bg-[#F2EDE2] p-5">
                            <p class="text-sm font-semibold text-[#003D2D]">
                                Your requirement, your choice.
                            </p>

                            <p class="mt-1 text-xs leading-5 text-[#78877C]">
                                Review the proposals you receive and choose
                                the professional who suits your needs.
                            </p>
                        </div>

                    </aside>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
