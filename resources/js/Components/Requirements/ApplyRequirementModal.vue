<script setup>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import { getFormErrors } from '@/Utils/validation';
import { ApplicationSchema } from '@/Schemas/ApplicationSchema';
import ApplicationService from '@/Services/ApplicationService';
import { toast } from 'vue-sonner';
import { ref } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    requirementId: {
        type: Number,
        required: true
    },
    isApplied: {
        type: Boolean,
        required: false
    }
})

const isApplied = ref(props.isApplied);

const emit = defineEmits(['close', 'isApplied'])

const form = useForm({
    message: '',
    quoted_price: '',
    estimated_days: '',
})

const closeModal = () => {
    form.reset()
    form.clearErrors()
    emit('close')
}

const submit = async() => {

    form.clearErrors();

    const result = ApplicationSchema.safeParse({
        message: form.message,
        quoted_price: form.quoted_price,
        estimated_days: form.estimated_days
    });

    if(!result.success)
    {
        form.setError(getFormErrors(result.error));
        return;
    }

    try {

        await ApplicationService.apply(
            props.requirementId,
            form.data()
        )

        toast.success('Application submitted successfully.')
        emit('isApplied');
        closeModal()

    } catch (error) {
        if (error.response?.status === 422) {
            toast.error(error.response.data.message);
            closeModal();
        }
    }
}
</script>

<template>
    <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="show"
            class="fixed inset-0 z-50 overflow-y-auto"
        >
            <!-- Overlay -->
            <div
                class="fixed inset-0 bg-black/50"
                @click="closeModal"
            />

            <!-- Modal -->
            <div class="flex min-h-screen items-center justify-center p-4">
                <div
                    class="relative w-full max-w-2xl rounded-lg bg-white shadow-xl"
                >
                    <!-- Header -->
                    <div
                        class="flex items-center justify-between border-b px-6 py-4"
                    >
                        <h2 class="text-xl font-semibold">
                            Apply for Requirement
                        </h2>

                        <button
                            @click="closeModal"
                            class="text-2xl text-gray-500 hover:text-gray-700"
                        >
                            &times;
                        </button>
                    </div>

                    <!-- Body -->
                    <form
                        @submit.prevent="submit"
                        class="space-y-5 p-6"
                    >
                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                Cover Message
                            </label>

                            <textarea
                                v-model="form.message"
                                rows="5"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-amber-500 focus:outline-none"
                                placeholder="Describe why you're the right person for this work..."
                            />

                           <InputError :message="form.errors.message" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    Quoted Price (₹)
                                </label>

                                <input
                                    v-model="form.quoted_price"
                                    type="number"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-amber-500 focus:outline-none"
                                    placeholder="5000"
                                >

                                <InputError :message="form.errors.quoted_price" />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    Estimated Days
                                </label>

                                <input
                                    v-model="form.estimated_days"
                                    type="number"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-amber-500 focus:outline-none"
                                    placeholder="5"
                                >

                                <InputError :message="form.errors.estimated_days" />
                            </div>

                        </div>

                        <!-- Footer -->
                        <div class="flex justify-end gap-3 pt-4">

                            <button
                                type="button"
                                @click="closeModal"
                                class="rounded-md border border-gray-300 px-5 py-2 hover:bg-gray-100"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-md bg-amber-500 px-5 py-2 text-white hover:bg-amber-600 disabled:opacity-50"
                            >
                                Submit Application
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Transition>
</template>