<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
// Props that would come from your Laravel backend
defineProps<{
    auth?: {
        user?: any;
    };
    featuredCourses?: Array<{
        id: number;
        title: string;
        description: string;
        price: number;
        image: string;
        instructor: string;
        rating: number;
        students: number;
        duration: string;
    }>;
    threeCourses?: Array<{
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
    threeBlogs?: Array<{
        id: number;
        author_id: number;
        title_ar: string;
        title_en: string;
        slug: string;
        content_ar: string;
        content_en: string;
        is_published: number;
        published_at: string;
        created_at: string;
        updated_at: string;
    }>;
    blogPosts?: Array<{
        id: number;
        title: string;
        excerpt: string;
        image: string;
        published_at: string;
        author: string;
    }>;
}>();
</script>

<template>

    <Head title="Barmaja Academy - Master Programming & Technology">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <!-- Navigation -->
        <Navbar />
        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 py-20 lg:py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Column -->
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            Master

                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                Programming
                            </span>
                            <br>
                            Build Your Future
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                            Join Barmaja Academy and learn programming from industry experts.
                            From web development to mobile apps, start coding your dreams today.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <Link href="/courses"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Explore Courses
                            </Link>
                            <button
                                class="border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-600 dark:hover:border-blue-400 px-8 py-4 rounded-lg text-lg font-semibold transition-all duration-300 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fas fa-play mr-2"></i>
                                Watch Demo
                            </button>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-8 mt-12 pt-12 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">10K+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Students</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">100+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Courses</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 dark:text-green-400">50+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Instructors</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Hero Image/Animation -->
                    <div class="relative">
                        <div
                            class="relative bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-8 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-2xl">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-code text-blue-600 dark:text-blue-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Complete JavaScript
                                            Course</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">From beginner to
                                            professional</p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Progress</span>
                                        <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">75%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full w-3/4"></div>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                        <span>12 of 16 lessons</span>
                                        <span>4h 30m left</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating elements -->
                        <div
                            class="absolute -top-4 -left-4 w-20 h-20 bg-yellow-400 rounded-full opacity-20 animate-pulse">
                        </div>
                        <div
                            class="absolute -bottom-4 -right-4 w-16 h-16 bg-pink-400 rounded-full opacity-20 animate-pulse delay-1000">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Courses Section -->
        <section class="py-20 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Featured Courses
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Discover our most popular courses taught by industry experts
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Course Card 1 -->
                    <div v-for="course in threeCourses" :key="course.id"
                        class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop"
                                alt="Course" class="w-full h-48 object-cover">
                            <div
                                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                Bestseller
                            </div>
                            <div
                                class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm">
                                <i class="fas fa-play mr-1"></i>
                                Preview Available
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                                    {{ course.slug }}</span>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star text-sm"></i>
                                    <span class="text-sm text-gray-600 dark:text-gray-400 ml-1">4.9</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ course.title_en }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                {{ course.description_en }}
                            </p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>24 hours</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-users mr-1"></i>
                                    <span>1,234 students</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">

                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">${{ course.price }}
                                    </div>
                                </div>
                            </div>
                            <button
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold mt-4 transition-colors">
                                Enroll Now
                            </button>
                        </div>
                    </div>


                </div>

                <div class="text-center mt-12">
                    <Link href="/courses"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                    View All Courses
                    <i class="fas fa-arrow-right ml-2"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Why Choose Barmaja Academy?
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        We provide everything you need to master programming and advance your career
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-video text-blue-600 dark:text-blue-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">High-Quality Videos</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Learn with crystal-clear HD videos with downloadable resources and lifetime access.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-purple-600 dark:text-purple-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Expert Instructors</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Learn from industry professionals with years of real-world experience and expertise.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-certificate text-green-600 dark:text-green-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Certificates</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Earn recognized certificates upon completion to showcase your new skills to employers.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-laptop-code text-yellow-600 dark:text-yellow-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Code Practice Labs</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Practice coding with our interactive labs and build real projects to strengthen your
                            programming
                            skills.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-headset text-red-600 dark:text-red-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">24/7 Support</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Get help whenever you need it with our dedicated support team and community forums.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-mobile-alt text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Mobile Learning</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Learn on the go with our mobile-optimized platform accessible on any device.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section class="py-20 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Latest from Our Blog
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Stay updated with the latest trends, tips, and insights from the tech world
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Blog Post 1 -->
                    <article v-for="blog in threeBlogs" :key="blog.id"
                        class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=400&h=250&fit=crop"
                            alt="Blog post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span>Tech Trends</span>
                                <span class="mx-2">•</span>
                                <span>Jan 15, 2024</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                                {{ blog.title_en }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                {{ blog.content_en }}
                            </p>
                            <div class="flex items-center justify-between">

                                <Link href="/blog/1"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
                                Read More →
                                </Link>
                            </div>
                        </div>
                    </article>

                </div>

                <div class="text-center mt-12">
                    <Link href="/blog"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                    View All Posts
                    <i class="fas fa-arrow-right ml-2"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                    Ready to Start Your Programming Journey?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of students at Barmaja Academy who are building amazing applications and advancing
                    their
                    careers through code.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link href="/courses"
                        class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    Browse Courses
                    </Link>
                    <Link href="/register"
                        class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    Sign Up Free
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
                            <li>
                                <Link href="/careers" class="text-gray-400 hover:text-white transition-colors">Careers
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
/* Add custom styles if needed */
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