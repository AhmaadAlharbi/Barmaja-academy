<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref } from 'vue';

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
        preview_video_url: string | null;
        is_published: number;
        created_at: string;
        updated_at: string;
        contents: Array<{
            id: number;
            course_id: number;
            title_ar: string;
            title_en: string;
            content_ar: string;
            content_en: string;
            video_url: string | null;
            sort_order: number;
            is_active: number;
            created_at: string;
            updated_at: string;
        }>;
        comments: Array<{
            id: number;
            user_name: string;
            comment: string;
            rating: number;
            created_at: string;
        }>;
    };
    isEnrolled?: boolean;
}>();

// Reactive data
const activeTab = ref('overview');
const newComment = ref('');
const newRating = ref(5);
const showVideo = ref(false);

// Enrollment form
const enrollForm = useForm({
    course_id: props.course.id,
});

// Methods
const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const toggleVideo = () => {
    showVideo.value = !showVideo.value;
};

const submitComment = () => {
    // Handle comment submission
    console.log('Comment:', newComment.value, 'Rating:', newRating.value);
    newComment.value = '';
    newRating.value = 5;
};

// Updated enrollment function
const enrollInCourse = () => {
    if (!props.auth?.user) {
        // Redirect to login page
        window.location.href = '/login';
        return;
    }

    enrollForm.get(`/enroll-course/${props.course.id}`, {
        onSuccess: () => {
            // Will be redirected by the controller
            console.log('Enrollment successful');
        },
        onError: (errors) => {
            console.error('Enrollment failed:', errors);
            // Handle validation errors if any
            if (errors.course_id) {
                alert('Invalid course selected.');
            } else {
                alert('Failed to enroll in course. Please try again.');
            }
        }
    });
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
};
</script>

