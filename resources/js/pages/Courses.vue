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
        stats: {
            total_courses: isRTL.value ? 'إجمالي الدورات' : 'Total Courses',
            students: isRTL.value ? 'طالب' : 'Students',
            instructors: isRTL.value ? 'مدرس' : 'Instructors',
            support: isRTL.value ? 'دعم' : 'Support',
        },
    },

    search: {
        placeholder: isRTL.value ? 'ابحث في الدورات...' : 'Search courses...',
        results_showing: isRTL.value ? 'عرض :from-:to من :total دورة' : 'Showing :from-:to of :total courses',
        no_results: isRTL.value ? 'لم يتم العثور على دورات' : 'No courses found',
    },

    filters: {
        all_categories: isRTL.value ? 'جميع الفئات' : 'All Categories',
        all_levels: isRTL.value ? 'جميع المستويات' : 'All Levels',
        sort_by: isRTL.value ? 'ترتيب حسب' : 'Sort by',
        clear_all: isRTL.value ? 'مسح جميع المرشحات' : 'Clear all filters',
        filter_courses: isRTL.value ? 'تصفية الدورات' : 'Filter Courses',
        price_range: isRTL.value ? 'نطاق السعر' : 'Price Range',
        duration: isRTL.value ? 'المدة' : 'Duration',
        rating: isRTL.value ? 'التقييم' : 'Rating',
    },

    categories: {
        web_development: isRTL.value ? 'تطوير الويب' : 'Web Development',
        mobile_development: isRTL.value ? 'تطوير تطبيقات الجوال' : 'Mobile Development',
        backend_development: isRTL.value ? 'تطوير الخلفية' : 'Backend Development',
        frontend_frameworks: isRTL.value ? 'إطارات العمل الأمامية' : 'Frontend Frameworks',
        database_design: isRTL.value ? 'تصميم قواعد البيانات' : 'Database Design',
    },

    levels: {
        beginner: isRTL.value ? 'مبتدئ' : 'Beginner',
        intermediate: isRTL.value ? 'متوسط' : 'Intermediate',
        advanced: isRTL.value ? 'متقدم' : 'Advanced',
        expert: isRTL.value ? 'خبير' : 'Expert',
    },

    sort: {
        newest: isRTL.value ? 'الأحدث' : 'Newest',
        most_popular: isRTL.value ? 'الأكثر شعبية' : 'Most Popular',
        price_low_high: isRTL.value ? 'السعر: من الأقل للأعلى' : 'Price: Low to High',
        price_high_low: isRTL.value ? 'السعر: من الأعلى للأقل' : 'Price: High to Low',
    },

    price: {
        free: isRTL.value ? 'مجاني' : 'Free',
        range_1_50: isRTL.value ? '$١ - $٥٠' : '$1 - $50',
        range_51_100: isRTL.value ? '$٥١ - $١٠٠' : '$51 - $100',
        range_100_plus: isRTL.value ? '$١٠٠+' : '$100+',
    },

    duration: {
        short: isRTL.value ? '٠-٢ ساعة' : '0-2 hours',
        medium: isRTL.value ? '٣-٦ ساعات' : '3-6 hours',
        long: isRTL.value ? '٧-١٧ ساعة' : '7-17 hours',
        very_long: isRTL.value ? '١٧+ ساعة' : '17+ hours',
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

    cta: {
        title: isRTL.value ? 'لا تجد ما تبحث عنه؟' : 'Can\'t Find What You\'re Looking For?',
        subtitle: isRTL.value
            ? 'اطلب دورة مخصصة أو اقترح مواضيع تود تعلمها. نحن نضيف دائماً محتوى جديد بناءً على ملاحظات الطلاب.'
            : 'Request a custom course or suggest topics you\'d like to learn. We\'re always adding new content based on student feedback.',
        request_course: isRTL.value ? 'اطلب دورة' : 'Request Course',
        contact_us: isRTL.value ? 'اتصل بنا' : 'Contact Us',
    },

    footer: {
        description: isRTL.value
            ? 'تمكين المبرمجين الطموحين بدورات شاملة ومشاريع عملية لبناء مسيرة مهنية ناجحة في التكنولوجيا.'
            : 'Empowering aspiring programmers with comprehensive courses and hands-on projects to build successful careers in technology.',
        quick_links: isRTL.value ? 'روابط سريعة' : 'Quick Links',
        categories: isRTL.value ? 'الفئات' : 'Categories',
        support: isRTL.value ? 'الدعم' : 'Support',
        copyright: isRTL.value ? '© ٢٠٢٤ أكاديمية برمجة. جميع الحقوق محفوظة.' : '© 2024 Barmaja Academy. All rights reserved.',
        links: {
            home: isRTL.value ? 'الرئيسية' : 'Home',
            courses: isRTL.value ? 'الدورات' : 'Courses',
            blog: isRTL.value ? 'المدونة' : 'Blog',
            about: isRTL.value ? 'من نحن' : 'About Us',
            contact: isRTL.value ? 'اتصل بنا' : 'Contact',
            help_center: isRTL.value ? 'مركز المساعدة' : 'Help Center',
            privacy_policy: isRTL.value ? 'سياسة الخصوصية' : 'Privacy Policy',
            terms_of_service: isRTL.value ? 'شروط الخدمة' : 'Terms of Service',
            refund_policy: isRTL.value ? 'سياسة الاسترداد' : 'Refund Policy',
            student_support: isRTL.value ? 'دعم الطلاب' : 'Student Support',
            privacy: isRTL.value ? 'الخصوصية' : 'Privacy',
            terms: isRTL.value ? 'الشروط' : 'Terms',
            cookies: isRTL.value ? 'الكوكيز' : 'Cookies',
        },
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

                    <!-- Course Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-2xl mx-auto">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ courses?.total || 0 }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{
                                getTranslation('hero.stats.total_courses') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">10K+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{
                                getTranslation('hero.stats.students') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">50+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{
                                getTranslation('hero.stats.instructors') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">24/7</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{
                                getTranslation('hero.stats.support') }}</div>
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
                            <input v-model="searchQuery" @keyup.enter="handleSearch" type="text"
                                :placeholder="getTranslation('search.placeholder')"
                                class="w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                :class="isRTL ? 'pr-12 pl-4' : 'pl-12 pr-4'">
                            <div class="absolute inset-y-0 flex items-center pointer-events-none"
                                :class="isRTL ? 'right-0 pr-3' : 'left-0 pl-3'">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-4">
                        <select v-model="selectedCategory"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <option value="">{{ getTranslation('filters.all_categories') }}</option>
                            <option value="web-development">{{ getTranslation('categories.web_development') }}</option>
                            <option value="mobile-development">{{ getTranslation('categories.mobile_development') }}
                            </option>
                            <option value="backend-development">{{ getTranslation('categories.backend_development') }}
                            </option>
                            <option value="frontend-frameworks">{{ getTranslation('categories.frontend_frameworks') }}
                            </option>
                            <option value="database-design">{{ getTranslation('categories.database_design') }}</option>
                        </select>

                        <select v-model="selectedLevel"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <option value="">{{ getTranslation('filters.all_levels') }}</option>
                            <option value="beginner">{{ getTranslation('levels.beginner') }}</option>
                            <option value="intermediate">{{ getTranslation('levels.intermediate') }}</option>
                            <option value="advanced">{{ getTranslation('levels.advanced') }}</option>
                            <option value="expert">{{ getTranslation('levels.expert') }}</option>
                        </select>

                        <select v-model="selectedSort"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <option value="newest">{{ getTranslation('sort.newest') }}</option>
                            <option value="popular">{{ getTranslation('sort.most_popular') }}</option>
                            <option value="price_low">{{ getTranslation('sort.price_low_high') }}</option>
                            <option value="price_high">{{ getTranslation('sort.price_high_low') }}</option>
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
                    <div class="lg:w-1/4 hidden lg:block">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-24">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"
                                    :class="{ 'text-right': isRTL }">
                                    {{ getTranslation('filters.filter_courses') }}
                                </h3>
                                <button @click="clearFilters"
                                    class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    {{ getTranslation('filters.clear_all') }}
                                </button>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3"
                                    :class="{ 'text-right': isRTL }">
                                    {{ getTranslation('filters.price_range') }}
                                </h4>
                                <div class="space-y-2">
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('price.free') }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('price.range_1_50') }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('price.range_51_100') }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('price.range_100_plus') }}
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3"
                                    :class="{ 'text-right': isRTL }">
                                    {{ getTranslation('filters.duration') }}
                                </h4>
                                <div class="space-y-2">
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('duration.short') }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('duration.medium') }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('duration.long') }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            {{ getTranslation('duration.very_long') }}
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3"
                                    :class="{ 'text-right': isRTL }">
                                    {{ getTranslation('filters.rating') }}
                                </h4>
                                <div class="space-y-2">
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300 flex items-center"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            <div class="flex text-yellow-400" :class="isRTL ? 'ml-1' : 'mr-1'">
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                            </div>
                                            {{ isRTL ? '٤.٥ فما فوق' : '4.5 & up' }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300 flex items-center"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            <div class="flex text-yellow-400" :class="isRTL ? 'ml-1' : 'mr-1'">
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="far fa-star text-xs"></i>
                                            </div>
                                            {{ isRTL ? '٤.٠ فما فوق' : '4.0 & up' }}
                                        </span>
                                    </label>
                                    <label class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600 dark:text-gray-300 flex items-center"
                                            :class="isRTL ? 'mr-2' : 'ml-2'">
                                            <div class="flex text-yellow-400" :class="isRTL ? 'ml-1' : 'mr-1'">
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="fas fa-star text-xs"></i>
                                                <i class="far fa-star text-xs"></i>
                                                <i class="far fa-star text-xs"></i>
                                            </div>
                                            {{ isRTL ? '٣.٠ فما فوق' : '3.0 & up' }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Grid -->
                    <div class="lg:w-3/4">
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
                            <div v-for="course in courses?.data" :key="course.id"
                                class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">

                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop"
                                        alt="Course"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">

                                    <!-- Course Badge -->
                                    <div class="absolute top-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold"
                                        :class="isRTL ? 'left-4' : 'right-4'">
                                        {{ getTranslation('course.new_badge') }}
                                    </div>

                                    <!-- Preview Button -->
                                    <div v-if="course.preview_video_url"
                                        class="absolute bottom-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm backdrop-blur-sm"
                                        :class="isRTL ? 'right-4' : 'left-4'">
                                        <i class="fas fa-play" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                        {{ getTranslation('course.preview_available') }}
                                    </div>

                                    <!-- Hover Overlay -->
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                        <Link :href="route('frontend.show.course', { id: course.id })"
                                            class="bg-white text-gray-900 px-4 py-2 rounded-lg font-semibold opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                        {{ getTranslation('course.view_course') }}
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
                                        <div class="flex items-center text-yellow-400"
                                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                            <i class="fas fa-star text-sm"></i>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">4.8</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-500">(245)</span>
                                        </div>
                                    </div>

                                    <!-- Course Title -->
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                        :class="{ 'text-right': isRTL }">
                                        {{ getLocalizedContent(course, 'title') }}
                                    </h3>

                                    <!-- Course Description -->
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2"
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
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face"
                                                alt="Instructor" class="w-8 h-8 rounded-full">
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
                                        class="w-full bg-gradient-to-br from-blue-500 to-purple-700 text-white py-3 px-6 rounded-lg font-bold text-lg tracking-wide shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 text-center block">
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

                        <!-- Pagination -->
                        <div v-if="courses && courses.last_page > 1"
                            class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-8">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                {{ getTranslation('pagination.showing') }} {{ courses.from }}-{{ courses.to }}
                                {{ getTranslation('pagination.of') }} {{ courses.total }} {{
                                getTranslation('pagination.results') }}
                            </div>

                            <div class="flex items-center space-x-2" :class="{ 'space-x-reverse': isRTL }">
                                <!-- Previous Button -->
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

                                <!-- Page Numbers -->
                                <div class="flex items-center space-x-1" :class="{ 'space-x-reverse': isRTL }">
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
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                    {{ getTranslation('cta.title') }}
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    {{ getTranslation('cta.subtitle') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                        {{ getTranslation('cta.request_course') }}
                    </button>
                    <Link href="/contact"
                        class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    {{ getTranslation('cta.contact_us') }}
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
                        <div class="flex items-center mb-6" :class="{ 'flex-row-reverse': isRTL }">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center"
                                :class="isRTL ? 'ml-3' : 'mr-3'">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold">{{ getTranslation('page_subtitle') }}</h3>
                        </div>
                        <p class="text-gray-400 mb-6" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.description') }}
                        </p>
                        <div class="flex space-x-4" :class="{ 'space-x-reverse': isRTL }">
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
                        <h4 class="text-lg font-semibold mb-6" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.quick_links') }}
                        </h4>
                        <ul class="space-y-3">
                            <li>
                                <Link href="/"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.home') }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/courses"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.courses') }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/blog"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.blog') }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/about"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.about') }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/contact"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.contact') }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.categories') }}
                        </h4>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('categories.web_development') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('categories.mobile_development') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('categories.backend_development') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('categories.frontend_frameworks') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('categories.database_design') }}
                                </a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.support') }}
                        </h4>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.help_center') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.privacy_policy') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.terms_of_service') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.refund_policy') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.student_support') }}
                                </a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 mt-12">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.copyright') }}
                        </p>
                        <div class="flex items-center space-x-6 mt-4 md:mt-0" :class="{ 'space-x-reverse': isRTL }">
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                                {{ getTranslation('footer.links.privacy') }}
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                                {{ getTranslation('footer.links.terms') }}
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                                {{ getTranslation('footer.links.cookies') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
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
</style>