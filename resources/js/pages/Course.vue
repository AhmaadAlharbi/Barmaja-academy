<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref } from 'vue';

// Props from Laravel backend
defineProps<{
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
}>();

// Reactive data
const activeTab = ref('overview');
const newComment = ref('');
const newRating = ref(5);
const showVideo = ref(false);

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

const enrollInCourse = () => {
    // Handle course enrollment/purchase
    console.log('Enrolling in course:', course.id);
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
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden sticky top-24">
                            <!-- Course Preview -->
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop"
                                    alt="Course Preview" class="w-full h-48 object-cover">

                                <!-- Preview Button -->
                                <div v-if="course.preview_video_url"
                                    class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                                    <button @click="toggleVideo"
                                        class="bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full p-4 transition-all duration-300 transform hover:scale-110">
                                        <i class="fas fa-play text-2xl text-blue-600"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="p-6">
                                <!-- Price -->
                                <div class="text-center mb-6">
                                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                        ${{ course.price }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 line-through">$99.99</div>
                                </div>

                                <!-- Enroll Button -->
                                <button @click="enrollInCourse"
                                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-4">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Enroll Now
                                </button>

                                <!-- Add to Wishlist -->
                                <button
                                    class="w-full border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 py-3 rounded-lg font-semibold transition-all duration-300 mb-6">
                                    <i class="fas fa-heart mr-2"></i>
                                    Add to Wishlist
                                </button>

                                <!-- Course Features -->
                                <div class="space-y-3 text-sm">
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
                            <div v-if="activeTab === 'curriculum'">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Course Curriculum</h2>

                                <div class="space-y-4">
                                    <div v-for="(content, index) in course.contents" :key="content.id"
                                        class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                        <Link :href="route('frontend.showContent', { contetnt_id: content.id })">

                                        <div class="p-4 bg-gray-50 dark:bg-gray-700">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <span
                                                        class="text-sm font-medium text-gray-500 dark:text-gray-400 mr-3">
                                                        Lesson {{ content.sort_order }}
                                                    </span>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ content.title_en }}
                                                    </h3>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span v-if="content.video_url"
                                                        class="text-blue-600 dark:text-blue-400">
                                                        <i class="fas fa-play-circle mr-1"></i>
                                                        Video
                                                    </span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">15 min</span>
                                                </div>
                                            </div>

                                            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm line-clamp-2">
                                                {{ content.content_en.substring(0, 150) }}...
                                            </p>
                                        </div>
                                        </Link>
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
                                    <span>0%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Enroll to start tracking your progress through this course.
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