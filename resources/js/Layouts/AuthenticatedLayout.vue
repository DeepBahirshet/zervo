
<script setup>
import Header from "@/Components/Layouts/Header.vue";
import Footer from "@/Components/Layouts/Footer.vue";
import { usePage } from "@inertiajs/vue3";
import { watch } from "vue";
import { toast, Toaster } from "vue-sonner";

const page = usePage();

watch(
    () => page.props.flash.success,
    (message) => {
        if (message) {
            toast.success(message);
        }
    }
);

watch(
    () => page.props.flash.error,
    (message) => {
        if (message) {
            toast.error(message);
        }
    }
);
</script>

<template>
    <div class="min-h-screen bg-[#FFF9F0]">
        <Header />

        <Toaster position="top-right" rich-colors close-button />

        <main class="min-h-[60vh]">
            <slot />
        </main>

        <Footer />
    </div>
</template>
