<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref, computed, onMounted, nextTick } from 'vue';

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
    stripeKey: string;
    setupIntent: {
        id: string;
        client_secret: string;
        status: string;
        [key: string]: any;
    };
}>();

// Payment form
const paymentForm = useForm({
    course_id: props.course.id,
    payment_method: '',
    cardholder_name: '',
    email: props.auth?.user?.email || '',
});

// Reactive states
const focusedField = ref('');
const isCardFlipped = ref(false);
const stripe = ref(null);
const elements = ref(null);
const cardElement = ref(null);
const cardErrors = ref('');
const isProcessing = ref(false);
const paymentSuccess = ref(false);

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

// Initialize Stripe
const initializeStripe = async () => {
    if (typeof window !== 'undefined' && window.Stripe) {
        stripe.value = window.Stripe(props.stripeKey);
        elements.value = stripe.value.elements();

        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        cardElement.value = elements.value.create('card', { style: style });

        await nextTick();

        const cardElementContainer = document.getElementById('card-element');
        if (cardElementContainer) {
            cardElement.value.mount('#card-element');

            // Listen for errors
            cardElement.value.on('change', ({ error }) => {
                if (error) {
                    cardErrors.value = error.message;
                } else {
                    cardErrors.value = '';
                }
            });
        }
    }
};

const processPayment = async () => {
    if (!stripe.value || !cardElement.value) {
        cardErrors.value = 'Payment system not initialized';
        return;
    }

    if (!paymentForm.cardholder_name.trim()) {
        cardErrors.value = 'Please enter cardholder name';
        return;
    }

    isProcessing.value = true;
    cardErrors.value = '';

    try {
        // Step 1: Create Payment Method
        const { error: pmError, paymentMethod } = await stripe.value.createPaymentMethod({
            type: 'card',
            card: cardElement.value,
            billing_details: {
                name: paymentForm.cardholder_name,
                email: paymentForm.email,
            },
        });

        if (pmError) {
            cardErrors.value = pmError.message;
            isProcessing.value = false;
            return;
        }

        // Step 2: Send to backend with payment method
        paymentForm.payment_method = paymentMethod.id;

        paymentForm.post('/enroll-course', {
            onSuccess: () => {
                paymentSuccess.value = true;
                console.log('Payment successful');
            },
            onError: (errors) => {
                console.error('Payment failed:', errors);
                cardErrors.value = 'Payment processing failed. Please try again.';
            },
            onFinish: () => {
                isProcessing.value = false;
            }
        });

    } catch (err) {
        console.error('Payment error:', err);
        cardErrors.value = 'An unexpected error occurred. Please try again.';
        isProcessing.value = false;
    }
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

// Load Stripe script and initialize
onMounted(async () => {
    if (!window.Stripe) {
        const script = document.createElement('script');
        script.src = 'https://js.stripe.com/v3/';
        script.onload = initializeStripe;
        document.head.appendChild(script);
    } else {
        await initializeStripe();
    }
});
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

        <!-- Success Message -->
        <div v-if="paymentSuccess" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md mx-4 text-center">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Payment Successful!</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    You have successfully enrolled in {{ course.title_en }}
                </p>
                <Link href="/dashboard"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                Go to Dashboard
                </Link>
            </div>
        </div>

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
        <div v-if="auth?.user && !isEnrolled" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
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
                                <!-- Video content here -->
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
                            <!-- Add other features as needed -->
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
                                </div>
                            </div>

                            <!-- Payment Form -->
                            <div class="p-6">
                                <form @submit.prevent="processPayment" class="space-y-4">

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                            Address</label>
                                        <div class="relative">
                                            <input v-model="paymentForm.email" type="email" required
                                                class="w-full pl-12 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200"
                                                placeholder="your@email.com" @focus="handleFieldFocus('email')"
                                                @blur="handleFieldBlur" />
                                            <i
                                                class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                    </div>

                                    <!-- Cardholder Name -->
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cardholder
                                            Name</label>
                                        <input v-model="paymentForm.cardholder_name" type="text" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200"
                                            placeholder="Full name on card" @focus="handleFieldFocus('cardholder_name')"
                                            @blur="handleFieldBlur" />
                                    </div>

                                    <!-- Stripe Card Element -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Card
                                            Details</label>
                                        <div
                                            class="border border-gray-300 dark:border-gray-600 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 bg-white dark:bg-gray-700 transition-all duration-200">
                                            <div id="card-element" class="p-4">
                                                <!-- Stripe Elements will create form elements here -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Error Display -->
                                    <div v-if="cardErrors" class="text-red-600 text-sm mt-2" id="card-errors">
                                        {{ cardErrors }}
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" :disabled="isProcessing"
                                        class="w-full relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed text-white py-4 px-6 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg group">
                                        <div
                                            class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                        </div>
                                        <div class="relative flex items-center justify-center">
                                            <i v-if="isProcessing" class="fas fa-spinner fa-spin mr-2"></i>
                                            <i v-else class="fas fa-lock mr-2"></i>
                                            {{ isProcessing ? 'Processing...' : `Complete Payment
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

        <!-- Already Enrolled Message -->
        <div v-else-if="auth?.user && isEnrolled" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-center">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">You're Already Enrolled!</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    You have access to this course. Continue your learning journey.
                </p>
                <Link href="/dashboard"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                Go to Course
                </Link>
            </div>
        </div>

        <!-- Not Authenticated Section -->
        <div v-else class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <!-- Your existing not authenticated content -->
        </div>
    </div>
</template>

<style scoped>
/* Stripe Elements styling */
#card-element {
    background: transparent;
}

.StripeElement {
    box-sizing: border-box;
    height: 40px;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
}

.StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
    border-color: #fa755a;
}

.StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
}

/* Dark mode support for Stripe Elements */
.dark .StripeElement {
    background-color: #374151;
    color: white;
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
</style>