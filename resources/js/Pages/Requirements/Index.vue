<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const loading = ref(false);
const requirements = ref([]);
const error = ref('');

const fetchRequirements = async () => {
   loading.value = true;

   try {

    const {data} = await axios.get('api/requirements');

    requirements.value = data.data;

   } catch (err) {
      error.value = 'Could not load requirements. Please try again.';
   }

    finally {
      loading.value = false;
   }
} 

onMounted(fetchRequirements);

</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl py-6">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-3xl font-bold">Requirements</h1>

                <Link
                    :href="route('requirements.create')"
                    class="rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-600"
                >
                    Post Requirement
                </Link>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="requirement in requirements"
                    :key="requirement.id"
                    class="rounded-lg border bg-white p-5 shadow-sm"
                >
                    <h2 class="mb-2 text-xl font-semibold">
                        {{ requirement.title }}
                    </h2>

                    <p class="mb-4 text-gray-600">
                        {{ requirement.description }}
                    </p>

                    <div class="flex justify-between text-sm text-gray-500">
                        <span>{{ requirement.location }}</span>
                        <span class="font-semibold text-amber-600">
                            {{ requirement.budget }}
                        </span>
                    </div>

                    <Link
                        :href="route('requirements.show', requirement.id)"
                        class="mt-5 block w-full rounded-md bg-amber-500 py-2 text-center  text-white hover:bg-amber-600"
                    >
                        View Details
                  </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>