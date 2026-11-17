
<script setup>
</script>

<template>
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#FFF9F0] px-4 py-10">

        <!-- Background gradients -->
        <div class="pointer-events-none absolute -left-32 -top-32 h-96 w-96 rounded-full bg-emerald-200/40 blur-[100px]"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-orange-200/40 blur-[100px]"></div>

        <!-- Decorative background elements -->
        <div class="pointer-events-none absolute right-[12%] top-[15%] h-24 w-24 rounded-full border border-[#FF7900]/10"></div>
        <div class="pointer-events-none absolute bottom-[15%] left-[12%] h-16 w-16 rounded-full border border-emerald-700/10"></div>

        <!-- Main content -->
        <div class="relative z-10 w-full max-w-md">

            <div class="overflow-hidden rounded-[28px] border border-white/80 bg-white/95 p-7 shadow-[0_25px_80px_rgba(7,59,58,0.12)] backdrop-blur-xl sm:p-9">
                <slot />
            </div>

            <!-- Footer -->
            <p class="mt-6 text-center text-xs font-medium text-[#82958A]">
                © {{ new Date().getFullYear() }} Zervo. All rights reserved.
            </p>
        </div>
    </div>
</template>
