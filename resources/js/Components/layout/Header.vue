<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <header class="border-b bg-white shadow-sm">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6">
            <!-- Logo -->
            <Link
                :href="route('requirements.index')"
                class="text-2xl font-bold text-amber-500"
            >
                Zervo
            </Link>

            <!-- Navigation -->
            <nav class="flex items-center gap-6">
                <Link
                    :href="route('requirements.index')"
                    class="text-sm font-medium text-gray-700 hover:text-amber-500"
                >
                    Requirements
                </Link>

                <Link
                    href="#"
                    class="text-sm font-medium text-gray-700 hover:text-amber-500"
                >
                    Profile
                </Link>

                <Link
                    href="#"
                    class="text-sm font-medium text-gray-700 hover:text-amber-500"
                >
                    Logout
                </Link>
            </nav>
        </div>
    </header>
</template>