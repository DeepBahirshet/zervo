
<script setup>
import { ref } from 'vue';
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
} from 'lucide-vue-next';

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const countryCodes = [
    { code: '+91', flag: '🇮🇳', country: 'India' },
    { code: '+1', flag: '🇺🇸', country: 'United States' },
    { code: '+44', flag: '🇬🇧', country: 'United Kingdom' },
    { code: '+971', flag: '🇦🇪', country: 'UAE' },
    { code: '+61', flag: '🇦🇺', country: 'Australia' },
    { code: '+65', flag: '🇸🇬', country: 'Singapore' },
    { code: '+49', flag: '🇩🇪', country: 'Germany' },
    { code: '+33', flag: '🇫🇷', country: 'France' },
    { code: '+81', flag: '🇯🇵', country: 'Japan' },
    { code: '+977', flag: '🇳🇵', country: 'Nepal' },
];

const countryCode = ref('+91');
const phone = ref('');

const form = useForm({
    name: '',
    email: '',
    country_code: '+91',
    phone: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    const payload = {
        ...form.data(),
        phone: `${form.country_code}${form.phone}`,
    };

    form.transform(() => payload).post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const inputClass = 'mt-2 block w-full !rounded-xl !border-[#E5EDE7] !bg-[#FAFCFA] !px-4 !py-3 !text-sm focus:!border-[#08744D] focus:!ring-[#08744D]/10';
</script>

<template>
    <GuestLayout>
        <Head title="Create Account | Zervo" />

        <!-- Header -->
        <div class="mb-7 text-center">
            <Link href="/" class="inline-flex items-center text-3xl font-extrabold tracking-tight text-[#123E2E]">
                <span class="text-[#FF7900]">Z</span>ervo<span class="text-[#FF7900]">.</span>
            </Link>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-[#123E2E]">
                Create your account
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Get connected with trusted local professionals.
            </p>
        </div>

        <!-- Registration Form -->
        <form @submit.prevent="submit" class="space-y-4">

            <!-- Name -->
            <div>
                <InputLabel for="name" value="Full name" class="!font-semibold !text-[#234238]" />

                <TextInput
                    id="name"
                    type="text"
                    :class="inputClass"
                    v-model="form.name"
                    placeholder="Enter your full name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email address" class="!font-semibold !text-[#234238]" />

                <TextInput
                    id="email"
                    type="email"
                    :class="inputClass"
                    v-model="form.email"
                    placeholder="you@example.com"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Phone -->
            <div>
                <InputLabel
                    for="phone"
                    value="Mobile number"
                    class="!font-semibold !text-[#234238]"
                />

                <div class="mt-2 flex overflow-hidden rounded-xl border border-[#E5EDE7] bg-[#FAFCFA] transition focus-within:border-[#08744D] focus-within:ring-2 focus-within:ring-[#08744D]/10">

                    <!-- Country Code Selector -->
                    <select
                        v-model="form.country_code"
                        aria-label="Country calling code"
                        class="w-[115px] shrink-0 cursor-pointer border-0 border-r border-[#E5EDE7] bg-transparent py-3 pl-3 pr-2 text-sm font-semibold text-[#456156] focus:border-0 focus:ring-0"
                    >
                        <option
                            v-for="country in countryCodes"
                            :key="country.country"
                            :value="country.code"
                        >
                            {{ country.flag }} {{ country.code }}
                        </option>
                    </select>

                    <!-- Phone Input -->
                    <TextInput
                        id="phone"
                        type="tel"
                        class="block w-full !border-0 !bg-transparent !px-3 !py-3 !text-sm focus:!ring-0"
                        v-model="form.phone"
                        placeholder="Enter mobile number"
                        required
                        maxlength="15"
                        autocomplete="tel-national"
                    />
                </div>

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <!-- Password -->
            <div>
                <InputLabel for="password" value="Password" class="!font-semibold !text-[#234238]" />

                <div class="relative mt-2">
                    <TextInput
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="block w-full !rounded-xl !border-[#E5EDE7] !bg-[#FAFCFA] !py-3 !pl-4 !pr-12 !text-sm focus:!border-[#08744D] focus:!ring-[#08744D]/10"
                        v-model="form.password"
                        placeholder="Create a password"
                        required
                        autocomplete="new-password"
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

            <!-- Confirm Password -->
            <div>
                <InputLabel for="password_confirmation" value="Confirm password" class="!font-semibold !text-[#234238]" />

                <div class="relative mt-2">
                    <TextInput
                        id="password_confirmation"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        class="block w-full !rounded-xl !border-[#E5EDE7] !bg-[#FAFCFA] !py-3 !pl-4 !pr-12 !text-sm focus:!border-[#08744D] focus:!ring-[#08744D]/10"
                        v-model="form.password_confirmation"
                        placeholder="Re-enter your password"
                        required
                        autocomplete="new-password"
                    />

                    <button
                        type="button"
                        @click="showConfirmPassword = !showConfirmPassword"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-[#08744D]"
                        :aria-label="showConfirmPassword ? 'Hide password' : 'Show password'"
                    >
                        <EyeOff v-if="showConfirmPassword" :size="18" />
                        <Eye v-else :size="18" />
                    </button>
                </div>

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- Submit -->
            <div class="pt-2">
                <PrimaryButton
                    class="!flex w-full !justify-center !rounded-xl !bg-[#07563A] !px-5 !py-3.5 !text-sm !font-bold !text-white shadow-lg shadow-emerald-950/10 transition hover:!bg-[#06452F] hover:shadow-xl"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    <span>{{ form.processing ? 'Creating account...' : 'Create my account' }}</span>
                    <ArrowRight class="ml-2" :size="18" />
                </PrimaryButton>
            </div>
        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Already have an account?
                <Link
                    :href="route('login')"
                    class="font-bold text-[#08744D] transition hover:text-[#FF7900]"
                >
                    Sign in
                </Link>
            </p>
        </div>

        <!-- Trust Footer -->
        <div class="mt-7 flex items-center justify-center gap-2 border-t border-[#EDF0EC] pt-5">
            <ShieldCheck :size="16" class="text-[#08744D]" />
            <span class="text-xs font-medium text-gray-400">
                Your information is kept secure.
            </span>
        </div>
    </GuestLayout>
</template>
