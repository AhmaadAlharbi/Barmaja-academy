<script setup lang="ts">
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import Navbar from '@/components/Navbar.vue';

const page = usePage();

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
    filters?: {
        categories: Array<{
            id: number;
            name_ar: string;
            name_en: string;
        }>;
        levels: Array<string>;
        price_ranges: Array<{
            label: string;
            min: number;
            max: number;
        }>;
    };
    search?: string;
    category?: string;
    level?: string;
    sort?: string;
    price_range?: string;
}>();

// Get current locale and RTL detection
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');

// Get translations from props with comprehensive fallbacks
const translations = computed(() => page.props.translations?.courses || {});

// Comprehensive fallback translations
const fallbackTranslations = {
    page_title: isRTL.value ? 'جميع الدورات' : 'All Courses',
    page_subtitle: isRTL.value ? 'أكاديمية برمجة' : 'Barmaja Academy',

    hero: {
        title: isRTL.value ? 'جميع دورات' : 'All',
        title_highlight: isRTL.value ? 'البرمجة' : 'Programming',
        title_suffix: isRTL.value ? '' : 'Courses',
        subtitle: isRTL.value
            ? 'استكشف مجموعتنا الشاملة من دورات البرمجة المصممة لتأخذك من المبتدئ إلى الخبير'
            : 'Explore our comprehensive collection of programming courses designed to take you from beginner to expert',
    },

    search: {
        placeholder: isRTL.value ? 'ابحث في الدورات...' : 'Search courses...',
        results_showing: isRTL.value ? 'عرض :from-:to من :total دورة' : 'Showing :from-:to of :total courses',
        no_results: isRTL.value ? 'لم يتم العثور على دورات' : 'No courses found',
    },

    course: {
        new_badge: isRTL.value ? 'جديد' : 'New',
        preview_available: isRTL.value ? 'معاينة متاحة' : 'Preview Available',
        view_course: isRTL.value ? 'عرض الدورة' : 'View Course',
        enroll_now: isRTL.value ? 'اشترك الآن' : 'Enroll Now',
        students: isRTL.value ? 'طالب' : 'students',
        lessons: isRTL.value ? 'درس' : 'lessons',
        hours: isRTL.value ? 'ساعة' : 'hours',
    },

    view: {
        grid_view: isRTL.value ? 'عرض الشبكة' : 'Grid View',
        list_view: isRTL.value ? 'عرض القائمة' : 'List View',
    },

    pagination: {
        previous: isRTL.value ? 'السابق' : 'Previous',
        next: isRTL.value ? 'التالي' : 'Next',
        showing: isRTL.value ? 'عرض' : 'Showing',
        of: isRTL.value ? 'من' : 'of',
        results: isRTL.value ? 'نتيجة' : 'results',
    },

    empty_state: {
        title: isRTL.value ? 'لم يتم العثور على دورات' : 'No courses found',
        description: isRTL.value ? 'جرب تعديل معايير البحث أو تصفح جميع الدورات.' : 'Try adjusting your search criteria or browse all courses.',
        browse_all: isRTL.value ? 'تصفح جميع الدورات' : 'Browse All Courses',
    },
};

// Get translation with fallback
function getTranslation(path: string, fallback: string = '') {
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
}

// Helper function to get localized content
function getLocalizedContent(item: any, field: string) {
    return isRTL.value ? item[`${field}_ar`] : item[`${field}_en`];
}

