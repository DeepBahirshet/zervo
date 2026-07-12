<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { useForm } from '@inertiajs/vue3';
import { RequirementSchema } from '@/Schemas/RequirementSchema';
import InputError from '@/Components/InputError.vue';
import { getFormErrors } from '@/Utils/validation';
import { toast } from 'vue-sonner';

const form = useForm({
    title: '',
    description: '',
    budget: '',
    location: '',
})

const submit = () => {
    form.clearErrors();

   const result = RequirementSchema.safeParse({
        title: form.title,
        description: form.description,
        budget: form.budget,
        location: form.location
   });

   if(!result.success){
        form.setError(getFormErrors(result.error));
        return;
   }

    form.clearErrors();

    form.post(route('api.requirements.store'), {
        onSuccess: () => {
            toast.success('Requirement posted successfully!');
        },
        onError: () => {
            toast.error('Something went wrong!');
        }
    });


}
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow">
            <h1 class="mb-6 text-2xl font-bold">
                Post Requirement
            </h1>

            <form @submit.prevent="submit" class="space-y-5">

                <div>
                    <label class="mb-1 block font-medium">
                        Title
                    </label>

                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full rounded-md border px-3 py-2"
                    >
                    <InputError :message="form.errors.title" />
                </div>

                <div>
                    <label class="mb-1 block font-medium">
                        Description
                    </label>

                    <textarea
                        v-model="form.description"
                        rows="5"
                        class="w-full rounded-md border px-3 py-2"
                    />
                    <InputError :message="form.errors.description" />
                </div>

                <div class="grid gap-4 md:grid-cols-2">

                    <div>
                        <label class="mb-1 block font-medium">
                            Budget
                        </label>

                        <input
                            v-model="form.budget"
                            type="number"
                            class="w-full rounded-md border px-3 py-2"
                        >
                        <InputError :message="form.errors.budget" />
                    </div>

                    <div>
                        <label class="mb-1 block font-medium">
                            Location
                        </label>

                        <input
                            v-model="form.location"
                            type="text"
                            class="w-full rounded-md border px-3 py-2"
                        >
                        <InputError :message="form.errors.location" />
                    </div>

                </div>

                <button
                    class="rounded-md bg-amber-500 px-5 py-2 text-white hover:bg-amber-600"
                >
                    Post Requirement
                </button>

            </form>
        </div>
    </AuthenticatedLayout>
</template>