<template>

    <Head :title="`${course.title_en} - Barmaja Academy`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <Navbar />

        <!-- Course Hero Section -->
        <section
            class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 pt-20 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-12 items-start">
                    <!-- Course Info -->
                    <div class="lg:col-span-2">
                        <!-- Breadcrumb -->
                        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-6">
                            <Link href="/" class="hover:text-blue-600 dark:hover:text-blue-400">Home</Link>
                            <i class="fas fa-chevron-right text-xs"></i>
                            <Link href="/courses" class="hover:text-blue-600 dark:hover:text-blue-400">Courses</Link>
                            <i class="fas fa-chevron-right text-xs"></i>
                            <span class="text-gray-900 dark:text-white">{{ course.title_en }}</span>
                        </nav>

                        <!-- Course Badge -->
                        <div class="flex items-center space-x-3 mb-4">
                            <span
                                class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium rounded-full">
                                {{ course.slug }}
                            </span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 dark:text-gray-400 ml-2 text-sm">4.8 (245 reviews)</span>
                            </div>
                        </div>

                        <!-- Course Title -->
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                            {{ course.title_en }}
                        </h1>

                        <!-- Course Meta -->
                        <div class="flex flex-wrap items-center gap-6 text-gray-600 dark:text-gray-400 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span>24h 30m total</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-play-circle mr-2"></i>
                                <span>{{ course.contents.length }} lessons</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                <span>1,234 students</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-globe mr-2"></i>
                                <span>English & Arabic</span>
                            </div>
                        </div>

                        <!-- Course Description -->
                        <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                            {{ course.description_en }}
                        </p>

                        <!-- Instructor Info -->
                        <div class="flex items-center p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=face"
                                alt="Instructor" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ahmed Khalil</h3>
                                <p class="text-gray-600 dark:text-gray-400">Senior Flutter Developer</p>
                                <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span>4.9 instructor rating</span>
                                    <span class="mx-2">•</span>
                                    <span>15 courses</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Sidebar -->
                    <!-- Replace the sidebar enrollment section (around line 125) with this -->
                    <div class="p-6">
                        <!-- Price -->
                        <div class="text-center mb-6">
                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ formatPrice(course.price) }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 line-through">
                                {{ formatPrice(course.price * 1.5) }}
                            </div>
                        </div>

                        <!-- Authentication Required or Enrollment Logic -->
                        <div v-if="!auth?.user">
                            <!-- Auth Required Section -->
                            <div class="space-y-6">
                                <!-- Status Badge -->
                                <div class="text-center">
                                    <div
                                        class="inline-flex items-center px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 rounded-full text-sm font-medium mb-4">
                                        <i class="fas fa-user-lock mr-2"></i>
                                        Account Required
                                    </div>
                                </div>

                                <!-- Main CTA -->
                                <div class="text-center space-y-3">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                        Join to Start Learning
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        Create your free account to enroll in this course
                                    </p>
                                </div>

                                <!-- Auth Buttons -->
                                <div class="space-y-3">
                                    <Link href="/register"
                                        class="w-full group relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center">
                                    <div
                                        class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                    </div>
                                    <div class="relative flex items-center">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Create Free Account
                                    </div>
                                    </Link>

                                    <Link href="/login"
                                        class="w-full border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Already Have Account?
                                    </Link>
                                </div>

                                <!-- Quick Benefits -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                    <h4 class="font-semibold text-blue-900 dark:text-blue-100 text-sm mb-3 text-center">
                                        🎯 Why Join Barmaja Academy?
                                    </h4>
                                    <div class="space-y-2 text-xs">
                                        <div class="flex items-center text-blue-800 dark:text-blue-200">
                                            <div
                                                class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                            <span>Free account creation</span>
                                        </div>
                                        <div class="flex items-center text-blue-800 dark:text-blue-200">
                                            <div
                                                class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                            <span>Track your learning progress</span>
                                        </div>
                                        <div class="flex items-center text-blue-800 dark:text-blue-200">
                                            <div
                                                class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                            <span>Get verified certificates</span>
                                        </div>
                                        <div class="flex items-center text-blue-800 dark:text-blue-200">
                                            <div
                                                class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                            <span>Join learning community</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enrolled Users -->
                        <div v-else-if="isEnrolled && auth?.user">
                            <Link :href="route('course.content', { course_id: course.id })"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-4 flex items-center justify-center">
                            <i class="fas fa-play-circle mr-2"></i>
                            Go to Course
                            </Link>
                            <div class="text-center text-green-600 dark:text-green-400 font-medium mb-4">
                                <i class="fas fa-check-circle mr-2"></i>
                                You are enrolled in this course!
                            </div>
                        </div>

                        <!-- Authenticated but Not Enrolled -->
                        <div v-else>
                            <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-4 flex items-center justify-center">
                                <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                <i v-else class="fas fa-shopping-cart mr-2"></i>
                                {{ enrollForm.processing ? 'Processing...' : 'Enroll Now' }}
                            </button>
                        </div>

                        <!-- Course Features (always show) -->
                        <div class="space-y-3 text-sm mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3">What's Included:</h4>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-infinity mr-3 text-blue-600"></i>
                                <span>Lifetime access</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-mobile-alt mr-3 text-blue-600"></i>
                                <span>Access on mobile and desktop</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-certificate mr-3 text-blue-600"></i>
                                <span>Certificate of completion</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-undo mr-3 text-blue-600"></i>
                                <span>30-day money-back guarantee</span>
                            </div>
                        </div>
                    </div>

                    <!-- Replace the curriculum tab section (around line 250) with this enhanced version -->
                    <div v-if="activeTab === 'curriculum'">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Course Curriculum</h2>

                        <!-- Course Stats -->
                        <div
                            class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-6 mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{
                                        course.contents.length }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Lessons</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">24h 30m</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Duration</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                        {{ isEnrolled ? course.contents.length : 0 }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Accessible</div>
                                </div>
                            </div>
                        </div>

                        <!-- Authentication Required Notice -->
                        <div v-if="!auth?.user" class="mb-8">
                            <div
                                class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-l-4 border-orange-400 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 bg-orange-100 dark:bg-orange-800 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user-lock text-orange-600 dark:text-orange-300"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-2">
                                            🔐 Account Required to View Curriculum
                                        </h3>
                                        <p class="text-orange-700 dark:text-orange-300 mb-4">
                                            Create your free account to explore the complete course curriculum and start
                                            your learning journey.
                                        </p>

                                        <!-- Benefits Grid -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                                            <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm">
                                                <i class="fas fa-check-circle mr-2 text-orange-500"></i>
                                                <span>Full curriculum access</span>
                                            </div>
                                            <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm">
                                                <i class="fas fa-check-circle mr-2 text-orange-500"></i>
                                                <span>Progress tracking</span>
                                            </div>
                                            <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm">
                                                <i class="fas fa-check-circle mr-2 text-orange-500"></i>
                                                <span>Interactive exercises</span>
                                            </div>
                                            <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm">
                                                <i class="fas fa-check-circle mr-2 text-orange-500"></i>
                                                <span>Certificate of completion</span>
                                            </div>
                                        </div>

                                        <!-- CTA Buttons -->
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <Link href="/register"
                                                class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-md">
                                            <i class="fas fa-user-plus mr-2"></i>
                                            Create Free Account
                                            </Link>
                                            <Link href="/login"
                                                class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-800 border-2 border-orange-300 dark:border-orange-600 text-orange-700 dark:text-orange-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 font-semibold rounded-lg transition-all duration-300">
                                            <i class="fas fa-sign-in-alt mr-2"></i>
                                            Sign In
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enrollment Notice for Authenticated Non-Enrolled Users -->
                        <div v-else-if="!isEnrolled" class="mb-8">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-6 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">
                                            Preview Mode
                                        </h3>
                                        <p class="text-blue-700 dark:text-blue-300 mt-1">
                                            You're viewing the course outline. Enroll to access all lessons and start
                                            learning.
                                        </p>
                                    </div>
                                    <div class="ml-6">
                                        <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                            class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300">
                                            <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                            <i v-else class="fas fa-play mr-2"></i>
                                            {{ enrollForm.processing ? 'Processing...' : 'Enroll Now' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Curriculum Content -->
                        <div v-if="!auth?.user" class="space-y-3">
                            <!-- Preview lessons for non-authenticated users -->
                            <div v-for="(content, index) in course.contents.slice(0, 3)" :key="content.id"
                                class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-800/50">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <!-- Left Side - Lesson Info -->
                                        <div class="flex items-center flex-1">
                                            <!-- Lesson Number -->
                                            <div
                                                class="flex-shrink-0 w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center mr-4 font-bold text-sm">
                                                {{ content.sort_order }}
                                            </div>

                                            <!-- Title and Description -->
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-1">
                                                    {{ content.title_en }}
                                                </h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-500 line-clamp-2">
                                                    {{ content.content_en.length > 120 ? content.content_en.substring(0,
                                                    120) + '...' : content.content_en }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Right Side - Lesson Meta -->
                                        <div class="flex items-center space-x-4 ml-6">
                                            <!-- Video Badge -->
                                            <div v-if="content.video_url"
                                                class="flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-play"></i>
                                                <span>Video</span>
                                            </div>

                                            <!-- Duration -->
                                            <div class="text-sm font-medium text-gray-400 dark:text-gray-500">
                                                15 min
                                            </div>

                                            <!-- Lock Icon -->
                                            <div
                                                class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                <i class="fas fa-lock text-gray-400 text-sm"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lock Notice -->
                                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                                <i class="fas fa-lock mr-2"></i>
                                                <span>Create account to access</span>
                                            </div>
                                            <Link href="/register"
                                                class="text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 font-medium text-sm transition-colors">
                                            <i class="fas fa-user-plus mr-1"></i>
                                            Sign Up
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- "More lessons" teaser -->
                            <div
                                class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center">
                                <div class="space-y-4">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto">
                                        <i class="fas fa-plus text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                            {{ course.contents.length - 3 }}+ More Lessons Available
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                                            Join thousands of students and unlock the complete curriculum
                                        </p>
                                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                            <Link href="/register"
                                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-[1.02]">
                                            <i class="fas fa-unlock mr-2"></i>
                                            Unlock All Lessons
                                            </Link>
                                            <Link href="/login"
                                                class="inline-flex items-center justify-center px-6 py-3 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                                            Already have an account?
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Full curriculum for authenticated users (existing logic) -->
                        <div v-else class="space-y-3">
                            <div v-for="(content, index) in course.contents" :key="content.id" :class="[
                                'border rounded-xl overflow-hidden transition-all duration-300 group',
                                isEnrolled
                                    ? 'border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md cursor-pointer bg-white dark:bg-gray-800'
                                    : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50'
                            ]">
                                <!-- Existing lesson item structure remains the same -->
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <!-- Left Side - Lesson Info -->
                                        <div class="flex items-center flex-1">
                                            <!-- Lesson Number -->
                                            <div :class="[
                                                'flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center mr-4 font-bold text-sm',
                                                isEnrolled
                                                    ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                                    : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                            ]">
                                                {{ content.sort_order }}
                                            </div>

                                            <!-- Title and Description -->
                                            <div class="flex-1">
                                                <h3 :class="[
                                                    'text-lg font-semibold mb-1',
                                                    isEnrolled
                                                        ? 'text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400'
                                                        : 'text-gray-600 dark:text-gray-400'
                                                ]">
                                                    {{ content.title_en }}
                                                </h3>
                                                <p :class="[
                                                    'text-sm line-clamp-2',
                                                    isEnrolled
                                                        ? 'text-gray-600 dark:text-gray-300'
                                                        : 'text-gray-500 dark:text-gray-500'
                                                ]">
                                                    {{ content.content_en.length > 120 ? content.content_en.substring(0,
                                                    120) + '...' : content.content_en }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Right Side - Lesson Meta -->
                                        <div class="flex items-center space-x-4 ml-6">
                                            <!-- Video Badge -->
                                            <div v-if="content.video_url" :class="[
                                                'flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-medium',
                                                isEnrolled
                                                    ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                                    : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                            ]">
                                                <i class="fas fa-play"></i>
                                                <span>Video</span>
                                            </div>

                                            <!-- Duration -->
                                            <div :class="[
                                                'text-sm font-medium',
                                                isEnrolled
                                                    ? 'text-gray-500 dark:text-gray-400'
                                                    : 'text-gray-400 dark:text-gray-500'
                                            ]">
                                                15 min
                                            </div>

                                            <!-- Status Icon -->
                                            <div class="flex items-center">
                                                <div v-if="isEnrolled"
                                                    class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                                    <i
                                                        class="fas fa-play text-green-600 dark:text-green-400 text-sm"></i>
                                                </div>
                                                <div v-else
                                                    class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enrolled: Action Button -->
                                    <div v-if="isEnrolled"
                                        class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <Link
                                            :href="route('course.content', { course_id: course.id, content_id: content.id })"
                                            class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm transition-colors">
                                        <i class="fas fa-arrow-right mr-2"></i>
                                        Start Lesson
                                        </Link>
                                    </div>

                                    <!-- Non-Enrolled: Lock Notice -->
                                    <div v-else class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                                <i class="fas fa-lock mr-2"></i>
                                                <span>Enroll to access this lesson</span>
                                            </div>
                                            <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm transition-colors disabled:opacity-50">
                                                <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin mr-1"></i>
                                                <i v-else class="fas fa-unlock mr-1"></i>
                                                {{ enrollForm.processing ? 'Processing...' : 'Unlock' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Enrollment Card for authenticated non-enrolled users -->
                        <div v-if="auth?.user && !isEnrolled" class="mt-12">
                            <div
                                class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-8 text-white text-center">
                                <div class="max-w-2xl mx-auto">
                                    <h3 class="text-2xl font-bold mb-4">
                                        🚀 Ready to Start Your Journey?
                                    </h3>
                                    <p class="text-indigo-100 mb-6 text-lg">
                                        Join {{ course.contents.length }} comprehensive lessons and build real-world
                                        skills that matter.
                                    </p>

                                    <!-- Features Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                        <div class="bg-white/10 rounded-lg p-4">
                                            <i class="fas fa-infinity text-2xl mb-2"></i>
                                            <div class="text-sm font-medium">Lifetime Access</div>
                                        </div>
                                        <div class="bg-white/10 rounded-lg p-4">
                                            <i class="fas fa-certificate text-2xl mb-2"></i>
                                            <div class="text-sm font-medium">Certificate</div>
                                        </div>
                                        <div class="bg-white/10 rounded-lg p-4">
                                            <i class="fas fa-mobile-alt text-2xl mb-2"></i>
                                            <div class="text-sm font-medium">Mobile Access</div>
                                        </div>
                                    </div>

                                    <!-- CTA Button -->
                                    <div
                                        class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                                        <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                            class="bg-white text-indigo-600 hover:bg-gray-100 disabled:bg-gray-300 disabled:cursor-not-allowed px-8 py-3 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                            <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                            <i v-else class="fas fa-rocket mr-2"></i>
                                            {{ enrollForm.processing ? 'Processing...' : `Enroll for
                                            ${formatPrice(course.price)}` }}
                                        </button>
                                        <div class="text-indigo-100 text-sm">
                                            <i class="fas fa-shield-alt mr-2"></i>
                                            30-day money-back guarantee
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom CTA for non-authenticated users -->
                        <div v-else-if="!auth?.user" class="mt-12">
                            <div
                                class="bg-gradient-to-br from-orange-400 via-red-400 to-pink-400 rounded-2xl p-8 text-white text-center">
                                <div class="max-w-2xl mx-auto">
                                    <div class="text-4xl mb-4">🎓</div>
                                    <h3 class="text-2xl font-bold mb-4">
                                        Ready to Transform Your Skills?
                                    </h3>
                                    <p class="text-orange-100 mb-6 text-lg">
                                        Join {{ course.contents.length }} comprehensive lessons and thousands of
                                        successful graduates.
                                    </p>

                                    <!-- Social Proof -->
                                    <div class="grid grid-cols-3 gap-6 mb-8">
                                        <div>
                                            <div class="text-2xl font-bold">50K+</div>
                                            <div class="text-orange-100 text-sm">Students</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold">4.9★</div>
                                            <div class="text-orange-100 text-sm">Rating</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold">25K+</div>
                                            <div class="text-orange-100 text-sm">Certificates</div>
                                        </div>
                                    </div>

                                    <!-- CTA Buttons -->
                                    <div
                                        class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                                        <Link href="/register"
                                            class="bg-white text-orange-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                        <i class="fas fa-rocket mr-2"></i>
                                        Start Learning for {{ formatPrice(course.price) }}
                                        </Link>
                                        <Link href="/login" class="text-orange-100 hover:text-white font-semibold">
                                        Already have an account?
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Course Content Tabs -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Tab Navigation -->
                        <div class="flex space-x-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg mb-8">
                            <button @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-md transition-all duration-200">
                                Overview
                            </button>
                            <button @click="activeTab = 'curriculum'"
                                :class="activeTab === 'curriculum' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-md transition-all duration-200">
                                Curriculum
                            </button>
                            <button @click="activeTab = 'reviews'"
                                :class="activeTab === 'reviews' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-md transition-all duration-200">
                                Reviews
                            </button>
                        </div>

                        <!-- Tab Content -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                            <!-- Overview Tab -->
                            <div v-if="activeTab === 'overview'">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Course Overview</h2>

                                <div class="prose dark:prose-invert max-w-none">
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                                        {{ course.description_en }}
                                    </p>

                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">What you'll
                                        learn</h3>
                                    <ul class="space-y-2 mb-6">
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                            <span class="text-gray-600 dark:text-gray-300">Build beautiful mobile apps
                                                for iOS and Android</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                            <span class="text-gray-600 dark:text-gray-300">Master Flutter widgets and
                                                layouts</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                            <span class="text-gray-600 dark:text-gray-300">Implement state management
                                                with Provider and Bloc</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                            <span class="text-gray-600 dark:text-gray-300">Integrate with Firebase for
                                                backend services</span>
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Prerequisites
                                    </h3>
                                    <ul class="space-y-2">
                                        <li class="flex items-start">
                                            <i class="fas fa-dot-circle text-blue-500 mr-3 mt-1 text-sm"></i>
                                            <span class="text-gray-600 dark:text-gray-300">Basic programming
                                                knowledge</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-dot-circle text-blue-500 mr-3 mt-1 text-sm"></i>
                                            <span class="text-gray-600 dark:text-gray-300">Familiarity with
                                                object-oriented programming</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Curriculum Tab -->
                            <!-- Curriculum Tab -->
                            <div v-if="activeTab === 'curriculum'">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Course Curriculum</h2>

                                <!-- Course Stats -->
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-6 mb-8">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{
                                                course.contents.length }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Lessons</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">24h 30m
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Duration</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{
                                                isEnrolled ? course.contents.length : 0 }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">Accessible</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enrollment Notice for Non-Enrolled Users -->
                                <div v-if="!isEnrolled"
                                    class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-6 mb-8">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">
                                                Preview Mode
                                            </h3>
                                            <p class="text-blue-700 dark:text-blue-300 mt-1">
                                                You're viewing the course outline. Enroll to access all lessons and
                                                start learning.
                                            </p>
                                        </div>
                                        <div class="ml-6">
                                            <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                                class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300">
                                                <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                                <i v-else class="fas fa-play mr-2"></i>
                                                {{ enrollForm.processing ? 'Processing...' : 'Enroll Now' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Curriculum Content -->
                                <div class="space-y-3">
                                    <div v-for="(content, index) in course.contents" :key="content.id" :class="[
                                        'border rounded-xl overflow-hidden transition-all duration-300 group',
                                        isEnrolled
                                            ? 'border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md cursor-pointer bg-white dark:bg-gray-800'
                                            : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50'
                                    ]">

                                        <!-- Lesson Item -->
                                        <div class="p-6">
                                            <div class="flex items-center justify-between">
                                                <!-- Left Side - Lesson Info -->
                                                <div class="flex items-center flex-1">
                                                    <!-- Lesson Number -->
                                                    <div :class="[
                                                        'flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center mr-4 font-bold text-sm',
                                                        isEnrolled
                                                            ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                                            : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                                    ]">
                                                        {{ content.sort_order }}
                                                    </div>

                                                    <!-- Title and Description -->
                                                    <div class="flex-1">
                                                        <h3 :class="[
                                                            'text-lg font-semibold mb-1',
                                                            isEnrolled
                                                                ? 'text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400'
                                                                : 'text-gray-600 dark:text-gray-400'
                                                        ]">
                                                            {{ content.title_en }}
                                                        </h3>
                                                        <p :class="[
                                                            'text-sm line-clamp-2',
                                                            isEnrolled
                                                                ? 'text-gray-600 dark:text-gray-300'
                                                                : 'text-gray-500 dark:text-gray-500'
                                                        ]">
                                                            {{ content.content_en.length > 120 ?
                                                                content.content_en.substring(0, 120) + '...' :
                                                                content.content_en }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Right Side - Lesson Meta -->
                                                <div class="flex items-center space-x-4 ml-6">
                                                    <!-- Video Badge -->
                                                    <div v-if="content.video_url" :class="[
                                                        'flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-medium',
                                                        isEnrolled
                                                            ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                                            : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                                    ]">
                                                        <i class="fas fa-play"></i>
                                                        <span>Video</span>
                                                    </div>

                                                    <!-- Duration -->
                                                    <div :class="[
                                                        'text-sm font-medium',
                                                        isEnrolled
                                                            ? 'text-gray-500 dark:text-gray-400'
                                                            : 'text-gray-400 dark:text-gray-500'
                                                    ]">
                                                        15 min
                                                    </div>

                                                    <!-- Status Icon -->
                                                    <div class="flex items-center">
                                                        <div v-if="isEnrolled"
                                                            class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                                            <i
                                                                class="fas fa-play text-green-600 dark:text-green-400 text-sm"></i>
                                                        </div>
                                                        <div v-else
                                                            class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Enrolled: Action Button -->
                                            <div v-if="isEnrolled"
                                                class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                                <Link
                                                    :href="route('course.content', { course_id: course.id, content_id: content.id })"
                                                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm transition-colors">
                                                <i class="fas fa-arrow-right mr-2"></i>
                                                Start Lesson
                                                </Link>
                                            </div>

                                            <!-- Non-Enrolled: Lock Notice -->
                                            <div v-else class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                                <div class="flex items-center justify-between">
                                                    <div
                                                        class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                                        <i class="fas fa-lock mr-2"></i>
                                                        <span>Enroll to access this lesson</span>
                                                    </div>
                                                    <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm transition-colors disabled:opacity-50">
                                                        <i v-if="enrollForm.processing"
                                                            class="fas fa-spinner fa-spin mr-1"></i>
                                                        <i v-else class="fas fa-unlock mr-1"></i>
                                                        {{ enrollForm.processing ? 'Processing...' : 'Unlock' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom Enrollment Card -->
                                <div v-if="!isEnrolled" class="mt-12">
                                    <div
                                        class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-8 text-white text-center">
                                        <div class="max-w-2xl mx-auto">
                                            <h3 class="text-2xl font-bold mb-4">
                                                🚀 Ready to Start Your Journey?
                                            </h3>
                                            <p class="text-indigo-100 mb-6 text-lg">
                                                Join {{ course.contents.length }} comprehensive lessons and build
                                                real-world skills that matter.
                                            </p>

                                            <!-- Features Grid -->
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                                <div class="bg-white/10 rounded-lg p-4">
                                                    <i class="fas fa-infinity text-2xl mb-2"></i>
                                                    <div class="text-sm font-medium">Lifetime Access</div>
                                                </div>
                                                <div class="bg-white/10 rounded-lg p-4">
                                                    <i class="fas fa-certificate text-2xl mb-2"></i>
                                                    <div class="text-sm font-medium">Certificate</div>
                                                </div>
                                                <div class="bg-white/10 rounded-lg p-4">
                                                    <i class="fas fa-mobile-alt text-2xl mb-2"></i>
                                                    <div class="text-sm font-medium">Mobile Access</div>
                                                </div>
                                            </div>

                                            <!-- CTA Button -->
                                            <div
                                                class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                                                <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                                    class="bg-white text-indigo-600 hover:bg-gray-100 disabled:bg-gray-300 disabled:cursor-not-allowed px-8 py-3 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                    <i v-if="enrollForm.processing"
                                                        class="fas fa-spinner fa-spin mr-2"></i>
                                                    <i v-else class="fas fa-rocket mr-2"></i>
                                                    {{ enrollForm.processing ? 'Processing...' : `Enroll for
                                                    ${formatPrice(course.price)}` }}
                                                </button>
                                                <div class="text-indigo-100 text-sm">
                                                    <i class="fas fa-shield-alt mr-2"></i>
                                                    30-day money-back guarantee
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews Tab -->
                            <div v-if="activeTab === 'reviews'">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Student Reviews</h2>

                                <!-- Reviews Summary -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="flex items-center mb-2">
                                                <span
                                                    class="text-4xl font-bold text-gray-900 dark:text-white mr-2">4.8</span>
                                                <div class="flex text-yellow-400">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300">Based on 245 reviews</p>
                                        </div>
                                        <div class="text-right">
                                            <button
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                                Write a Review
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Review Form -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave a Review
                                    </h3>

                                    <div class="mb-4">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                                        <div class="flex items-center space-x-1">
                                            <button v-for="star in 5" :key="star" @click="newRating = star"
                                                :class="star <= newRating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                                class="text-xl hover:text-yellow-400 transition-colors">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comment</label>
                                        <textarea v-model="newComment" rows="4"
                                            placeholder="Share your experience with this course..."
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>

                                    <button @click="submitComment"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                                        Submit Review
                                    </button>
                                </div>

                                <!-- Existing Reviews -->
                                <div class="space-y-6">
                                    <div v-if="course.comments.length === 0"
                                        class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        No reviews yet. Be the first to review this course!
                                    </div>

                                    <div v-for="comment in course.comments" :key="comment.id"
                                        class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                        <div class="flex items-start space-x-4">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face"
                                                alt="User" class="w-10 h-10 rounded-full">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{
                                                        comment.user_name }}</h4>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{
                                                        formatDate(comment.created_at) }}</span>
                                                </div>
                                                <div class="flex items-center mb-2">
                                                    <div class="flex text-yellow-400 mr-2">
                                                        <i v-for="star in 5" :key="star"
                                                            :class="star <= comment.rating ? 'fas fa-star' : 'far fa-star'"></i>
                                                    </div>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{
                                                        comment.rating }}/5</span>
                                                </div>
                                                <p class="text-gray-700 dark:text-gray-300">{{ comment.comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Related Courses -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Related Courses</h3>

                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=60&h=60&fit=crop"
                                        alt="Course" class="w-15 h-15 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-white text-sm">React Native
                                            Development</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">$29.99</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=60&h=60&fit=crop"
                                        alt="Course" class="w-15 h-15 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-white text-sm">iOS Development
                                            with Swift</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">$39.99</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Progress (if enrolled) -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Progress</h3>

                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                    <span>Completed</span>
                                    <span>{{ isEnrolled ? '0' : '0' }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ isEnrolled ? 'Start learning to track your progress!' :
                                    'Enroll to start tracking your progress through this course.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Modal -->
        <div v-if="showVideo && course.preview_video_url"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click="toggleVideo">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-4xl w-full" @click.stop>
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Course Preview</h3>
                    <button @click="toggleVideo" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="aspect-video bg-gray-900 rounded-lg flex items-center justify-center">
                        <p class="text-white">Video Player Placeholder</p>
                        <!-- You would embed your actual video player here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    max-width: none;
}

.prose h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
}

.prose ul {
    margin-top: 0.5rem;
    margin-bottom: 1rem;
}

.prose li {
    margin-top: 0.25rem;
    margin-bottom: 0.25rem;
}
</style>