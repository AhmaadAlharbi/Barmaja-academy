<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref, computed } from 'vue';

const page = usePage();

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
        contents: Array<{
            id: number;
            title_ar: string;
            title_en: string;
            content_ar: string;
            content_en: string;
            video_url: string | null;
            sort_order: number;
        }>;
    };
    isEnrolled?: boolean;
}>();

// Add video handling methods
const isDirectVideoFile = (url: string | null) => {
    if (!url) return false;
    const videoExtensions = ['.mp4', '.webm', '.ogg', '.mov', '.avi'];
    return videoExtensions.some(ext => url.toLowerCase().includes(ext));
};

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

// Get current locale and RTL detection
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');

// Simple translations
const t = {
    en: {
        page_title: 'Course Details',
        breadcrumb: {
            home: 'Home',
            courses: 'Courses',
        },
        course_info: {
            duration: '24h 30m total',
            lessons: 'lessons',
            students: '1,234 students',
            languages: 'English & Arabic',
            instructor: 'Ahmed Khalil',
            instructor_title: 'Senior Flutter Developer',
            rating: '4.8 (245 reviews)',
        },
        price: {
            enroll_now: 'Enroll Now',
            enrolled: 'Go to Course',
            login_required: 'Login to Enroll',
        },
        features: {
            lifetime_access: 'Lifetime access',
            mobile_access: 'Access on mobile and desktop',
            certificate: 'Certificate of completion',
            money_back: '30-day money-back guarantee',
        },
        tabs: {
            overview: 'Overview',
            curriculum: 'Curriculum',
        },
        overview: {
            title: 'Course Overview',
            what_learn: 'What you\'ll learn',
            prerequisites: 'Prerequisites',
        },
        curriculum: {
            title: 'Course Curriculum',
            video: 'Video',
            locked: 'Locked',
            duration: 'min',
        },
        video: {
            preview: 'Course Preview',
            no_preview: 'No preview available',
        },
    },
    ar: {
        page_title: 'تفاصيل الدورة',
        breadcrumb: {
            home: 'الرئيسية',
            courses: 'الدورات',
        },
        course_info: {
            duration: '٢٤ ساعة ٣٠ دقيقة إجمالي',
            lessons: 'درس',
            students: '١,٢٣٤ طالب',
            languages: 'الإنجليزية والعربية',
            instructor: 'أحمد خليل',
            instructor_title: 'مطور فلتر أول',
            rating: '٤.٨ (٢٤٥ تقييم)',
        },
        price: {
            enroll_now: 'اشترك الآن',
            enrolled: 'انتقل للدورة',
            login_required: 'تسجيل الدخول للاشتراك',
        },
        features: {
            lifetime_access: 'وصول مدى الحياة',
            mobile_access: 'وصول عبر الهاتف والكمبيوتر',
            certificate: 'شهادة إتمام',
            money_back: 'ضمان استرداد المال لمدة ٣٠ يوم',
        },
        tabs: {
            overview: 'نظرة عامة',
            curriculum: 'المنهج',
        },
        overview: {
            title: 'نظرة عامة على الدورة',
            what_learn: 'ما ستتعلمه',
            prerequisites: 'المتطلبات',
        },
        curriculum: {
            title: 'منهج الدورة',
            video: 'فيديو',
            locked: 'مقفل',
            duration: 'دقيقة',
        },
        video: {
            preview: 'معاينة الدورة',
            no_preview: 'لا توجد معاينة متاحة',
        },
    },
};

// Get translation helper
function getTranslation(path: string) {
    const keys = path.split('.');
    let value = t[currentLocale.value];

    for (const key of keys) {
        if (value && typeof value === 'object' && key in value) {
            value = value[key];
        } else {
            return path; // fallback to path if not found
        }
    }

    return value;
}

// Helper function to get localized content
function getLocalizedContent(item: any, field: string) {
    return isRTL.value ? item[`${field}_ar`] : item[`${field}_en`];
}

