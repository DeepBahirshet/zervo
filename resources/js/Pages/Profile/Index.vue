<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    user: Object,
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-3xl">
            <div class="rounded-lg bg-white p-6 shadow">
                <h1 class="mb-6 text-2xl font-bold">My Profile</h1>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium">{{ user.name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ user.email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Member Since</p>
                        <p class="font-medium">
                            {{ new Date(user.created_at).toLocaleDateString() }}
                        </p>
                    </div>
                </div>

                <button
                    class="mt-8 rounded-md bg-amber-500 px-5 py-2 text-white hover:bg-amber-600"
                >
                    Edit Profile
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>