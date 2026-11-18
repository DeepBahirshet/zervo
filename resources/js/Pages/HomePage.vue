
    <script setup>
    import { Head } from '@inertiajs/vue3';
    import Header from '@/Components/Layouts/Header.vue';
    import { ref } from 'vue';
    import ZervoChat from '@/Components/AI/ZervoChat.vue';
    import FeaturedRequirements from '@/Components/Requirements/FeaturedRequirements.vue';

    import {
        Droplets,
        Zap,
        Hammer,
        Paintbrush,
        Snowflake,
        Sparkles,
        ShieldCheck,
        House,
        Sprout,
        Truck,
        ClipboardList,
        UsersRound,
        Handshake,
        Star,
        MapPin,
        IndianRupee,
        ArrowRight,
        Clock3,
        Instagram,
        Linkedin,
        Heart,
        CheckCircle2,
    } from 'lucide-vue-next';

    const props = defineProps({
    featuredRequirements: {
        type: Array,
            default: () => [],
        },
    });
    

    const categories = [
        { icon: Droplets, name: 'Plumbing', description: 'Pipes, taps and water repairs', color: 'orange' },
        { icon: Zap, name: 'Electrical', description: 'Wiring, switches and lighting', color: 'green' },
        { icon: Hammer, name: 'Carpentry', description: 'Furniture and woodwork', color: 'orange' },
        { icon: Paintbrush, name: 'Painting', description: 'Interior and exterior painting', color: 'green' },
        { icon: Snowflake, name: 'AC & Appliances', description: 'AC and appliance servicing', color: 'orange' },
        { icon: Sparkles, name: 'Home Cleaning', description: 'Deep cleaning and home care', color: 'green' },
        { icon: ShieldCheck, name: 'Pest Control', description: 'Pest prevention and treatment', color: 'orange' },
        { icon: House, name: 'Home Renovation', description: 'Repairs and improvements', color: 'green' },
        { icon: Sprout, name: 'Gardening', description: 'Garden and outdoor maintenance', color: 'orange' },
        { icon: Truck, name: 'Moving Services', description: 'Packing and house shifting', color: 'green' },
    ];

    const steps = [
        {
            number: '01',
            icon: ClipboardList,
            title: 'Post Your Requirement',
            description: 'Describe what you need, your location and preferred date.',
        },
        {
            number: '02',
            icon: UsersRound,
            title: 'Get Proposals',
            description: 'Receive proposals from relevant local professionals.',
        },
        {
            number: '03',
            icon: Handshake,
            title: 'Choose & Get It Done',
            description: 'Compare options, select a provider and get your work done.',
        },
    ];

    const benefits = [
        {
            icon: ShieldCheck,
            title: 'Verified Professionals',
            description: 'Find trusted service providers with genuine profiles.',
        },
        {
            icon: Star,
            title: 'Real Reviews',
            description: 'Make confident decisions based on customer feedback.',
        },
        {
            icon: MapPin,
            title: 'Local & Convenient',
            description: 'Discover professionals serving your area.',
        },
        {
            icon: IndianRupee,
            title: 'Transparent Pricing',
            description: 'Compare proposals and choose what fits your budget.',
        },
    ];

    const footerGroups = [
        {
            title: 'Explore',
            links: [
                { label: 'Home', href: '/' },
                { label: 'Services', href: '#services' },
                { label: 'How it works', href: '#how-it-works' },
            ],
        },
        {
            title: 'Account',
            links: [
                { label: 'Sign in', href: '/login' },
                { label: 'Create account', href: '/register' },
                { label: 'Become a provider', href: '/register' },
            ],
        },
        {
            title: 'Support',
            links: [
                { label: 'Contact us', href: 'mailto:support@zervo.in' },
                { label: 'Help center', href: '#' },
                { label: 'Privacy policy', href: '#' },
            ],
        },
    ];

    const selectedService = ref('');

    function selectService(service) {
        selectedService.value = service;

        document.getElementById('assistant')?.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
        });
    }
    </script>

    <template>
        <Head title="Zervo | Home Services Made Simple" />

        <div class="min-h-screen overflow-hidden bg-[#FFF9F0] text-[#172B25]">
            <Header />

            <!-- HERO -->
            <section class="hero-section relative isolate overflow-hidden mb-12">
                <div class="hero-glow hero-glow-one"></div>
                <div class="hero-glow hero-glow-two"></div>

                <div class="absolute -right-32 bottom-[-200px] h-[450px] w-[450px] rounded-full bg-[#FF7900]/70 blur-[2px]"></div>

                <div class="relative mx-auto grid max-w-[1400px] items-center gap-8 px-6 py-6 lg:grid-cols-[0.95fr_1.05fr] lg:px-12 lg:py-8">

                    <!-- Hero content -->
                    <div class="relative z-10 text-white">

                       <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/[0.08] px-4 py-2.5 text-xs font-semibold text-[#FFD18A] shadow-lg shadow-black/5 backdrop-blur-xl">
                            <Sparkles :size="16" class="text-[#FF9B38]" />
                            Your Local Services, Simplified
                        </div>

                        <h1 class="mt-7 max-w-2xl text-5xl font-extrabold leading-[1.08] tracking-tight sm:text-6xl xl:text-7xl">
                            Find Trusted
                            <br />
                            Local Service
                            <br />
                            <span class="text-[#FF850D]">Professionals.</span>
                        </h1>

                        <p class="mt-7 max-w-xl text-lg leading-8 text-white/75 sm:text-xl">
                            Describe what you need, and Zervo AI will understand
                            your requirement, suggest the right professionals,
                            and help you get it done — quickly and reliably.
                        </p>

                        <!-- Hero benefits -->
                        <div class="mt-10 space-y-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.08] text-[#FF9B38] backdrop-blur">
                                    <Zap :size="22" />
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">AI-Assisted Requests</h3>
                                    <p class="mt-1 text-sm text-white/60">Describe your needs in simple words.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.08] text-[#FF9B38] backdrop-blur">
                                    <ShieldCheck :size="22" />
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">Trusted Professionals</h3>
                                    <p class="mt-1 text-sm text-white/60">Connect with skilled local providers.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.08] text-[#FF9B38] backdrop-blur">
                                    <Clock3 :size="22" />
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">Quick Responses</h3>
                                    <p class="mt-1 text-sm text-white/60">Get proposals from relevant professionals.</p>
                                </div>
                            </div>
                        </div>

                        <!-- CTA buttons -->
                        <div class="mt-10 flex flex-wrap gap-4">
                            <a
                                href="/requirements/create"
                                class="inline-flex items-center gap-3 rounded-xl bg-[#FF7900] px-7 py-4 font-bold text-white shadow-lg shadow-orange-950/25 transition duration-300 hover:-translate-y-1 hover:bg-[#F36B00] hover:shadow-xl"
                            >
                                Post a Requirement
                            </a>

                            <a
                                href="#services"
                                class="inline-flex items-center gap-3 rounded-xl border border-white/25 bg-white/[0.04] px-7 py-4 font-semibold text-white backdrop-blur transition duration-300 hover:border-white/50 hover:bg-white/10"
                            >
                                Explore Services
                            </a>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-5 text-xs font-medium text-white/55">
                            <span class="flex items-center gap-2">
                                <CheckCircle2 :size="15" class="text-[#FF9B38]" />
                                Simple booking process
                            </span>
                            <span class="flex items-center gap-2">
                                <CheckCircle2 :size="15" class="text-[#FF9B38]" />
                                Local professionals
                            </span>
                        </div>
                    </div>

                    <!-- Existing interactive chat -->
                    <div class="relative z-10" id="assistant">
                        <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-br from-[#FF7900]/25 via-white/10 to-emerald-300/20 blur-3xl"></div>

                        <div class="relative rounded-[2rem] border border-white/50 bg-[#FFF8EF]/95 p-2 shadow-[0_30px_100px_rgba(0,0,0,0.3)] backdrop-blur-xl">
                            <ZervoChat :initial-service="selectedService" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- FEATURED LOCAL REQUIREMENTS -->
            <FeaturedRequirements :requirements="props.featuredRequirements" />

            <!-- SERVICES -->
            <section id="services" class="relative py-24">
                <div class="pointer-events-none absolute -right-32 top-0 h-96 w-96 rounded-full bg-orange-200/30 blur-[100px]"></div>

                <div class="relative mx-auto max-w-[1400px] px-6 lg:px-12">

                    <div class="mb-12 flex flex-col justify-between gap-5 md:flex-row md:items-end">
                        <div>
                            <span class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[0.2em] text-[#D66A00]">
                                <span class="h-1.5 w-6 rounded-full bg-[#F47700]"></span>
                                Explore our services
                            </span>

                            <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-[#123E2E] md:text-5xl">
                                Home Services
                                <br class="sm:hidden" />
                                You Can <span class="text-[#F47700]">Rely On.</span>
                            </h2>

                            <p class="mt-4 max-w-xl text-lg leading-7 text-gray-500">
                                Choose from a wide range of home services
                                offered by local professionals.
                            </p>
                        </div>

                        <a
                            href="/register"
                            class="inline-flex items-center gap-2 font-bold text-[#0C6246] transition hover:text-[#F47700]"
                        >
                            View all services
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                        <button
                            v-for="category in categories"
                            :key="category.name"
                            type="button"
                            @click="selectService(category.name)"
                            class="service-card group relative w-full overflow-hidden rounded-2xl border border-[#EDE4D8] bg-white p-5 text-left shadow-sm transition duration-300 hover:-translate-y-2 hover:border-[#F47700]/40 hover:shadow-[0_18px_45px_rgba(25,70,48,0.10)] sm:p-6"
                        >
                            <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-[#FF7900]/5 transition-transform duration-500 group-hover:scale-[2]"></div>

                            <div
                                class="relative flex h-14 w-14 items-center justify-center rounded-2xl transition duration-300 group-hover:scale-110 group-hover:rotate-3"
                                :class="category.color === 'orange'
                                    ? 'bg-orange-50 text-[#E87500] ring-1 ring-orange-100'
                                    : 'bg-emerald-50 text-[#08744D] ring-1 ring-emerald-100'"
                            >
                                <component :is="category.icon" :size="27" :stroke-width="1.8" />
                            </div>

                            <h3 class="relative mt-5 text-base font-bold text-[#123E2E] sm:text-lg">
                                {{ category.name }}
                            </h3>

                            <p class="relative mt-2 min-h-10 text-xs leading-5 text-gray-500 sm:text-sm">
                                {{ category.description }}
                            </p>

                            <div class="relative mt-5 flex items-center justify-between">
                                <span class="text-xs font-bold text-[#0C6246]">Explore service</span>
                            </div>
                        </button>
                    </div>
                </div>
            </section>

            <!-- HOW IT WORKS -->
            <section id="how-it-works" class="px-6 pb-20 lg:px-12"> 
                <div class="relative mx-auto max-w-[1400px] overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#003D2D] via-[#064B35] to-[#003528] px-7 py-14 text-white shadow-xl sm:px-12">

                    <div class="pointer-events-none absolute -right-20 -top-32 h-80 w-80 rounded-full bg-[#FF7900]/20 blur-[100px]"></div>
                    <div class="pointer-events-none absolute -bottom-32 -left-20 h-72 w-72 rounded-full bg-emerald-400/10 blur-[90px]"></div>

                    <div class="relative grid gap-10 lg:grid-cols-[0.8fr_2fr] lg:items-center">
                        <div>
                            <span class="text-sm font-bold uppercase tracking-widest text-[#FFB45D]">
                                Simple process
                            </span>

                            <h2 class="mt-4 text-4xl font-extrabold">
                                How <span class="text-[#FF850D]">Zervo</span> Works?
                            </h2>

                            <p class="mt-4 max-w-xs leading-7 text-white/70">
                                Get your home tasks done in three simple steps.
                            </p>
                        </div>

                        <div class="grid gap-8 md:grid-cols-3">
                            <div
                                v-for="step in steps"
                                :key="step.number"
                                class="group text-center"
                            >
                                <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-full border border-[#FF7900]/30 bg-white/[0.08] text-[#FFAB4D] shadow-lg shadow-black/10 transition duration-300 group-hover:scale-110 group-hover:border-[#FF7900]/60 group-hover:bg-[#FF7900]/15">
                                    <component :is="step.icon" :size="32" :stroke-width="1.7" />
                                </div>

                                <p class="mt-5 text-xs font-bold tracking-widest text-[#FFB45D]">
                                    STEP {{ step.number }}
                                </p>

                                <h3 class="mt-2 text-lg font-bold">
                                    {{ step.title }}
                                </h3>

                                <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-white/65">
                                    {{ step.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- WHY ZERVO -->
            <section class="py-16">
                <div class="mx-auto max-w-[1400px] px-6 lg:px-12">

                    <div class="text-center">
                        <span class="text-sm font-bold uppercase tracking-widest text-[#D66A00]">
                            The Zervo difference
                        </span>

                        <h2 class="mt-4 text-4xl font-extrabold text-[#123E2E]">
                            Why Choose <span class="text-[#F47700]">Zervo?</span>
                        </h2>

                        <p class="mx-auto mt-4 max-w-xl leading-7 text-gray-500">
                            A simpler way to find the right people for your home.
                        </p>
                    </div>

                    <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4 cursor-pointer">
                        <div
                            v-for="benefit in benefits"
                            :key="benefit.title"
                            class="group flex gap-4 rounded-2xl border border-transparent p-5 transition duration-300 hover:-translate-y-1 hover:border-[#EDE4D8] hover:bg-white hover:shadow-[0_15px_40px_rgba(25,70,48,0.07)]"
                        >
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-orange-50 text-[#E87500] ring-1 ring-orange-100 transition duration-300 group-hover:bg-[#FF7900] group-hover:text-white group-hover:ring-[#FF7900]">
                                <component :is="benefit.icon" :size="25" :stroke-width="1.8" />
                            </div>

                            <div>
                                <h3 class="font-bold text-[#123E2E]">
                                    {{ benefit.title }}
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-gray-500">
                                    {{ benefit.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="px-6 py-16 lg:px-12">
                <div class="relative mx-auto max-w-[1400px] overflow-hidden rounded-[2rem] bg-gradient-to-r from-[#003D2D] via-[#07563A] to-[#003D2D] px-8 py-12 text-white shadow-xl md:px-16">

                    <div class="absolute -right-20 -top-32 h-72 w-72 rounded-full bg-[#FF7900]/30 blur-[90px]"></div>
                    <div class="absolute -bottom-32 left-1/3 h-64 w-64 rounded-full bg-emerald-400/10 blur-[90px]"></div>

                    <div class="relative flex flex-col items-center justify-between gap-8 md:flex-row">
                        <div>
                            <span class="text-sm font-bold uppercase tracking-widest text-[#FFB45D]">
                                Your home, taken care of
                            </span>

                            <h2 class="mt-3 text-3xl font-extrabold md:text-4xl">
                                Need a home service now?
                            </h2>

                            <p class="mt-4 max-w-xl text-white/70">
                                Post your requirement and connect with trusted
                                local professionals.
                            </p>
                        </div>

                        <a
                            href="/requirements/create"
                            class="inline-flex shrink-0 items-center gap-3 rounded-xl bg-[#FF7900] px-8 py-4 font-bold text-white shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:bg-[#F36B00] hover:shadow-xl"
                        >
                            Post a Requirement
                        </a>
                    </div>
                </div>
            </section>

            <!-- FOOTER -->
            <footer class="relative overflow-hidden bg-[#002F25] text-white">
                <div class="pointer-events-none absolute -right-20 -top-40 h-96 w-96 rounded-full bg-[#087E55]/20 blur-[100px]"></div>

                <div class="relative mx-auto max-w-[1400px] px-6 pb-8 pt-16 lg:px-12">
                    <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">

                        <div>
                            <a href="/" class="text-4xl font-extrabold tracking-tight">
                                <span class="text-[#FF7900]">Z</span>ervo<span class="text-[#FF7900]">.</span>
                            </a>

                            <p class="mt-5 max-w-sm leading-7 text-white/60">
                                Your local home services marketplace.
                                Find trusted professionals and get your
                                everyday home needs taken care of.
                            </p>

                            <div class="mt-6 flex gap-3">
                                <a
                                    href="#"
                                    aria-label="Instagram"
                                    class="social-link"
                                >
                                    <Instagram :size="18" />
                                </a>

                                <a
                                    href="#"
                                    aria-label="LinkedIn"
                                    class="social-link"
                                >
                                    <Linkedin :size="18" />
                                </a>
                            </div>
                        </div>

                        <div v-for="group in footerGroups" :key="group.title">
                            <h3 class="font-bold text-white">{{ group.title }}</h3>

                            <ul class="mt-6 space-y-4">
                                <li v-for="link in group.links" :key="link.label">
                                    <a
                                        :href="link.href"
                                        class="text-sm text-white/60 transition hover:text-[#FF9B38]"
                                    >
                                        {{ link.label }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-16 flex flex-col justify-between gap-4 border-t border-white/10 pt-7 text-sm text-white/50 sm:flex-row">
                        <p>© {{ new Date().getFullYear() }} Zervo. All rights reserved.</p>

                        <p class="inline-flex items-center gap-1.5">
                            Made with
                            <Heart :size="14" class="fill-[#FF7900] text-[#FF7900]" />
                            in Kolhapur.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </template>

    <style scoped>
    .hero-section {
        background:
            radial-gradient(ellipse at 15% 80%, rgba(9, 113, 67, 0.45), transparent 40%),
            linear-gradient(120deg, #002F24 0%, #00432E 55%, #003326 100%);
    }

    .hero-glow {
        position: absolute;
        pointer-events: none;
        border-radius: 9999px;
        filter: blur(90px);
    }

    .hero-glow-one {
        width: 350px;
        height: 350px;
        top: -150px;
        left: 35%;
        background: rgba(255, 121, 0, 0.12);
    }

    .hero-glow-two {
        width: 350px;
        height: 350px;
        bottom: -200px;
        left: -100px;
        background: rgba(8, 126, 85, 0.35);
    }

    .service-card {
        transform-style: preserve-3d;
    }

    .service-card:focus-visible {
        outline: 3px solid #F47700;
        outline-offset: 4px;
    }

    .social-link {
        display: flex;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #FF7900;
        color: white;
        transform: translateY(-3px);
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
        }
    }
    </style>
