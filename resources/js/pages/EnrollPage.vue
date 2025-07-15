<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref, computed } from 'vue';

// Props from Laravel backend
const props = defineProps<{
    auth?: {
        user?: any;
    };
    course: {
        id: number;
        title_ar: string;
        title_en: string;
        slug: string;
        description_ar: string;
        description_en: string;
        price: number;
        preview_video_url: string;
        is_published: number;
        created_at: string;
        updated_at: string;
    };
    isEnrolled?: boolean;
}>();

// Payment form
const paymentForm = useForm({
    course_id: props.course.id,
    card_number: '',
    expiry_month: '',
    expiry_year: '',
    cvc: '',
    cardholder_name: '',
    email: props.auth?.user?.email || '',
});

// Reactive states
const focusedField = ref('');
const isCardFlipped = ref(false);

// Computed values
const originalPrice = computed(() => props.course.price * 1.5);
const discount = computed(() => originalPrice.value - props.course.price);
const discountPercentage = computed(() => Math.round((discount.value / originalPrice.value) * 100));

// Methods
const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
};

const processPayment = () => {
    paymentForm.post('/enroll-course', {
        onSuccess: () => {
            console.log('Payment successful');
        },
        onError: (errors) => {
            console.error('Payment failed:', errors);
        }
    });
};

// const getVideoEmbedUrl = (url: string) => {
//     if (url.includes('youtube.com') || url.includes('youtu.be')) {
//         const videoId = url.split('v=')[1]?.split('&')[0] || url.split('/').pop();
//         return `https://www.youtube.com/embed/${videoId}`;
//     }
//     if (url.includes('vimeo.com')) {
//         const videoId = url.split('/').pop();
//         return `https://player.vimeo.com/video/${videoId}`;
//     }
//     return url;
// };

const formatCardNumber = (event: Event) => {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
    const formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    paymentForm.card_number = formattedValue;
};

const formatExpiry = (event: Event) => {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    input.value = value;
    const [month, year] = value.split('/');
    paymentForm.expiry_month = month;
    paymentForm.expiry_year = year;
};

const handleFieldFocus = (field: string) => {
    focusedField.value = field;
    if (field === 'cvc') {
        isCardFlipped.value = true;
    } else {
        isCardFlipped.value = false;
    }
};

const handleFieldBlur = () => {
    focusedField.value = '';
    isCardFlipped.value = false;
};

const getCardType = (number: string) => {
    const cleaned = number.replace(/\s/g, '');
    if (cleaned.startsWith('4')) return 'visa';
    if (cleaned.startsWith('5') || cleaned.startsWith('2')) return 'mastercard';
    if (cleaned.startsWith('3')) return 'amex';
    return 'unknown';
};
</script>