// Course icon and gradient function
function getCourseIconAndGradient(course: any, index: number) {
    const iconMappings = {
        // Programming & Development
        'programming': { icon: 'fas fa-code', gradient: 'from-blue-500 to-purple-600' },
        'web-development': { icon: 'fas fa-globe', gradient: 'from-green-500 to-blue-500' },
        'mobile-development': { icon: 'fas fa-mobile-alt', gradient: 'from-purple-500 to-pink-500' },
        'backend-development': { icon: 'fas fa-server', gradient: 'from-gray-600 to-gray-800' },
        'frontend-development': { icon: 'fas fa-paint-brush', gradient: 'from-pink-500 to-rose-500' },
        'frontend-frameworks': { icon: 'fab fa-react', gradient: 'from-cyan-500 to-blue-500' },
        'javascript': { icon: 'fab fa-js-square', gradient: 'from-yellow-500 to-orange-500' },
        'python': { icon: 'fab fa-python', gradient: 'from-green-600 to-blue-600' },
        'react': { icon: 'fab fa-react', gradient: 'from-cyan-400 to-blue-500' },
        'vue': { icon: 'fab fa-vuejs', gradient: 'from-green-500 to-teal-500' },
        'angular': { icon: 'fab fa-angular', gradient: 'from-red-500 to-red-700' },
        'node': { icon: 'fab fa-node-js', gradient: 'from-green-600 to-green-800' },
        'php': { icon: 'fab fa-php', gradient: 'from-purple-600 to-indigo-600' },
        'laravel': { icon: 'fab fa-laravel', gradient: 'from-red-500 to-orange-500' },

        // Design & Creative
        'design': { icon: 'fas fa-palette', gradient: 'from-pink-500 to-purple-600' },
        'ui-ux': { icon: 'fas fa-drafting-compass', gradient: 'from-indigo-500 to-purple-600' },
        'graphic-design': { icon: 'fas fa-image', gradient: 'from-purple-500 to-pink-500' },
        'web-design': { icon: 'fas fa-paint-brush', gradient: 'from-blue-500 to-purple-500' },
        'photoshop': { icon: 'fas fa-camera', gradient: 'from-blue-600 to-indigo-600' },

        // Data & Analytics
        'data-science': { icon: 'fas fa-chart-line', gradient: 'from-emerald-500 to-teal-600' },
        'machine-learning': { icon: 'fas fa-brain', gradient: 'from-purple-600 to-blue-600' },
        'artificial-intelligence': { icon: 'fas fa-robot', gradient: 'from-gray-700 to-gray-900' },
        'database': { icon: 'fas fa-database', gradient: 'from-blue-600 to-indigo-700' },
        'database-design': { icon: 'fas fa-database', gradient: 'from-blue-600 to-indigo-700' },
        'analytics': { icon: 'fas fa-chart-pie', gradient: 'from-green-500 to-emerald-600' },

        // Business & Marketing
        'business': { icon: 'fas fa-briefcase', gradient: 'from-gray-600 to-blue-600' },
        'marketing': { icon: 'fas fa-bullhorn', gradient: 'from-orange-500 to-red-500' },
        'digital-marketing': { icon: 'fas fa-digital-tachograph', gradient: 'from-blue-500 to-purple-500' },
        'entrepreneurship': { icon: 'fas fa-rocket', gradient: 'from-green-500 to-blue-500' },
        'finance': { icon: 'fas fa-chart-line', gradient: 'from-green-600 to-emerald-700' },

        // Other Technologies
        'cybersecurity': { icon: 'fas fa-shield-alt', gradient: 'from-red-600 to-red-800' },
        'cloud': { icon: 'fas fa-cloud', gradient: 'from-sky-500 to-blue-600' },
        'devops': { icon: 'fas fa-cogs', gradient: 'from-orange-500 to-red-600' },
        'blockchain': { icon: 'fas fa-link', gradient: 'from-yellow-500 to-orange-600' },
        'game-development': { icon: 'fas fa-gamepad', gradient: 'from-purple-600 to-pink-600' },

        // Media & Content
        'photography': { icon: 'fas fa-camera', gradient: 'from-gray-600 to-gray-800' },
        'video-editing': { icon: 'fas fa-video', gradient: 'from-red-500 to-pink-500' },
        'music': { icon: 'fas fa-music', gradient: 'from-purple-500 to-indigo-600' },
        'writing': { icon: 'fas fa-pen', gradient: 'from-blue-500 to-indigo-600' },

        // Lifestyle
        'cooking': { icon: 'fas fa-utensils', gradient: 'from-orange-500 to-red-500' },
        'fitness': { icon: 'fas fa-dumbbell', gradient: 'from-green-500 to-emerald-600' },
        'language': { icon: 'fas fa-language', gradient: 'from-blue-500 to-purple-500' },
    };

    // Default gradients for fallback
    const defaultGradients = [
        'from-blue-500 to-purple-600',
        'from-green-500 to-teal-600',
        'from-purple-500 to-pink-600',
        'from-orange-500 to-red-500',
        'from-indigo-500 to-purple-600',
        'from-cyan-500 to-blue-500',
        'from-emerald-500 to-green-600',
        'from-rose-500 to-pink-600',
        'from-amber-500 to-orange-600',
        'from-violet-500 to-purple-600'
    ];

    // Try to match the course slug
    if (course.slug && iconMappings[course.slug]) {
        return iconMappings[course.slug];
    }

    // Fallback based on index
    const defaultIcons = [
        { icon: 'fas fa-graduation-cap', gradient: 'from-blue-500 to-purple-600' },
        { icon: 'fas fa-book', gradient: 'from-green-500 to-teal-600' },
        { icon: 'fas fa-laptop-code', gradient: 'from-purple-500 to-pink-600' },
        { icon: 'fas fa-chart-bar', gradient: 'from-orange-500 to-red-500' },
        { icon: 'fas fa-lightbulb', gradient: 'from-yellow-500 to-orange-500' },
        { icon: 'fas fa-cog', gradient: 'from-gray-600 to-gray-800' },
        { icon: 'fas fa-star', gradient: 'from-indigo-500 to-purple-600' },
        { icon: 'fas fa-trophy', gradient: 'from-amber-500 to-orange-600' },
        { icon: 'fas fa-fire', gradient: 'from-red-500 to-pink-500' },
        { icon: 'fas fa-magic', gradient: 'from-purple-600 to-indigo-600' }
    ];

    return defaultIcons[index % defaultIcons.length];
}

