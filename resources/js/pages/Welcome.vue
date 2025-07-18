<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Navbar from '@/components/Navbar.vue';

// Get page props
const page = usePage();

// Props that come from your Laravel backend
defineProps<{
    auth?: {
        user?: any;
    };
    translations?: any; // Translation object from Laravel (optional)
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
}>();

// Get current locale from middleware
const currentLocale = computed(() => {
    return page.props.locale?.current || 'en';
});

// Get translations from props (from controller)
const translations = computed(() => {
    return page.props.translations?.home || {};
});

// Fallback translations
const fallbackTranslations = {
    hero: {
        title: 'Master',
        subtitle: 'Programming',
        description: 'Join Barmaja Academy and learn programming from industry experts.',
        explore_courses: 'Explore Courses',
        watch_demo: 'Watch Demo',
        stats: {
            students: 'Students',
            courses: 'Courses',
            instructors: 'Instructors'
        }
    },
    featured_courses: {
        title: 'Featured Courses',
        subtitle: 'Discover our most popular courses',
        bestseller: 'Bestseller',
        preview_available: 'Preview Available',
        enroll_now: 'Enroll Now',
        view_all: 'View All Courses',
        hours: 'hours',
        students: 'students'
    },
    features: {
        title: 'Why Choose Barmaja Academy?',
        subtitle: 'We provide everything you need to master programming',
        items: {
            videos: {
                title: 'High-Quality Videos',
                description: 'Learn with crystal-clear HD videos.'
            },
            instructors: {
                title: 'Expert Instructors',
                description: 'Learn from industry professionals.'
            },
            certificates: {
                title: 'Certificates',
                description: 'Earn recognized certificates upon completion.'
            },
            labs: {
                title: 'Code Practice Labs',
                description: 'Practice coding with interactive labs.'
            },
            support: {
                title: '24/7 Support',
                description: 'Get help whenever you need it.'
            },
            mobile: {
                title: 'Mobile Learning',
                description: 'Learn on the go with our mobile platform.'
            }
        }
    },
    blog: {
        title: 'Latest from Our Blog',
        subtitle: 'Stay updated with the latest trends',
        tech_trends: 'Tech Trends',
        read_more: 'Read More',
        view_all: 'View All Posts'
    },
    cta: {
        title: 'Ready to Start Your Programming Journey?',
        subtitle: 'Join thousands of students building amazing applications.',
        browse_courses: 'Browse Courses',
        sign_up_free: 'Sign Up Free'
    },
    footer: {
        description: 'Empowering aspiring programmers with comprehensive courses.',
        quick_links: 'Quick Links',
        categories: 'Categories',
        support: 'Support',
        copyright: '© 2024 Barmaja Academy. All rights reserved.',
        links: {
            courses: 'Courses',
            blog: 'Blog',
            about: 'About Us',
            contact: 'Contact',
            careers: 'Careers',
            help_center: 'Help Center',
            privacy_policy: 'Privacy Policy',
            terms_of_service: 'Terms of Service',
            refund_policy: 'Refund Policy',
            student_support: 'Student Support',
            privacy: 'Privacy',
            terms: 'Terms',
            cookies: 'Cookies'
        },
        categories_list: {
            web_development: 'Web Development',
            mobile_development: 'Mobile Development',
            backend_development: 'Backend Development',
            frontend_frameworks: 'Frontend Frameworks',
            database_design: 'Database Design'
        }
    }
};

// Get translation with fallback
const getTranslation = (path: string, fallback: string = '') => {
    const keys = path.split('.');
    let value = translations.value;

    for (const key of keys) {
        if (value && typeof value === 'object' && key in value) {
            value = value[key];
        } else {
            // Use fallback translation
            let fallbackValue = fallbackTranslations;
            for (const fallbackKey of keys) {
                if (fallbackValue && typeof fallbackValue === 'object' && fallbackKey in fallbackValue) {
                    fallbackValue = fallbackValue[fallbackKey];
                } else {
                    return fallback;
                }
            }
            return fallbackValue;
        }
    }

    return value || fallback;
};

// Helper function to get localized content
const getLocalizedContent = (item: any, field: string, locale: string) => {
    return locale === 'ar' ? item[`${field}_ar`] : item[`${field}_en`];
};
</script>

