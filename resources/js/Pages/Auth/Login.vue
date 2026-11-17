
    <script setup>
    import { ref } from 'vue';
    import Checkbox from '@/Components/Checkbox.vue';
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import {
        Sparkles,
        Eye,
        EyeOff,
        ArrowRight,
        ShieldCheck,
        Zap,
    } from 'lucide-vue-next';

    defineProps({
        canResetPassword: Boolean,
        status: String,
    });

    const showPassword = ref(false);

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };
    </script>

    <template>
        <GuestLayout>
            <Head title="Welcome Back | Zervo" />

            <div class="w-full">
                <!-- Brand -->
                <div class="mb-8 text-center">
                    <Link href="/" class="inline-flex items-center text-3xl font-extrabold tracking-tight text-[#123E2E]">
                        <span class="text-[#FF7900]">Z</span>ervo<span class="text-[#FF7900]">.</span>
                    </Link>

                    <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#123E2E]">
                        Welcome back!
                    </h1>

                    <p class="mt-2 text-sm text-gray-500">
                        Sign in to continue your Zervo journey.
                    </p>
                </div>

                <!-- Status -->
                <div
                    v-if="status"
                    class="mb-5 rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm font-medium text-green-700"
                >
                    {{ status }}
                </div>

                <!-- Login Form -->
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <InputLabel for="email" value="Email address" class="!font-semibold !text-[#234238]" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-2 block w-full !rounded-xl !border-[#E5EDE7] !bg-[#FAFCFA] !px-4 !py-3 !text-sm focus:!border-[#08744D] focus:!ring-[#08744D]/10"
                            v-model="form.email"
                            placeholder="you@example.com"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <InputLabel for="password" value="Password" class="!font-semibold !text-[#234238]" />

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-xs font-semibold text-[#08744D] transition hover:text-[#FF7900]"
                            >
                                Forgot password?
                            </Link>
                        </div>

                        <div class="relative mt-2">
                            <TextInput
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                class="block w-full !rounded-xl !border-[#E5EDE7] !bg-[#FAFCFA] !py-3 !pl-4 !pr-12 !text-sm focus:!border-[#08744D] focus:!ring-[#08744D]/10"
                                v-model="form.password"
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                            />

                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-[#08744D]"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                            >
                                <EyeOff v-if="showPassword" :size="18" />
                                <Eye v-else :size="18" />
                            </button>
                        </div>

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                            class="rounded border-gray-300 text-[#08744D] focus:ring-[#08744D]"
                        />
                        <span class="ms-2 text-sm text-gray-500">
                            Keep me logged in
                        </span>
                    </div>

                    <!-- Submit -->
                    <PrimaryButton
                        class="!flex w-full !justify-center !rounded-xl !bg-[#07563A] !px-5 !py-3.5 !text-sm !font-bold !text-white shadow-lg shadow-emerald-950/10 transition hover:!bg-[#06452F] hover:shadow-xl"
                        :class="{ 'opacity-50': form.processing }"
                        :disabled="form.processing"
                    >
                        <span>{{ form.processing ? 'Signing in...' : 'Sign in to Zervo' }}</span>
                        <ArrowRight class="ml-2" :size="18" />
                    </PrimaryButton>
                </form>

                <!-- Register -->
                <div class="mt-7 text-center">
                    <p class="text-sm text-gray-500">
                        Don't have an account?
                        <Link
                            :href="route('register')"
                            class="font-bold text-[#08744D] transition hover:text-[#FF7900]"
                        >
                            Create an account
                        </Link>
                    </p>
                </div>

                <!-- Trust Footer -->
                <div class="mt-8 flex items-center justify-center gap-5 border-t border-[#EDF0EC] pt-5">
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-400">
                        <ShieldCheck :size="15" class="text-[#08744D]" />
                        Secure login
                    </span>

                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-400">
                        <Zap :size="14" class="text-[#FF7900]" />
                        Simple & fast
                    </span>
                </div>
            </div>
        </GuestLayout>
    </template>
