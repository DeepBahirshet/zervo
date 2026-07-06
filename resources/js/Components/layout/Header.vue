<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const isActive = (path) => page.url.startsWith('/'+ path);

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
                    :class="[
                        'rounded-md px-3 py-2 text-sm font-medium transition-colors',
                        isActive('requirements')
                            ? 'bg-amber-500 text-white'
                            : 'text-gray-700 hover:bg-gray-100 hover:text-amber-500'
                    ]"
                >
                    Requirements
                </Link>

                <Link
                    :href="route('profile')"
                    :class="['rounded-md px-3 py-2 text-sm font-medium transition-colors',
                            isActive('profile') 
                            ? 'bg-amber-500 text-white'
                            : 'text-gray-700 hover:bg-gray-100 hover:text-amber-500'
                    ]"
                >
                    Profile
                </Link>

                <Link
                    :href="route('logout')"
                    class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 text-gray-700 hover:text-amber-500"
                >
                    Logout
                </Link>
            </nav>
        </div>
    </header>
</template>