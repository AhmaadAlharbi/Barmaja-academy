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
        preview_video_url: string;
        is_published: number;
        created_at: string;
        updated_at: string;
    };
    isEnrolled?: boolean;
}>();

// Reactive data
const showFullDescription = ref(false);

// Enrollment form
const enrollForm = useForm({
    course_id: props.course.id,
});

// Methods
const getVideoEmbedUrl = (url: string) => {
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        const videoId = url.split('v=')[1]?.split('&')[0] || url.split('/').pop();
        return `https://www.youtube.com/embed/${videoId}`;
    }
    if (url.includes('vimeo.com')) {
        const videoId = url.split('/').pop();
        return `https://player.vimeo.com/video/${videoId}`;
    }
    return url;
};

const enrollInCourse = () => {
    if (!props.auth?.user) {
        // Redirect to login page
        window.location.href = '/login';
        return;
    }

    enrollForm.post('/enroll-course', {
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

    <Head :title="`Enroll in ${course.title_en} - Barmaja Academy`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <Navbar />

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-800 dark:to-blue-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        {{ course.title_en }}
                    </h1>
                    <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                        {{ course.description_en }}
                    </p>

                    <!-- Course Stats -->
                    <div class="flex flex-wrap justify-center items-center gap-6 text-blue-100">
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Self-paced learning</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-certificate mr-2"></i>
                            <span>Certificate included</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            <span>1,200+ students</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star mr-2"></i>
                            <span>4.8/5 rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Course Content -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Preview Video -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-play-circle text-blue-600 mr-2"></i>
                                Course Preview
                            </h2>
                        </div>
                        <div class="aspect-video">
                            <iframe :src="getVideoEmbedUrl(course.preview_video_url)" class="w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            About This Course
                        </h2>

                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                                {{ showFullDescription ? course.description_en : course.description_en.substring(0, 200)
                                    + '...' }}
                            </p>

                            <button v-if="course.description_en.length > 200"
                                @click="showFullDescription = !showFullDescription"
                                class="mt-4 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors">
                                {{ showFullDescription ? 'Show Less' : 'Read More' }}
                            </button>
                        </div>
                    </div>

                    <!-- What You'll Learn -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            What You'll Learn
                        </h2>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700 dark:text-gray-300">Master Python fundamentals for data
                                    science</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700 dark:text-gray-300">Work with pandas and NumPy
                                    libraries</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700 dark:text-gray-300">Create stunning data
                                    visualizations</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700 dark:text-gray-300">Build machine learning models</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700 dark:text-gray-300">Analyze real-world datasets</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                                <span class="text-gray-700 dark:text-gray-300">Deploy data science projects</span>
                            </div>
                        </div>
                    </div>

                    <!-- Course Features -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            <i class="fas fa-star text-blue-600 mr-2"></i>
                            Course Features
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-video text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">25+ Hours Video</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">High-quality video content</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-infinity text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Lifetime Access</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Learn at your own pace</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-code text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Hands-on Projects</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Real-world practice</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-headset text-orange-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Support</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Get help when needed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enrollment Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 sticky top-8">
                        <!-- Price -->
                        <div class="text-center mb-8">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ formatPrice(course.price) }}
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                <span class="line-through text-lg mr-2">${{ (course.price * 1.5).toFixed(2) }}</span>
                                <span
                                    class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-2 py-1 rounded text-sm font-medium">
                                    Save 33%
                                </span>
                            </div>
                        </div>

                        <!-- Enroll Button or Go to Course -->
                        <div v-if="isEnrolled && auth?.user">
                            <Link :href="route('course.content', { course_id: course.id })"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-4 px-6 rounded-lg font-bold text-lg transition-colors flex items-center justify-center mb-6">
                            <i class="fas fa-play-circle mr-2"></i>
                            Go to Course
                            </Link>
                            <div class="text-center text-green-600 dark:text-green-400 font-medium">
                                <i class="fas fa-check-circle mr-2"></i>
                                You are enrolled in this course!
                            </div>
                        </div>

                        <button v-else @click="enrollInCourse" :disabled="enrollForm.processing"
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white py-4 px-6 rounded-lg font-bold text-lg transition-colors flex items-center justify-center mb-6">
                            <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                            <i v-else class="fas fa-shopping-cart mr-2"></i>
                            {{ enrollForm.processing ? 'Processing...' : 'Enroll Now' }}
                        </button>

                        <!-- Login prompt for guests -->
                        <div v-if="!auth?.user"
                            class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="text-center">
                                <p class="text-blue-800 dark:text-blue-200 mb-3">
                                    New to Barmaja Academy?
                                </p>
                                <Link href="/register"
                                    class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                                Create an account
                                </Link>
                            </div>
                        </div>

                        <!-- Money Back Guarantee -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                                <i class="fas fa-shield-alt mr-2"></i>
                                <span class="font-semibold">30-Day Money Back Guarantee</span>
                            </div>

                            <!-- Includes -->
                            <div class="space-y-3">
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>25+ hours on-demand video</span>
                                </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Downloadable resources</span>
                                </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Full lifetime access</span>
                                </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Certificate of completion</span>
                                </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Access on mobile and TV</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.prose {
    max-width: none;
}
</style>