// State management
const isLoading = ref(false);
const showFilters = ref(false);
const searchQuery = ref(page.props.search || '');
const selectedCategory = ref(page.props.category || '');
const selectedLevel = ref(page.props.level || '');
const selectedPriceRange = ref(page.props.price_range || '');
const selectedSort = ref(page.props.sort || 'newest');

// Helper functions
function handleSearch() {
    applyFilters();
}

function applyFilters() {
    isLoading.value = true;

    const params = {
        search: searchQuery.value || undefined,
        category: selectedCategory.value || undefined,
        level: selectedLevel.value || undefined,
        price_range: selectedPriceRange.value || undefined,
        sort: selectedSort.value
    };

    // Remove empty parameters
    Object.keys(params).forEach(key => {
        if (!params[key]) delete params[key];
    });

    router.get(route('courses.index'), params, {
        preserveState: true,
        onFinish: () => {
            isLoading.value = false;
        }
    });
}

function clearFilters() {
    searchQuery.value = '';
    selectedCategory.value = '';
    selectedLevel.value = '';
    selectedPriceRange.value = '';
    selectedSort.value = 'newest';
    applyFilters();
}

// Watch for changes and apply filters
watch([selectedCategory, selectedLevel, selectedPriceRange, selectedSort], () => {
    applyFilters();
});
</script>