<template>

    <Head :title="`Payment - ${course.title_en} - Barmaja Academy`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-indigo-900/20">
        <Navbar />

        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10 dark:from-blue-400/5 dark:to-purple-400/5">
            </div>
            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium mb-4">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Complete Your Enrollment
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Secure Your Spot in
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                            {{ course.title_en }}
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Join thousands of students and start your learning journey today
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div v-if="auth?.user" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="grid xl:grid-cols-5 gap-8">

                <!-- Course Preview - Larger -->
                <div class="xl:col-span-3 space-y-8">

                    <!-- Video Preview -->
                    <div
                        class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div class="relative">
                            <div class="aspect-video bg-gray-900 overflow-hidden">
                                <!-- <iframe :src="getVideoEmbedUrl(course.preview_video_url)" class="w-full h-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe> -->
                            </div>
                            <div class="p-8">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex text-yellow-400">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">(4.9/5 from 1,247
                                            reviews)</span>
                                    </div>
                                    <div
                                        class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-full text-sm font-medium">
                                        <i class="fas fa-users mr-1"></i>
                                        3,482 enrolled
                                    </div>
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                    {{ course.title_en }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                                    {{ course.description_en }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Course Features -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-star text-white"></i>
                            </div>
                            What's Included
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div
                                class="group flex items-center p-4 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-video text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white">25+ Hours Video</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">High-definition content</div>
                                </div>
                            </div>

                            <div
                                class="group flex items-center p-4 rounded-xl hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-infinity text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white">Lifetime Access</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Learn at your pace</div>
                                </div>
                            </div>

                            <div
                                class="group flex items-center p-4 rounded-xl hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-certificate text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white">Certificate</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Verified completion</div>
                                </div>
                            </div>

                            <div
                                class="group flex items-center p-4 rounded-xl hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-mobile-alt text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white">Mobile Access</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Learn anywhere</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section - Enhanced -->
                <div class="xl:col-span-2">
                    <div class="sticky top-8 space-y-6">

                        <!-- Pricing Card -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white">
                                <div class="text-center">
                                    <div class="text-sm opacity-90 mb-2">Special Launch Price</div>
                                    <div class="text-4xl font-bold mb-2">{{ formatPrice(course.price) }}</div>
                                    <div class="flex items-center justify-center space-x-2 text-blue-100">
                                        <span class="line-through text-lg">{{ formatPrice(originalPrice) }}</span>
                                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                                            Save {{ discountPercentage }}%
                                        </span>
                                    </div>
                                    <div class="mt-4 text-sm opacity-90">
                                        <i class="fas fa-clock mr-1"></i>
                                        Offer expires in 24 hours
                                    </div>
                                </div>
                            </div>

                            <!-- Virtual Credit Card -->
                            <div class="p-6">
                                <div class="mb-6">
                                    <div class="relative perspective-1000">
                                        <div :class="['card-container', { 'flipped': isCardFlipped }]">
                                            <!-- Card Front -->
                                            <div
                                                class="card-front bg-gradient-to-br from-gray-800 via-gray-900 to-black text-white rounded-xl p-6 shadow-2xl">
                                                <div class="flex justify-between items-start mb-8">
                                                    <div
                                                        class="w-12 h-8 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded">
                                                    </div>
                                                    <div class="text-right">
                                                        <div v-if="getCardType(paymentForm.card_number) === 'visa'"
                                                            class="text-2xl font-bold">VISA</div>
                                                        <div v-else-if="getCardType(paymentForm.card_number) === 'mastercard'"
                                                            class="text-2xl font-bold">MasterCard</div>
                                                        <div v-else class="w-8 h-8 border-2 border-white/30 rounded">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-6">
                                                    <div class="text-2xl font-mono tracking-wider">
                                                        {{ paymentForm.card_number || '•••• •••• •••• ••••' }}
                                                    </div>
                                                </div>
                                                <div class="flex justify-between items-end">
                                                    <div>
                                                        <div class="text-xs text-gray-300 mb-1">CARDHOLDER</div>
                                                        <div class="font-semibold">{{ paymentForm.cardholder_name ||
                                                            'YOUR NAME' }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-300 mb-1">EXPIRES</div>
                                                        <div class="font-semibold">{{ paymentForm.expiry_month || 'MM'
                                                        }}/{{ paymentForm.expiry_year || 'YY' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Back -->
                                            <div
                                                class="card-back bg-gradient-to-br from-gray-800 via-gray-900 to-black text-white rounded-xl p-6 shadow-2xl">
                                                <div class="w-full h-12 bg-gray-700 mt-6 mb-6"></div>
                                                <div class="flex justify-end">
                                                    <div class="bg-white text-black px-3 py-1 text-lg font-mono">{{
                                                        paymentForm.cvc || 'CVC' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Form -->
                                <form @submit.prevent="processPayment" class="space-y-4">

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                            Address</label>
                                        <div class="relative">
                                            <input v-model="paymentForm.email" type="email" required
                                                class="w-full pl-12 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 focus:shadow-lg focus:scale-[1.01]"
                                                placeholder="your@email.com" @focus="handleFieldFocus('email')"
                                                @blur="handleFieldBlur" />
                                            <i
                                                class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                    </div>

                                    <!-- Card Number -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Card
                                            Number</label>
                                        <div class="relative">
                                            <input v-model="paymentForm.card_number" @input="formatCardNumber"
                                                type="text" maxlength="19" required
                                                class="w-full pl-12 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 focus:shadow-lg focus:scale-[1.01]"
                                                placeholder="1234 1234 1234 1234"
                                                @focus="handleFieldFocus('card_number')" @blur="handleFieldBlur" />
                                            <i
                                                class="fas fa-credit-card absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                    </div>

                                    <!-- Expiry and CVC -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry
                                                Date</label>
                                            <input @input="formatExpiry" type="text" maxlength="5" required
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 focus:shadow-lg focus:scale-[1.01]"
                                                placeholder="MM/YY" @focus="handleFieldFocus('expiry')"
                                                @blur="handleFieldBlur" />
                                        </div>
                                        <div class="space-y-2">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">CVC</label>
                                            <input v-model="paymentForm.cvc" type="text" maxlength="4" required
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 focus:shadow-lg focus:scale-[1.01]"
                                                placeholder="123" @focus="handleFieldFocus('cvc')"
                                                @blur="handleFieldBlur" />
                                        </div>
                                    </div>

                                    <!-- Cardholder Name -->
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cardholder
                                            Name</label>
                                        <input v-model="paymentForm.cardholder_name" type="text" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 focus:shadow-lg focus:scale-[1.01]"
                                            placeholder="Full name on card" @focus="handleFieldFocus('cardholder_name')"
                                            @blur="handleFieldBlur" />
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" :disabled="paymentForm.processing"
                                        class="w-full relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed text-white py-4 px-6 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg group">
                                        <div
                                            class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                        </div>
                                        <div class="relative flex items-center justify-center">
                                            <i v-if="paymentForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                            <i v-else class="fas fa-lock mr-2"></i>
                                            {{ paymentForm.processing ? 'Processing...' : `Complete Payment
                                            ${formatPrice(course.price)}` }}
                                        </div>
                                    </button>
                                </form>

                                <!-- Security & Guarantee -->
                                <div class="mt-6 space-y-4">
                                    <div
                                        class="flex items-center justify-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                                        Secured by Stripe • SSL Encrypted
                                    </div>

                                    <div
                                        class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                                        <div
                                            class="flex items-center justify-center text-green-600 dark:text-green-400 mb-2">
                                            <i class="fas fa-shield-check mr-2"></i>
                                            <span class="font-semibold">30-Day Money Back Guarantee</span>
                                        </div>
                                        <p class="text-sm text-green-700 dark:text-green-300 text-center">
                                            Not satisfied? Get a full refund within 30 days, no questions asked.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Replace the existing v-else section with this -->
        <div v-else class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <!-- Left Column - Authentication Prompt -->
                <div class="space-y-8">
                    <div class="text-center lg:text-left">
                        <!-- Status Badge -->
                        <div
                            class="inline-flex items-center px-4 py-2 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 rounded-full text-sm font-medium mb-6">
                            <i class="fas fa-lock mr-2"></i>
                            Account Required
                        </div>

                        <!-- Main Heading -->
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            Join
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                Thousands
                            </span>
                            <br>of Learners
                        </h1>

                        <!-- Description -->
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                            Create your free account to access premium courses, track your progress, and join our
                            learning community.
                        </p>

                        <!-- Benefits List -->
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center">
                                <div
                                    class="w-6 h-6 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Lifetime access to all enrolled
                                    courses</span>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-6 h-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Track your learning progress and
                                    achievements</span>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-6 h-6 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Get verified certificates upon
                                    completion</span>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-6 h-6 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Join exclusive community
                                    discussions</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <Link href="/register"
                                class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg text-center">
                            <div
                                class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                            </div>
                            <div class="relative flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create Free Account
                            </div>
                            </Link>

                            <Link href="/login"
                                class="group bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white border-2 border-gray-300 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg text-center">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Sign In
                            </div>
                            </Link>
                        </div>

                        <!-- Social Proof -->
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <div
                                class="flex items-center justify-center lg:justify-start space-x-8 text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center">
                                    <i class="fas fa-users mr-2 text-blue-500"></i>
                                    <span>50K+ Students</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star mr-2 text-yellow-500"></i>
                                    <span>4.9/5 Rating</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-certificate mr-2 text-purple-500"></i>
                                    <span>25K+ Certificates</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Course Preview Card -->
                <div class="space-y-6">
                    <!-- Course Preview -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                        <!-- Video Preview -->
                        <div class="aspect-video bg-gray-900 relative overflow-hidden">
                            <iframe :src="getVideoEmbedUrl(course.preview_video_url)" class="w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                            <!-- Overlay -->
                            <div
                                class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <div class="text-white text-center">
                                    <i class="fas fa-lock text-3xl mb-2"></i>
                                    <p class="text-sm">Sign in to preview</p>
                                </div>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">(4.9/5)</span>
                                </div>
                                <div
                                    class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-full text-sm font-medium">
                                    <i class="fas fa-users mr-1"></i>
                                    3,482 enrolled
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                {{ course.title_en }}
                            </h3>

                            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                {{ course.description_en }}
                            </p>

                            <!-- Price -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ formatPrice(course.price) }}
                                    </span>
                                    <span class="text-lg text-gray-500 line-through">
                                        {{ formatPrice(originalPrice) }}
                                    </span>
                                    <span
                                        class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 px-2 py-1 rounded text-sm font-medium">
                                        {{ discountPercentage }}% OFF
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Indicators -->
                    <div
                        class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl p-6">
                        <h4 class="font-bold text-gray-900 dark:text-white mb-4 text-center">
                            <i class="fas fa-shield-check text-blue-500 mr-2"></i>
                            Why Choose Barmaja Academy?
                        </h4>

                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">24/7</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Support</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">30-Day</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Money Back</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">Lifetime</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Access</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">Expert</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Instructors</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom CTA Section -->
            <div class="mt-16 text-center">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 max-w-4xl mx-auto border border-gray-100 dark:border-gray-700">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Ready to Start Your Learning Journey?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Join our community of learners and get instant access to premium content
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link href="/register"
                            class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg">
                        <div
                            class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                        </div>
                        <div class="relative">Get Started Free</div>
                        </Link>
                        <Link href="/login"
                            class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-[1.02]">
                        Already have an account?
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.perspective-1000 {
    perspective: 1000px;
}

.card-container {
    position: relative;
    width: 100%;
    height: 200px;
    transform-style: preserve-3d;
    transition: transform 0.6s;
}

.card-container.flipped {
    transform: rotateY(180deg);
}

.card-front,
.card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 12px;
}

.card-back {
    transform: rotateY(180deg);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background-color: #f3f4f6;
}

::-webkit-scrollbar-track:dark {
    background-color: #1f2937;
}

::-webkit-scrollbar-thumb {
    background-color: #d1d5db;
    border-radius: 9999px;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #9ca3af;
}

/* Animation for features */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>