// Reactive data
const activeTab = ref('overview');

// Enrollment form
const enrollForm = useForm({
    course_id: props.course.id,
});

// Learning outcomes (hardcoded for simplicity)
const learningOutcomes = computed(() =>
    isRTL.value ? [
        'بناء تطبيقات جوال جميلة لنظامي iOS و Android',
        'إتقان عناصر وتخطيطات Flutter',
        'تطبيق إدارة الحالة مع Provider و Bloc',
        'التكامل مع Firebase لخدمات الخلفية',
    ] : [
        'Build beautiful mobile apps for iOS and Android',
        'Master Flutter widgets and layouts',
        'Implement state management with Provider and Bloc',
        'Integrate with Firebase for backend services',
    ]
);

const prerequisites = computed(() =>
    isRTL.value ? [
        'معرفة أساسية بالبرمجة',
        'إلمام بالبرمجة الكائنية',
    ] : [
        'Basic programming knowledge',
        'Familiarity with object-oriented programming',
    ]
);

// Methods
const enrollInCourse = () => {
    if (!props.auth?.user) {
        window.location.href = '/login';
        return;
    }

    enrollForm.get(`/enroll-course/${props.course.id}`);
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat(currentLocale.value, {
        style: 'currency',
        currency: 'USD'
    }).format(price);
};
</script>

