<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
// Props that would come from your Laravel backend
defineProps<{
    auth?: {
        user?: any;
    };
    courses?: {
        data: Array<{
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
        }>;
        current_page: number;
        last_page: number;
        total: number;
        per_page: number;
        from: number;
        to: number;
        links: Array<any>;
        path: string;
        first_page_url: string;
        last_page_url: string;
        next_page_url: string | null;
        prev_page_url: string | null;
    };
}>();
</script>

<template>

    <Head title="All Courses - Barmaja Academy">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <Navbar />

        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        All
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                            Programming
                        </span>
                        Courses
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                        Explore our comprehensive collection of programming courses designed to take you from beginner
                        to expert
                    </p>

                    <!-- Course Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-2xl mx-auto">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ courses?.total || 0 }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Courses</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">10K+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Students</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">50+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Instructors</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">24/7</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search and Filters Section -->
        <section class="py-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-lg">
                        <div class="relative">
                            <input type="text" placeholder="Search courses..."
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-4">
                        <select
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <option>All Categories</option>
                            <option>Web Development</option>
                            <option>Mobile Development</option>
                            <option>Backend Development</option>
                            <option>Frontend Frameworks</option>
                        </select>

                        <select
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <option>All Levels</option>
                            <option>Beginner</option>
                            <option>Intermediate</option>
                            <option>Advanced</option>
                        </select>

                        <select
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <option>Sort by</option>
                            <option>Newest</option>
                            <option>Most Popular</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Sidebar Filters -->
                    <div class="lg:w-1/4 hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-24">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Filter Courses</h3>

                            <!-- Price Range -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Price Range</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Free</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">$1 - $50</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">$51 - $100</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">$100+</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Duration</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">0-2 hours</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">3-6 hours</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">7-17 hours</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">17+ hours</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Rating</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                            <div class="flex text-yellow-400 mr-1">
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                            </div>
                                            4.5 & up
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                            <div class="flex text-yellow-400 mr-1">
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="far fa-star text-xs"></i>
                                            </div>
                                            4.0 & up
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                            <div class="flex text-yellow-400 mr-1">
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="far fa-star text-xs"></i>
                                                <i class="far fa-star text-xs"></i>
                                            </div>
                                            3.0 & up
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Clear Filters -->
                            <button
                                class="w-full text-blue-600 dark:text-blue-400 text-sm font-medium hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                Clear all filters
                            </button>
                        </div>
                    </div>

                    <!-- Courses Grid -->
                    <div class="lg:w-full">
                        <!-- Results Header -->
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">All Courses</h2>
                                <p class="text-gray-600 dark:text-gray-300 mt-1">
                                    Showing {{ courses?.from || 0 }}-{{ courses?.to || 0 }} of {{ courses?.total || 0 }}
                                    courses
                                </p>
                            </div>

                            <!-- View Toggle -->
                            <div class="flex items-center space-x-2">
                                <button class="p-2 text-blue-600 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button
                                    class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Courses Grid -->
                        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                            <div v-for="course in courses?.data" :key="course.id"
                                class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">

                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop"
                                        alt="Course"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">

                                    <!-- Course Badge -->
                                    <div
                                        class="absolute top-4 right-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        New
                                    </div>

                                    <!-- Preview Button -->
                                    <div v-if="course.preview_video_url"
                                        class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm backdrop-blur-sm">
                                        <i class="fas fa-play mr-1"></i>
                                        Preview Available
                                    </div>

                                    <!-- Hover Overlay -->
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                        <Link :href="route('frontend.show.course', { id: course.id })"
                                            class="bg-white text-gray-900 px-4 py-2 rounded-lg font-semibold opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                        View Course
                                        </Link>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <!-- Course Category and Rating -->
                                    <div class="flex items-center justify-between mb-3">
                                        <span
                                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-medium rounded-full">
                                            {{ course.slug }}
                                        </span>
                                        <div class="flex items-center text-yellow-400">
                                            <i class="fas fa-star text-sm"></i>
                                            <span class="text-sm text-gray-600 dark:text-gray-400 ml-1">4.8</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-500 ml-1">(245)</span>
                                        </div>
                                    </div>

                                    <!-- Course Title -->
                                    <h3
                                        class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ course.title_en }}
                                    </h3>

                                    <!-- Course Description -->
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                        {{ course.description_en }}
                                    </p>

                                    <!-- Course Meta Info -->
                                    <div
                                        class="flex items-center justify-between mb-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            <span>24h 30m</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-users mr-1"></i>
                                            <span>1,234 students</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-play-circle mr-1"></i>
                                            <span>45 lessons</span>
                                        </div>
                                    </div>

                                    <!-- Instructor and Price -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face"
                                                alt="Instructor" class="w-8 h-8 rounded-full mr-2">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Ahmed Khalil</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">${{
                                                course.price }}</div>
                                        </div>
                                    </div>

                                    <!-- Enroll Button -->
                                    <button
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        Enroll Now
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-if="!courses?.data?.length" class="text-center py-16">
                            <div
                                class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No courses found</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">Try adjusting your search criteria or
                                browse all courses.</p>
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                Browse All Courses
                            </button>
                        </div>

                        <!-- Pagination -->
                        <div v-if="courses && courses.last_page > 1"
                            class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-8">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                Showing {{ courses.from }}-{{ courses.to }} of {{ courses.total }} results
                            </div>

                            <div class="flex items-center space-x-2">
                                <!-- Previous Button -->
                                <Link v-if="courses.prev_page_url" :href="courses.prev_page_url"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-chevron-left mr-1"></i>
                                Previous
                                </Link>
                                <span v-else
                                    class="px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-400 dark:text-gray-600 cursor-not-allowed">
                                    <i class="fas fa-chevron-left mr-1"></i>
                                    Previous
                                </span>

                                <!-- Page Numbers -->
                                <div class="flex items-center space-x-1">
                                    <template v-for="link in courses.links" :key="link.label">
                                        <Link
                                            v-if="link.url && link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;'"
                                            :href="link.url"
                                            class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                            :class="link.active
                                                ? 'bg-blue-600 text-white'
                                                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'" v-html="link.label">
                                        </Link>
                                        <span
                                            v-else-if="link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;'"
                                            class="px-3 py-2 text-gray-400 dark:text-gray-600 text-sm"
                                            v-html="link.label">
                                        </span>
                                    </template>
                                </div>

                                <!-- Next Button -->
                                <Link v-if="courses.next_page_url" :href="courses.next_page_url"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Next
                                <i class="fas fa-chevron-right ml-1"></i>
                                </Link>
                                <span v-else
                                    class="px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-400 dark:text-gray-600 cursor-not-allowed">
                                    Next
                                    <i class="fas fa-chevron-right ml-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                    Can't Find What You're Looking For?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Request a custom course or suggest topics you'd like to learn. We're always adding new content based
                    on
                    student feedback.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                        Request Course
                    </button>
                    <Link href="/contact"
                        class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    Contact Us
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold">Barmaja Academy</h3>
                        </div>
                        <p class="text-gray-400 mb-6">
                            Empowering aspiring programmers with comprehensive courses and hands-on projects to build
                            successful
                            careers in technology.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Quick Links</h4>
                        <ul class="space-y-3">
                            <li>
                                <Link href="/" class="text-gray-400 hover:text-white transition-colors">Home</Link>
                            </li>
                            <li>
                                <Link href="/courses" class="text-gray-400 hover:text-white transition-colors">Courses
                                </Link>
                            </li>
                            <li>
                                <Link href="/blog" class="text-gray-400 hover:text-white transition-colors">Blog</Link>
                            </li>
                            <li>
                                <Link href="/about" class="text-gray-400 hover:text-white transition-colors">About Us
                                </Link>
                            </li>
                            <li>
                                <Link href="/contact" class="text-gray-400 hover:text-white transition-colors">Contact
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Categories</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Web Development</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mobile
                                    Development</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Backend
                                    Development</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Frontend
                                    Frameworks</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Database Design</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Support</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Help Center</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of
                                    Service</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Refund Policy</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Student Support</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 mt-12">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm">
                            © 2024 Barmaja Academy. All rights reserved.
                        </p>
                        <div class="flex items-center space-x-6 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookies</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>