<template>

    <Head :title="`${getTranslation('page_title')} - ${getTranslation('page_subtitle')}`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <meta name="description" :content="getTranslation('hero.subtitle')" />
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300" :dir="isRTL ? 'rtl' : 'ltr'"
        :class="{ 'font-tajawal': isRTL }">

        <Navbar />

        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        {{ getTranslation('hero.title') }}
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                            {{ getTranslation('hero.title_highlight') }}
                        </span>
                        {{ getTranslation('hero.title_suffix') }}
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                        {{ getTranslation('hero.subtitle') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Courses Grid -->
                    <div class="lg:w-full">
                        <!-- Results Header -->
                        <div class="flex items-center justify-between mb-8">
                            <div :class="{ 'text-right': isRTL }">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ getTranslation('page_title') }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300 mt-1">
                                    {{ getTranslation('pagination.showing') }} {{ courses?.from || 0 }}-{{ courses?.to
                                        || 0 }}
                                    {{ getTranslation('pagination.of') }} {{ courses?.total || 0 }}
                                    {{ getTranslation('pagination.results') }}
                                </p>
                            </div>

                            <!-- View Toggle -->
                            <div class="flex items-center space-x-2" :class="{ 'space-x-reverse': isRTL }">
                                <button class="p-2 text-blue-600 bg-blue-50 dark:bg-blue-900/30 rounded-lg"
                                    :title="getTranslation('view.grid_view')">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button
                                    class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg"
                                    :title="getTranslation('view.list_view')">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div v-if="isLoading" class="grid md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                            <div v-for="i in 6" :key="i"
                                class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg">
                                <div class="skeleton h-48 w-full"></div>
                                <div class="p-6 space-y-4">
                                    <div class="skeleton h-4 w-3/4"></div>
                                    <div class="skeleton h-6 w-full"></div>
                                    <div class="skeleton h-4 w-1/2"></div>
                                    <div class="skeleton h-10 w-full"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Courses Grid -->
                        <div v-else-if="courses?.data?.length" class="grid md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                            <div v-for="(course, index) in courses?.data" :key="course.id"
                                class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">

                                <div class="relative">
                                    <!-- Icon Container with Gradient Background -->
                                    <div class="h-48 flex items-center justify-center relative overflow-hidden"
                                        :class="`bg-gradient-to-br ${getCourseIconAndGradient(course, index).gradient}`">

                                        <!-- Background Pattern -->
                                        <div class="absolute inset-0 opacity-10">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent">
                                            </div>
                                            <div class="absolute top-4 right-4 w-20 h-20 bg-white/10 rounded-full">
                                            </div>
                                            <div class="absolute bottom-6 left-6 w-16 h-16 bg-white/10 rounded-full">
                                            </div>
                                            <div
                                                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-white/5 rounded-full">
                                            </div>
                                        </div>

                                        <!-- Main Icon -->
                                        <div
                                            class="relative z-10 text-center group-hover:scale-110 transition-transform duration-300">
                                            <i :class="getCourseIconAndGradient(course, index).icon"
                                                class="text-6xl text-white mb-2 drop-shadow-lg"></i>
                                            <div class="text-white/90 text-sm font-medium uppercase tracking-wider">
                                                {{ course.slug?.replace('-', ' ') || 'Course' }}
                                            </div>
                                        </div>

                                        <!-- Course Badge -->
                                        <div class="absolute top-4 bg-black/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold"
                                            :class="isRTL ? 'left-4' : 'right-4'">
                                            {{ getTranslation('course.new_badge') }}
                                        </div>

                                        <!-- Preview Button -->
                                        <div v-if="course.preview_video_url"
                                            class="absolute bottom-4 bg-black/30 backdrop-blur-sm text-white px-3 py-1 rounded-lg text-sm"
                                            :class="isRTL ? 'right-4' : 'left-4'">
                                            <i class="fas fa-play" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                            {{ getTranslation('course.preview_available') }}
                                        </div>


                                    </div>
                                </div>

                                <div class="p-6">
                                    <!-- Course Category and Rating -->
                                    <div class="flex items-center justify-between mb-3">
                                        <span
                                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-medium rounded-full">
                                            {{ course.slug }}
                                        </span>
                                        <div class="flex items-center text-yellow-400"
                                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                            <i class="fas fa-star text-sm"></i>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">4.8</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-500">(245)</span>
                                        </div>
                                    </div>

                                    <!-- Course Title -->
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                        :class="{ 'text-right': isRTL }">
                                        {{ getLocalizedContent(course, 'title') }}
                                    </h3>

                                    <!-- View Course Button -->
                                    <div class="mb-4">
                                        <Link :href="route('frontend.show.course', { id: course.id })"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 group/btn"
                                            :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                                        <i class="fas fa-eye group-hover/btn:animate-pulse "></i>
                                        <span class="mx-2">{{ getTranslation('course.view_course') }}</span>

                                        </Link>
                                    </div>

                                    <!-- Course Description -->
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3"
                                        :class="{ 'text-right': isRTL }">
                                        {{ getLocalizedContent(course, 'description') }}
                                    </p>

                                    <!-- Course Meta Info -->
                                    <div
                                        class="flex items-center justify-between mb-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center"
                                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                            <i class="fas fa-clock"></i>
                                            <span>24{{ getTranslation('course.hours') }} 30m</span>
                                        </div>
                                        <div class="flex items-center"
                                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                            <i class="fas fa-users"></i>
                                            <span>1,234 {{ getTranslation('course.students') }}</span>
                                        </div>
                                        <div class="flex items-center"
                                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                            <i class="fas fa-play-circle"></i>
                                            <span>45 {{ getTranslation('course.lessons') }}</span>
                                        </div>
                                    </div>

                                    <!-- Instructor and Price -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center"
                                            :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                                            <!-- Instructor Avatar with Icon -->
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-white text-xs"></i>
                                            </div>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ isRTL ? 'أحمد خليل' : 'Ahmed Khalil' }}
                                            </span>
                                        </div>
                                        <div :class="{ 'text-left': isRTL }">
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                                ${{ course.price }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enroll Button -->
                                    <Link :href="route('enroll.page', { id: course.id })"
                                        class="w-full bg-gradient-to-br from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 px-6 rounded-lg font-bold text-lg tracking-wide shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-75 text-center block group/enroll">
                                    <i class="fas fa-graduation-cap group-hover/enroll:animate-bounce"
                                        :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                    {{ getTranslation('course.enroll_now') }}
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-16">
                            <div
                                class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                {{ getTranslation('empty_state.title') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">
                                {{ getTranslation('empty_state.description') }}
                            </p>
                            <button @click="clearFilters"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                {{ getTranslation('empty_state.browse_all') }}
                            </button>
                        </div>
                    </div>

                </div>
                <div v-if="courses && courses.last_page > 1"
                    class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-8">
                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        {{ getTranslation('pagination.showing') }} {{ courses.from }}-{{ courses.to }}
                        {{ getTranslation('pagination.of') }} {{ courses.total }} {{
                            getTranslation('pagination.results') }}
                    </div>

                    <div class="flex items-center space-x-2" :class="{ 'space-x-reverse': isRTL }">
                        <Link v-if="courses.prev_page_url" :href="courses.prev_page_url"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                        <i class="fas fa-chevron-left" :class="{ 'fas fa-chevron-right': isRTL }"></i>
                        <span>{{ getTranslation('pagination.previous') }}</span>
                        </Link>
                        <span v-else
                            class="px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-400 dark:text-gray-600 cursor-not-allowed"
                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                            <i class="fas fa-chevron-left" :class="{ 'fas fa-chevron-right': isRTL }"></i>
                            <span>{{ getTranslation('pagination.previous') }}</span>
                        </span>

                        <div class="flex items-center space-x-1" :class="{ 'space-x-reverse': isRTL }">
                            <template v-for="link in courses.links" :key="link.label">
                                <Link
                                    v-if="link.url && link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;'"
                                    :href="link.url" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                    :class="link.active
                                        ? 'bg-blue-600 text-white'
                                        : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                    v-html="link.label">
                                </Link>
                                <span v-else-if="link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;'"
                                    class="px-3 py-2 text-gray-400 dark:text-gray-600 text-sm" v-html="link.label">
                                </span>
                            </template>
                        </div>

                        <Link v-if="courses.next_page_url" :href="courses.next_page_url"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                        <span>{{ getTranslation('pagination.next') }}</span>
                        <i class="fas fa-chevron-right" :class="{ 'fas fa-chevron-left': isRTL }"></i>
                        </Link>
                        <span v-else
                            class="px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-400 dark:text-gray-600 cursor-not-allowed"
                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                            <span>{{ getTranslation('pagination.next') }}</span>
                            <i class="fas fa-chevron-right" :class="{ 'fas fa-chevron-left': isRTL }"></i>
                        </span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap');

.font-tajawal {
    font-family: 'Tajawal', sans-serif;
}

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

/* Skeleton loading animation */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 0.5rem;
}

.dark .skeleton {
    background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
    background-size: 200% 100%;
}

@keyframes loading {
    0% {
        background-position: -200% 0;
    }

    100% {
        background-position: 200% 0;
    }
}

/* RTL specific hover effects */
[dir="rtl"] .hover\:translate-x-1:hover {
    transform: translateX(-0.25rem);
}

[dir="rtl"] .hover\:-translate-x-1:hover {
    transform: translateX(-0.25rem);
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Custom gradient animations */
.bg-gradient-to-br {
    background-size: 200% 200%;
    animation: gradientShift 8s ease infinite;
}

@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}
</style>