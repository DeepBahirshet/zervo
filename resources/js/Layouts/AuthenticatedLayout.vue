<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Header from '@/Components/layout/Header.vue';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { toast, Toaster } from 'vue-sonner';

const page = usePage();

watch(() => page.props.flash.success,
    (message) => {
        if(message){
            toast.success(message);
        }
    });

watch(() => page.props.flash.error, 
    (message) => {
        if(message){
            toast.error(message);
        }
    })

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <Header />
            <Toaster position="top-right" rich-colors close-button />
            <main class="py-6">
                <slot />
            </main>
        </div>
    </div>
</template>