<template>

    <Head :title="`${translations.hero.title} - Barmaja Academy`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
        :dir="locale === 'ar' ? 'rtl' : 'ltr'">
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
                            {{ translations.hero.title }}
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                {{ translations.hero.subtitle }}
                            </span>
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                            {{ translations.hero.description }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <Link href="/courses"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            {{ translations.hero.explore_courses }}
                            </Link>
                            <button
                                class="border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-600 dark:hover:border-blue-400 px-8 py-4 rounded-lg text-lg font-semibold transition-all duration-300 hover:text-blue-600 dark:hover:text-blue-400">
                                <i class="fas fa-play mr-2"></i>
                                {{ translations.hero.watch_demo }}
                            </button>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-8 mt-12 pt-12 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">10K+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{
                                    translations.hero.stats.students }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">100+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{
                                    translations.hero.stats.courses }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 dark:text-green-400">50+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{
                                    translations.hero.stats.instructors }}</div>
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
                        {{ translations.featured_courses.title }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        {{ translations.featured_courses.subtitle }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Course Card -->
                    <div v-for="course in threeCourses" :key="course.id"
                        class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop"
                                alt="Course" class="w-full h-48 object-cover">
                            <div
                                class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ translations.featured_courses.bestseller }}
                            </div>
                            <div
                                class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm">
                                <i class="fas fa-play mr-1"></i>
                                {{ translations.featured_courses.preview_available }}
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                                    {{ course.slug }}
                                </span>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star text-sm"></i>
                                    <span class="text-sm text-gray-600 dark:text-gray-400 ml-1">4.9</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ getLocalizedContent(course, 'title', locale) }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                {{ getLocalizedContent(course, 'description', locale) }}
                            </p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>24 {{ translations.featured_courses.hours }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-users mr-1"></i>
                                    <span>1,234 {{ translations.featured_courses.students }}</span>
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
                                {{ translations.featured_courses.enroll_now }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <Link href="/courses"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                    {{ translations.featured_courses.view_all }}
                    <i class="fas fa-arrow-right ml-2"
                        :class="{ 'ml-2': locale === 'en', 'mr-2': locale === 'ar' }"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ translations.features.title }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        {{ translations.features.subtitle }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature Cards -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-video text-blue-600 dark:text-blue-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{
                            translations.features.items.videos.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ translations.features.items.videos.description }}
                        </p>
                    </div>

                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-purple-600 dark:text-purple-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{
                            translations.features.items.instructors.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{
                            translations.features.items.instructors.description }}</p>
                    </div>

                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-certificate text-green-600 dark:text-green-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{
                            translations.features.items.certificates.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{
                            translations.features.items.certificates.description }}</p>
                    </div>

                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-laptop-code text-yellow-600 dark:text-yellow-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{
                            translations.features.items.labs.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ translations.features.items.labs.description }}
                        </p>
                    </div>

                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-headset text-red-600 dark:text-red-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{
                            translations.features.items.support.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ translations.features.items.support.description
                            }}</p>
                    </div>

                    <div class="text-center group">
                        <div
                            class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-mobile-alt text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{
                            translations.features.items.mobile.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ translations.features.items.mobile.description }}
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
                        {{ translations.blog.title }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        {{ translations.blog.subtitle }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Blog Post -->
                    <article v-for="blog in threeBlogs" :key="blog.id"
                        class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=400&h=250&fit=crop"
                            alt="Blog post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span>{{ translations.blog.tech_trends }}</span>
                                <span class="mx-2">•</span>
                                <span>Jan 15, 2024</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                                {{ getLocalizedContent(blog, 'title', locale) }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                {{ getLocalizedContent(blog, 'content', locale).substring(0, 150) }}...
                            </p>
                            <div class="flex items-center justify-between">
                                <Link :href="`/blog/${blog.slug}`"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
                                {{ translations.blog.read_more }} →
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>

                <div class="text-center mt-12">
                    <Link href="/blog"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                    {{ translations.blog.view_all }}
                    <i class="fas fa-arrow-right ml-2"
                        :class="{ 'ml-2': locale === 'en', 'mr-2': locale === 'ar' }"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                    {{ translations.cta.title }}
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    {{ translations.cta.subtitle }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link href="/courses"
                        class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    {{ translations.cta.browse_courses }}
                    </Link>
                    <Link href="/register"
                        class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    {{ translations.cta.sign_up_free }}
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
                            {{ translations.footer.description }}
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
                        <h4 class="text-lg font-semibold mb-6">{{ translations.footer.quick_links }}</h4>
                        <ul class="space-y-3">
                            <li>
                                <Link href="/courses" class="text-gray-400 hover:text-white transition-colors">
                                {{ translations.footer.links.courses }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/blog" class="text-gray-400 hover:text-white transition-colors">
                                {{ translations.footer.links.blog }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/about" class="text-gray-400 hover:text-white transition-colors">
                                {{ translations.footer.links.about }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/contact" class="text-gray-400 hover:text-white transition-colors">
                                {{ translations.footer.links.contact }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/careers" class="text-gray-400 hover:text-white transition-colors">
                                {{ translations.footer.links.careers }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">{{ translations.footer.categories }}</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.categories_list.web_development }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.categories_list.mobile_development }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.categories_list.backend_development }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.categories_list.frontend_frameworks }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.categories_list.database_design }}</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">{{ translations.footer.support }}</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.links.help_center }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.links.privacy_policy }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.links.terms_of_service }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.links.refund_policy }}</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{
                                translations.footer.links.student_support }}</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 mt-12">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm">
                            {{ translations.footer.copyright }}
                        </p>
                        <div class="flex items-center space-x-6 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">{{
                                translations.footer.links.privacy }}</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">{{
                                translations.footer.links.terms }}</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">{{
                                translations.footer.links.cookies }}</a>
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