<template>

    <Head :title="`${getLocalizedContent(course, 'title')} - ${getTranslation('page_title')}`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <meta name="description" :content="getLocalizedContent(course, 'description')" />
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300" :dir="isRTL ? 'rtl' : 'ltr'"
        :class="{ 'font-tajawal': isRTL }">

        <Navbar />

        <!-- Course Hero Section -->
        <section
            class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 pt-20 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-12 items-start">
                    <!-- Course Info -->
                    <div class="lg:col-span-2">
                        <!-- Breadcrumb -->
                        <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-6"
                            :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                            <Link href="/" class="hover:text-blue-600 dark:hover:text-blue-400">
                            {{ getTranslation('breadcrumb.home') }}
                            </Link>
                            <i class="fas fa-chevron-right text-xs" :class="{ 'fas fa-chevron-left': isRTL }"></i>
                            <Link href="/courses" class="hover:text-blue-600 dark:hover:text-blue-400">
                            {{ getTranslation('breadcrumb.courses') }}
                            </Link>
                            <i class="fas fa-chevron-right text-xs" :class="{ 'fas fa-chevron-left': isRTL }"></i>
                            <span class="text-gray-900 dark:text-white">{{ getLocalizedContent(course, 'title')
                            }}</span>
                        </nav>

                        <!-- Course Title -->
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 leading-tight"
                            :class="{ 'text-right': isRTL }">
                            {{ getLocalizedContent(course, 'title') }}
                        </h1>

                        <!-- Course Meta -->
                        <div class="flex flex-wrap items-center gap-6 text-gray-600 dark:text-gray-400 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-clock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ getTranslation('course_info.duration') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-play-circle" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ course.contents.length }} {{ getTranslation('course_info.lessons') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ getTranslation('course_info.students') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-globe" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ getTranslation('course_info.languages') }}</span>
                            </div>
                        </div>

                        <!-- Course Description -->
                        <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8"
                            :class="{ 'text-right': isRTL }">
                            {{ getLocalizedContent(course, 'description') }}
                        </p>

                        <!-- Preview Video Section -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4"
                                :class="{ 'text-right': isRTL }">
                                {{ getTranslation('video.preview') }}
                            </h3>
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                                <div class="aspect-video relative">
                                    <!-- Preview Video Available -->
                                    <div v-if="course.preview_video_url">
                                        <!-- Direct Video File (MP4, etc.) -->
                                        <video v-if="isDirectVideoFile(course.preview_video_url)"
                                            class="w-full h-full bg-black" controls preload="metadata"
                                            controlslist="nodownload">
                                            <source :src="course.preview_video_url" type="video/mp4">
                                            <p class="text-white p-8 text-center">
                                                Your browser does not support the video tag.
                                            </p>
                                        </video>

                                        <!-- Embedded Video (YouTube, Vimeo) -->
                                        <iframe v-else :src="getVideoEmbedUrl(course.preview_video_url)"
                                            class="w-full h-full" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>

                                    <!-- No Preview Video -->
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                        <div class="text-center">
                                            <div
                                                class="w-20 h-20 bg-white dark:bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                                <i class="fas fa-play text-gray-400 dark:text-gray-300 text-2xl"></i>
                                            </div>
                                            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                {{ getTranslation('video.no_preview') }}
                                            </h4>
                                            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                                                {{ isRTL ? 'قم بالتسجيل للوصول إلى محتوى الدورة الكامل' :
                                                    'Enroll to access the full course content' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructor Info -->
                        <div class="flex items-center p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg"
                            :class="{ 'flex-row-reverse': isRTL }">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=face"
                                alt="Instructor" class="w-16 h-16 rounded-full" :class="isRTL ? 'ml-4' : 'mr-4'">
                            <div :class="{ 'text-right': isRTL }">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ getTranslation('course_info.instructor') }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400">{{
                                    getTranslation('course_info.instructor_title') }}</p>
                                <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400"
                                    :class="{ 'flex-row-reverse': isRTL }">
                                    <i class="fas fa-star text-yellow-400" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                    <span>{{ getTranslation('course_info.rating') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden sticky top-24">
                            <div class="p-6">
                                <!-- Price -->
                                <div class="text-center mb-6">
                                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ formatPrice(course.price) }}
                                    </div>
                                </div>

                                <!-- Enrollment Button -->
                                <div class="mb-6">
                                    <button v-if="!auth?.user" @click="enrollInCourse"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        {{ getTranslation('price.login_required') }}
                                    </button>

                                    <Link v-else-if="isEnrolled"
                                        :href="route('course.content', { course_id: course.id })"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                                    <i class="fas fa-play-circle" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                    {{ getTranslation('price.enrolled') }}
                                    </Link>

                                    <button v-else @click="enrollInCourse" :disabled="enrollForm.processing"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                                        <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin"
                                            :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        <i v-else class="fas fa-shopping-cart" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        {{ getTranslation('price.enroll_now') }}
                                    </button>
                                </div>

                                <!-- Course Features -->
                                <div class="space-y-3 text-sm pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400"
                                        :class="{ 'flex-row-reverse': isRTL }">
                                        <i class="fas fa-infinity text-blue-600" :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                        <span>{{ getTranslation('features.lifetime_access') }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400"
                                        :class="{ 'flex-row-reverse': isRTL }">
                                        <i class="fas fa-mobile-alt text-blue-600" :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                        <span>{{ getTranslation('features.mobile_access') }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400"
                                        :class="{ 'flex-row-reverse': isRTL }">
                                        <i class="fas fa-certificate text-blue-600"
                                            :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                        <span>{{ getTranslation('features.certificate') }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400"
                                        :class="{ 'flex-row-reverse': isRTL }">
                                        <i class="fas fa-undo text-blue-600" :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                        <span>{{ getTranslation('features.money_back') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Course Content -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Tab Navigation -->
                <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-lg mb-8 max-w-xs mx-auto"
                    :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                    <button @click="activeTab = 'overview'" :class="[
                        'flex-1 py-3 px-4 text-sm font-medium rounded-md transition-all duration-200',
                        activeTab === 'overview'
                            ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400'
                            : 'text-gray-600 dark:text-gray-400'
                    ]">
                        {{ getTranslation('tabs.overview') }}
                    </button>
                    <button @click="activeTab = 'curriculum'" :class="[
                        'flex-1 py-3 px-4 text-sm font-medium rounded-md transition-all duration-200',
                        activeTab === 'curriculum'
                            ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400'
                            : 'text-gray-600 dark:text-gray-400'
                    ]">
                        {{ getTranslation('tabs.curriculum') }}
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 max-w-4xl mx-auto">
                    <!-- Overview Tab -->
                    <div v-if="activeTab === 'overview'">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6"
                            :class="{ 'text-right': isRTL }">
                            {{ getTranslation('overview.title') }}
                        </h2>

                        <div class="prose dark:prose-invert max-w-none" :class="{ 'text-right': isRTL }">
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                                {{ getLocalizedContent(course, 'description') }}
                            </p>

                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                {{ getTranslation('overview.what_learn') }}
                            </h3>
                            <ul class="space-y-2 mb-6">
                                <li v-for="outcome in learningOutcomes" :key="outcome" class="flex items-start"
                                    :class="{ 'flex-row-reverse': isRTL }">
                                    <i class="fas fa-check-circle text-green-500 text-sm mt-1"
                                        :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                    <span class="text-gray-600 dark:text-gray-300">{{ outcome }}</span>
                                </li>
                            </ul>

                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                {{ getTranslation('overview.prerequisites') }}
                            </h3>
                            <ul class="space-y-2">
                                <li v-for="prerequisite in prerequisites" :key="prerequisite" class="flex items-start"
                                    :class="{ 'flex-row-reverse': isRTL }">
                                    <i class="fas fa-dot-circle text-blue-500 text-sm mt-1"
                                        :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                    <span class="text-gray-600 dark:text-gray-300">{{ prerequisite }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Curriculum Tab -->
                    <div v-if="activeTab === 'curriculum'">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6"
                            :class="{ 'text-right': isRTL }">
                            {{ getTranslation('curriculum.title') }}
                        </h2>

                        <div class="space-y-3 ">
                            <div v-for="(content, index) in course.contents" :key="content.id"
                                class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden bg-white dark:bg-gray-800 hover:shadow-md transition-shadow">

                                <Link :href="route('course.content', {
                                    course_id: course.id,
                                    content_id: content.id
                                })">
                                <div class="p-6">
                                    <div class="flex items-center justify-between"
                                        :class="{ 'flex-row-reverse': isRTL }">
                                        <!-- Left Side - Lesson Info -->
                                        <div class="flex items-center flex-1" :class="{ 'flex-row-reverse': isRTL }">
                                            <!-- Lesson Number -->
                                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm"
                                                :class="isRTL ? 'ml-4' : 'mr-4'">
                                                {{ content.sort_order }}
                                            </div>

                                            <!-- Title and Description -->
                                            <div class="flex-1" :class="{ 'text-right': isRTL }">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                                    {{ getLocalizedContent(content, 'title') }}
                                                </h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                                    {{ getLocalizedContent(content, 'content').substring(0, 120) }}...
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Right Side - Lesson Meta -->
                                        <div class="flex items-center gap-4" :class="isRTL ? 'mr-6' : 'ml-6'">
                                            <!-- Video Badge -->
                                            <div v-if="content.video_url"
                                                class="flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400"
                                                :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                                <i class="fas fa-play"></i>
                                                <span>{{ getTranslation('curriculum.video') }}</span>
                                            </div>

                                            <!-- Duration -->
                                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                {{ isRTL ? '١٥' : '15' }} {{ getTranslation('curriculum.duration') }}
                                            </div>

                                            <!-- Access Status -->
                                            <div v-if="isEnrolled"
                                                class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                                <i class="fas fa-play text-green-600 dark:text-green-400 text-sm"></i>
                                            </div>
                                            <div v-else
                                                class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                <i class="fas fa-lock text-gray-400 text-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </Link>
                            </div>
                        </div>
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

/* Video player styles */
video {
    background-color: #000;
}

video::-webkit-media-controls-panel {
    background-color: rgba(0, 0, 0, 0.8);
}
</style>