<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ApplicationService from '@/Services/ApplicationService';
import { toast } from 'vue-sonner';

defineProps({
    requirement: Object,
});

const accept = async (application) => {
    try {
        await ApplicationService.accept(application.id);

        application.status = 'accepted';

        toast.success('Application accepted successfully.');
    } catch (error) {
        toast.error('Failed to accept application.');
    }
}

const reject = async (application) => {
    try {
        await ApplicationService.reject(application.id);

        application.status = 'rejected';

        toast.success('Application rejected successfully.');
    } catch (error) {
        toast.error('Failed to reject application.');
    }
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-5xl space-y-8">

            <!-- Requirement Details -->
            <div class="rounded-lg bg-white p-6 shadow">
                <h1 class="text-3xl font-bold">
                    {{ requirement.title }}
                </h1>

                <p class="mt-4 text-gray-700">
                    {{ requirement.description }}
                </p>

                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <p>
                        <strong>Budget:</strong>
                        ₹{{ requirement.budget }}
                    </p>

                    <p>
                        <strong>Location:</strong>
                        {{ requirement.location }}
                    </p>

                    <p>
                        <strong>Status:</strong>
                        {{ requirement.status }}
                    </p>

                    <p>
                        <strong>Created:</strong>
                        {{ new Date(requirement.created_at).toLocaleDateString('en-IN') }}
                    </p>
                </div>
            </div>

            <!-- Applications -->
            <div class="rounded-lg bg-white p-6 shadow">
                <h2 class="mb-6 text-2xl font-semibold">
                    Applications
                </h2>

                <div
                    v-if="requirement.applications.length"
                    class="space-y-4"
                >
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
                                class="rounded-full bg-gray-100 px-3 py-1 text-sm"
                            >
                                {{ application.status }}
                            </span>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                            <p>
                                <strong>Quoted Price:</strong>
                                ₹{{ application.quoted_price }}
                            </p>

                            <p>
                                <strong>Estimated Days:</strong>
                                {{ application.estimated_days }} days
                            </p>
                        </div>

                        <div class="mt-4">
                            <p class="font-medium">
                                Cover Message
                            </p>

                            <p class="mt-1 text-gray-700">
                                {{ application.message }}
                            </p>
                        </div>

                        <div class="mt-6 flex gap-3">

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
                              v-if="application.status === 'accepted'"
                              class="rounded-md bg-green-100 px-4 py-2 text-green-700"
                          >
                              Accepted
                          </span>

                          <span
                              v-if="application.status === 'rejected'"
                              class="rounded-md bg-red-100 px-4 py-2 text-red-700"
                          >
                              Rejected
                          </span>

                      </div>
                  </div>
                </div>

            </div>

        </div>
    </AuthenticatedLayout>
</template>