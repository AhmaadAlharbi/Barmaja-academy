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

// Get current locale and RTL detection
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');

// Get translations from props with comprehensive fallbacks
const translations = computed(() => page.props.translations?.course || {});

// Comprehensive fallback translations
const fallbackTranslations = {
    page_title: isRTL.value ? 'تفاصيل الدورة' : 'Course Details',
    breadcrumb: {
        home: isRTL.value ? 'الرئيسية' : 'Home',
        courses: isRTL.value ? 'الدورات' : 'Courses',
    },
    hero: {
        total_duration: isRTL.value ? '٢٤ ساعة ٣٠ دقيقة إجمالي' : '24h 30m total',
        lessons: isRTL.value ? 'درس' : 'lessons',
        students: isRTL.value ? 'طالب' : 'students',
        languages: isRTL.value ? 'الإنجليزية والعربية' : 'English & Arabic',
        instructor_title: isRTL.value ? 'مطور فلتر أول' : 'Senior Flutter Developer',
        instructor_rating: isRTL.value ? '٤.٩ تقييم المدرس' : '4.9 instructor rating',
        courses_count: isRTL.value ? 'دورة' : 'courses',
        reviews_text: isRTL.value ? 'تقييم' : 'reviews',
    },
    enrollment: {
        // Non-authenticated section
        account_required: isRTL.value ? 'حساب مطلوب' : 'Account Required',
        join_to_learn: isRTL.value ? 'انضم لبدء التعلم' : 'Join to Start Learning',
        create_account_desc: isRTL.value ? 'أنشئ حسابك المجاني للتسجيل في هذه الدورة' : 'Create your free account to enroll in this course',
        create_account: isRTL.value ? 'إنشاء حساب مجاني' : 'Create Free Account',
        already_have_account: isRTL.value ? 'لديك حساب بالفعل؟' : 'Already Have Account?',
        why_join: isRTL.value ? '🎯 لماذا تنضم لأكاديمية برمجة؟' : '🎯 Why Join Barmaja Academy?',
        benefits: {
            free_account: isRTL.value ? 'إنشاء حساب مجاني' : 'Free account creation',
            track_progress: isRTL.value ? 'تتبع تقدمك في التعلم' : 'Track your learning progress',
            certificates: isRTL.value ? 'احصل على شهادات معتمدة' : 'Get verified certificates',
            community: isRTL.value ? 'انضم لمجتمع التعلم' : 'Join learning community',
        },

        // Enrolled section
        enrolled_status: isRTL.value ? 'أنت مسجل في هذه الدورة!' : 'You are enrolled in this course!',
        go_to_course: isRTL.value ? 'انتقل للدورة' : 'Go to Course',

        // Not enrolled section
        enroll_now: isRTL.value ? 'اشترك الآن' : 'Enroll Now',
        processing: isRTL.value ? 'جاري المعالجة...' : 'Processing...',
    },
    features: {
        whats_included: isRTL.value ? 'ما المدرج:' : 'What\'s Included:',
        lifetime_access: isRTL.value ? 'وصول مدى الحياة' : 'Lifetime access',
        mobile_access: isRTL.value ? 'وصول عبر الهاتف والكمبيوتر' : 'Access on mobile and desktop',
        certificate: isRTL.value ? 'شهادة إتمام' : 'Certificate of completion',
        money_back: isRTL.value ? 'ضمان استرداد المال لمدة ٣٠ يوم' : '30-day money-back guarantee',
    },
    tabs: {
        overview: isRTL.value ? 'نظرة عامة' : 'Overview',
        curriculum: isRTL.value ? 'المنهج' : 'Curriculum',
        reviews: isRTL.value ? 'التقييمات' : 'Reviews',
    },
    overview: {
        title: isRTL.value ? 'نظرة عامة على الدورة' : 'Course Overview',
        what_learn: isRTL.value ? 'ما ستتعلمه' : 'What you\'ll learn',
        prerequisites: isRTL.value ? 'المتطلبات' : 'Prerequisites',
        learning_outcomes: [
            isRTL.value ? 'بناء تطبيقات جوال جميلة لنظامي iOS و Android' : 'Build beautiful mobile apps for iOS and Android',
            isRTL.value ? 'إتقان عناصر وتخطيطات Flutter' : 'Master Flutter widgets and layouts',
            isRTL.value ? 'تطبيق إدارة الحالة مع Provider و Bloc' : 'Implement state management with Provider and Bloc',
            isRTL.value ? 'التكامل مع Firebase لخدمات الخلفية' : 'Integrate with Firebase for backend services',
        ],
        prerequisite_items: [
            isRTL.value ? 'معرفة أساسية بالبرمجة' : 'Basic programming knowledge',
            isRTL.value ? 'إلمام بالبرمجة الكائنية' : 'Familiarity with object-oriented programming',
        ],
    },
    curriculum: {
        title: isRTL.value ? 'منهج الدورة' : 'Course Curriculum',
        total_lessons: isRTL.value ? 'إجمالي الدروس' : 'Total Lessons',
        total_duration: isRTL.value ? 'إجمالي المدة' : 'Total Duration',
        accessible: isRTL.value ? 'متاح' : 'Accessible',

        // Authentication messages
        account_required_title: isRTL.value ? '🔐 حساب مطلوب لعرض المنهج' : '🔐 Account Required to View Curriculum',
        account_required_desc: isRTL.value ? 'أنشئ حسابك المجاني لاستكشاف منهج الدورة الكامل وبدء رحلة التعلم.' : 'Create your free account to explore the complete course curriculum and start your learning journey.',
        curriculum_benefits: {
            full_access: isRTL.value ? 'وصول كامل للمنهج' : 'Full curriculum access',
            progress_tracking: isRTL.value ? 'تتبع التقدم' : 'Progress tracking',
            interactive_exercises: isRTL.value ? 'تمارين تفاعلية' : 'Interactive exercises',
            certificate: isRTL.value ? 'شهادة إتمام' : 'Certificate of completion',
        },
        sign_in: isRTL.value ? 'تسجيل الدخول' : 'Sign In',

        // Preview mode
        preview_mode: isRTL.value ? 'وضع المعاينة' : 'Preview Mode',
        preview_desc: isRTL.value ? 'أنت تشاهد مخطط الدورة. اشترك للوصول لجميع الدروس وبدء التعلم.' : 'You\'re viewing the course outline. Enroll to access all lessons and start learning.',

        // Lesson states
        video_badge: isRTL.value ? 'فيديو' : 'Video',
        duration_min: isRTL.value ? 'دقيقة' : 'min',
        start_lesson: isRTL.value ? 'بدء الدرس' : 'Start Lesson',
        enroll_to_access: isRTL.value ? 'اشترك للوصول لهذا الدرس' : 'Enroll to access this lesson',
        unlock: isRTL.value ? 'إلغاء القفل' : 'Unlock',
        create_to_access: isRTL.value ? 'أنشئ حساب للوصول' : 'Create account to access',
        more_lessons: isRTL.value ? 'دروس أخرى متاحة' : 'More Lessons Available',
        unlock_all: isRTL.value ? 'إلغاء قفل جميع الدروس' : 'Unlock All Lessons',
        join_students: isRTL.value ? 'انضم لآلاف الطلاب واحصل على المنهج الكامل' : 'Join thousands of students and unlock the complete curriculum',

        // CTA sections
        ready_to_start: isRTL.value ? '🚀 مستعد لبدء رحلتك؟' : '🚀 Ready to Start Your Journey?',
        comprehensive_lessons: isRTL.value ? 'درس شامل وبناء مهارات عملية مهمة' : 'comprehensive lessons and build real-world skills that matter',
        transform_skills: isRTL.value ? 'مستعد لتطوير مهاراتك؟' : 'Ready to Transform Your Skills?',
        successful_graduates: isRTL.value ? 'وآلاف الخريجين الناجحين' : 'and thousands of successful graduates',
        start_learning_for: isRTL.value ? 'ابدأ التعلم مقابل' : 'Start Learning for',
    },
    reviews: {
        title: isRTL.value ? 'آراء الطلاب' : 'Student Reviews',
        based_on: isRTL.value ? 'بناءً على' : 'Based on',
        write_review: isRTL.value ? 'اكتب تقييماً' : 'Write a Review',
        leave_review: isRTL.value ? 'اترك تقييماً' : 'Leave a Review',
        rating_label: isRTL.value ? 'التقييم' : 'Rating',
        comment_label: isRTL.value ? 'التعليق' : 'Comment',
        comment_placeholder: isRTL.value ? 'شارك تجربتك مع هذه الدورة...' : 'Share your experience with this course...',
        submit_review: isRTL.value ? 'إرسال التقييم' : 'Submit Review',
        no_reviews: isRTL.value ? 'لا توجد تقييمات بعد. كن أول من يقيم هذه الدورة!' : 'No reviews yet. Be the first to review this course!',
    },
    sidebar: {
        related_courses: isRTL.value ? 'دورات ذات صلة' : 'Related Courses',
        your_progress: isRTL.value ? 'تقدمك' : 'Your Progress',
        completed: isRTL.value ? 'مكتمل' : 'Completed',
        start_tracking: isRTL.value ? 'ابدأ التعلم لتتبع تقدمك!' : 'Start learning to track your progress!',
        enroll_to_track: isRTL.value ? 'اشترك لبدء تتبع تقدمك في هذه الدورة.' : 'Enroll to start tracking your progress through this course.',
    },
    modal: {
        course_preview: isRTL.value ? 'معاينة الدورة' : 'Course Preview',
        video_placeholder: isRTL.value ? 'مشغل الفيديو' : 'Video Player Placeholder',
    },
    cta: {
        features: {
            lifetime_access: isRTL.value ? 'وصول مدى الحياة' : 'Lifetime Access',
            certificate: isRTL.value ? 'شهادة' : 'Certificate',
            mobile_access: isRTL.value ? 'وصول عبر الهاتف' : 'Mobile Access',
        },
        guarantee: isRTL.value ? 'ضمان استرداد المال لمدة ٣٠ يوم' : '30-day money-back guarantee',
        social_proof: {
            students: isRTL.value ? 'طالب' : 'Students',
            rating: isRTL.value ? 'التقييم' : 'Rating',
            certificates: isRTL.value ? 'شهادة' : 'Certificates',
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
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString(currentLocale.value, options);
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

                        <!-- Course Badge -->
                        <div class="flex items-center mb-4" :class="isRTL ? 'space-x-reverse space-x-3' : 'space-x-3'">
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
                                <span class="text-gray-600 dark:text-gray-400 text-sm" :class="isRTL ? 'mr-2' : 'ml-2'">
                                    {{ isRTL ? '٤.٨ (٢٤٥ تقييم)' : '4.8 (245 reviews)' }}
                                </span>
                            </div>
                        </div>

                        <!-- Course Title -->
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 leading-tight"
                            :class="{ 'text-right': isRTL }">
                            {{ getLocalizedContent(course, 'title') }}
                        </h1>

                        <!-- Course Meta -->
                        <div class="flex flex-wrap items-center gap-6 text-gray-600 dark:text-gray-400 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-clock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ getTranslation('hero.total_duration') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-play-circle" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ course.contents.length }} {{ getTranslation('hero.lessons') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ isRTL ? '١,٢٣٤' : '1,234' }} {{ getTranslation('hero.students') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-globe" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <span>{{ getTranslation('hero.languages') }}</span>
                            </div>
                        </div>

                        <!-- Course Description -->
                        <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8"
                            :class="{ 'text-right': isRTL }">
                            {{ getLocalizedContent(course, 'description') }}
                        </p>

                        <!-- Instructor Info -->
                        <div class="flex items-center p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg"
                            :class="{ 'flex-row-reverse': isRTL }">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=face"
                                alt="Instructor" class="w-16 h-16 rounded-full" :class="isRTL ? 'ml-4' : 'mr-4'">
                            <div :class="{ 'text-right': isRTL }">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ isRTL ? 'أحمد خليل' : 'Ahmed Khalil' }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ getTranslation('hero.instructor_title')
                                    }}</p>
                                <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400"
                                    :class="{ 'flex-row-reverse': isRTL }">
                                    <i class="fas fa-star text-yellow-400" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                    <span>{{ getTranslation('hero.instructor_rating') }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ isRTL ? '١٥' : '15' }} {{ getTranslation('hero.courses_count') }}</span>
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
                                                <i class="fas fa-user-lock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                {{ getTranslation('enrollment.account_required') }}
                                            </div>
                                        </div>

                                        <!-- Main CTA -->
                                        <div class="text-center space-y-3">
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ getTranslation('enrollment.join_to_learn') }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ getTranslation('enrollment.create_account_desc') }}
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
                                                <i class="fas fa-user-plus" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                {{ getTranslation('enrollment.create_account') }}
                                            </div>
                                            </Link>

                                            <Link href="/login"
                                                class="w-full border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
                                            <i class="fas fa-sign-in-alt" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                            {{ getTranslation('enrollment.already_have_account') }}
                                            </Link>
                                        </div>

                                        <!-- Quick Benefits -->
                                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                            <h4
                                                class="font-semibold text-blue-900 dark:text-blue-100 text-sm mb-3 text-center">
                                                {{ getTranslation('enrollment.why_join') }}
                                            </h4>
                                            <div class="space-y-2 text-xs">
                                                <div class="flex items-center text-blue-800 dark:text-blue-200"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <div class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center"
                                                        :class="isRTL ? 'ml-2' : 'mr-2'">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                    <span>{{ getTranslation('enrollment.benefits.free_account')
                                                        }}</span>
                                                </div>
                                                <div class="flex items-center text-blue-800 dark:text-blue-200"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <div class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center"
                                                        :class="isRTL ? 'ml-2' : 'mr-2'">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                    <span>{{ getTranslation('enrollment.benefits.track_progress')
                                                        }}</span>
                                                </div>
                                                <div class="flex items-center text-blue-800 dark:text-blue-200"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <div class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center"
                                                        :class="isRTL ? 'ml-2' : 'mr-2'">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                    <span>{{ getTranslation('enrollment.benefits.certificates')
                                                        }}</span>
                                                </div>
                                                <div class="flex items-center text-blue-800 dark:text-blue-200"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <div class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center"
                                                        :class="isRTL ? 'ml-2' : 'mr-2'">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                    <span>{{ getTranslation('enrollment.benefits.community') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enrolled Users -->
                                <div v-else-if="isEnrolled && auth?.user">
                                    <Link :href="route('course.content', { course_id: course.id })"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-4 flex items-center justify-center">
                                    <i class="fas fa-play-circle" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                    {{ getTranslation('enrollment.go_to_course') }}
                                    </Link>
                                    <div class="text-center text-green-600 dark:text-green-400 font-medium mb-4">
                                        <i class="fas fa-check-circle" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        {{ getTranslation('enrollment.enrolled_status') }}
                                    </div>
                                </div>

                                <!-- Authenticated but Not Enrolled -->
                                <div v-else>
                                    <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-4 flex items-center justify-center">
                                        <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin"
                                            :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        <i v-else class="fas fa-shopping-cart" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        {{ enrollForm.processing ? getTranslation('enrollment.processing') :
                                        getTranslation('enrollment.enroll_now') }}
                                    </button>
                                </div>

                                <!-- Course Features (always show) -->
                                <div class="space-y-3 text-sm mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3"
                                        :class="{ 'text-right': isRTL }">
                                        {{ getTranslation('features.whats_included') }}
                                    </h4>
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

        <!-- Course Content Tabs -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Tab Navigation -->
                        <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-lg mb-8"
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
                            <button @click="activeTab = 'reviews'" :class="[
                                'flex-1 py-3 px-4 text-sm font-medium rounded-md transition-all duration-200',
                                activeTab === 'reviews'
                                    ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400'
                                    : 'text-gray-600 dark:text-gray-400'
                            ]">
                                {{ getTranslation('tabs.reviews') }}
                            </button>
                        </div>

                        <!-- Tab Content -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
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
                                        <li v-for="outcome in getTranslation('overview.learning_outcomes')"
                                            :key="outcome" class="flex items-start"
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
                                        <li v-for="prerequisite in getTranslation('overview.prerequisite_items')"
                                            :key="prerequisite" class="flex items-start"
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

                                <!-- Course Stats -->
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-6 mb-8">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                {{ course.contents.length }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ getTranslation('curriculum.total_lessons') }}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                                {{ isRTL ? '٢٤ ساعة ٣٠ دقيقة' : '24h 30m' }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ getTranslation('curriculum.total_duration') }}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                {{ isEnrolled ? course.contents.length : 0 }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ getTranslation('curriculum.accessible') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Authentication Required Notice -->
                                <div v-if="!auth?.user" class="mb-8">
                                    <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-l-4 border-orange-400 rounded-lg p-6"
                                        :class="{ 'border-r-4 border-l-0': isRTL }">
                                        <div class="flex items-start" :class="{ 'flex-row-reverse': isRTL }">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-10 h-10 bg-orange-100 dark:bg-orange-800 rounded-full flex items-center justify-center">
                                                    <i
                                                        class="fas fa-user-lock text-orange-600 dark:text-orange-300"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1" :class="isRTL ? 'mr-4' : 'ml-4'">
                                                <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-2"
                                                    :class="{ 'text-right': isRTL }">
                                                    {{ getTranslation('curriculum.account_required_title') }}
                                                </h3>
                                                <p class="text-orange-700 dark:text-orange-300 mb-4"
                                                    :class="{ 'text-right': isRTL }">
                                                    {{ getTranslation('curriculum.account_required_desc') }}
                                                </p>

                                                <!-- Benefits Grid -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                                                    <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm"
                                                        :class="{ 'flex-row-reverse': isRTL }">
                                                        <i class="fas fa-check-circle text-orange-500"
                                                            :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                        <span>{{
                                                            getTranslation('curriculum.curriculum_benefits.full_access')
                                                            }}</span>
                                                    </div>
                                                    <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm"
                                                        :class="{ 'flex-row-reverse': isRTL }">
                                                        <i class="fas fa-check-circle text-orange-500"
                                                            :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                        <span>{{
                                                            getTranslation('curriculum.curriculum_benefits.progress_tracking')
                                                            }}</span>
                                                    </div>
                                                    <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm"
                                                        :class="{ 'flex-row-reverse': isRTL }">
                                                        <i class="fas fa-check-circle text-orange-500"
                                                            :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                        <span>{{
                                                            getTranslation('curriculum.curriculum_benefits.interactive_exercises')
                                                            }}</span>
                                                    </div>
                                                    <div class="flex items-center text-orange-700 dark:text-orange-300 text-sm"
                                                        :class="{ 'flex-row-reverse': isRTL }">
                                                        <i class="fas fa-check-circle text-orange-500"
                                                            :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                        <span>{{
                                                            getTranslation('curriculum.curriculum_benefits.certificate')
                                                            }}</span>
                                                    </div>
                                                </div>

                                                <!-- CTA Buttons -->
                                                <div class="flex flex-col sm:flex-row gap-3">
                                                    <Link href="/register"
                                                        class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-md">
                                                    <i class="fas fa-user-plus" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    {{ getTranslation('enrollment.create_account') }}
                                                    </Link>
                                                    <Link href="/login"
                                                        class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-800 border-2 border-orange-300 dark:border-orange-600 text-orange-700 dark:text-orange-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 font-semibold rounded-lg transition-all duration-300">
                                                    <i class="fas fa-sign-in-alt" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    {{ getTranslation('curriculum.sign_in') }}
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enrollment Notice for Authenticated Non-Enrolled Users -->
                                <div v-else-if="!isEnrolled" class="mb-8">
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-6 rounded-lg"
                                        :class="{ 'border-r-4 border-l-0': isRTL }">
                                        <div class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                                            </div>
                                            <div class="flex-1" :class="isRTL ? 'mr-4' : 'ml-4'">
                                                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200"
                                                    :class="{ 'text-right': isRTL }">
                                                    {{ getTranslation('curriculum.preview_mode') }}
                                                </h3>
                                                <p class="text-blue-700 dark:text-blue-300 mt-1"
                                                    :class="{ 'text-right': isRTL }">
                                                    {{ getTranslation('curriculum.preview_desc') }}
                                                </p>
                                            </div>
                                            <div :class="isRTL ? 'mr-6' : 'ml-6'">
                                                <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                                    class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300">
                                                    <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin"
                                                        :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    <i v-else class="fas fa-play" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    {{ enrollForm.processing ? getTranslation('enrollment.processing') :
                                                    getTranslation('enrollment.enroll_now') }}
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
                                            <div class="flex items-center justify-between"
                                                :class="{ 'flex-row-reverse': isRTL }">
                                                <!-- Left Side - Lesson Info -->
                                                <div class="flex items-center flex-1"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <!-- Lesson Number -->
                                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-bold text-sm"
                                                        :class="isRTL ? 'ml-4' : 'mr-4'">
                                                        {{ content.sort_order }}
                                                    </div>

                                                    <!-- Title and Description -->
                                                    <div class="flex-1" :class="{ 'text-right': isRTL }">
                                                        <h3
                                                            class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-1">
                                                            {{ getLocalizedContent(content, 'title') }}
                                                        </h3>
                                                        <p
                                                            class="text-sm text-gray-500 dark:text-gray-500 line-clamp-2">
                                                            {{ getLocalizedContent(content, 'content').substring(0, 120)
                                                            }}...
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Right Side - Lesson Meta -->
                                                <div class="flex items-center gap-4" :class="isRTL ? 'mr-6' : 'ml-6'">
                                                    <!-- Video Badge -->
                                                    <div v-if="content.video_url"
                                                        class="flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400"
                                                        :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                                        <i class="fas fa-play"></i>
                                                        <span>{{ getTranslation('curriculum.video_badge') }}</span>
                                                    </div>

                                                    <!-- Duration -->
                                                    <div class="text-sm font-medium text-gray-400 dark:text-gray-500">
                                                        {{ isRTL ? '١٥ دقيقة' : '15 min' }}
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
                                                <div class="flex items-center justify-between"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm"
                                                        :class="{ 'flex-row-reverse': isRTL }">
                                                        <i class="fas fa-lock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                        <span>{{ getTranslation('curriculum.create_to_access') }}</span>
                                                    </div>
                                                    <Link href="/register"
                                                        class="text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 font-medium text-sm transition-colors">
                                                    <i class="fas fa-user-plus" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                                    {{ isRTL ? 'سجل' : 'Sign Up' }}
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
                                                    {{ course.contents.length - 3 }}+ {{
                                                    getTranslation('curriculum.more_lessons') }}
                                                </h3>
                                                <p class="text-gray-600 dark:text-gray-300 mb-4">
                                                    {{ getTranslation('curriculum.join_students') }}
                                                </p>
                                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                                    <Link href="/register"
                                                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-[1.02]">
                                                    <i class="fas fa-unlock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    {{ getTranslation('curriculum.unlock_all') }}
                                                    </Link>
                                                    <Link href="/login"
                                                        class="inline-flex items-center justify-center px-6 py-3 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                                                    {{ getTranslation('enrollment.already_have_account') }}
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Full curriculum for authenticated users -->
                                <div v-else class="space-y-3">
                                    <div v-for="(content, index) in course.contents" :key="content.id" :class="[
                                        'border rounded-xl overflow-hidden transition-all duration-300 group',
                                        isEnrolled
                                            ? 'border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md cursor-pointer bg-white dark:bg-gray-800'
                                            : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50'
                                    ]">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between"
                                                :class="{ 'flex-row-reverse': isRTL }">
                                                <!-- Left Side - Lesson Info -->
                                                <div class="flex items-center flex-1"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <!-- Lesson Number -->
                                                    <div :class="[
                                                        'flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center font-bold text-sm',
                                                        isRTL ? 'ml-4' : 'mr-4',
                                                        isEnrolled
                                                            ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                                            : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                                    ]">
                                                        {{ content.sort_order }}
                                                    </div>

                                                    <!-- Title and Description -->
                                                    <div class="flex-1" :class="{ 'text-right': isRTL }">
                                                        <h3 :class="[
                                                            'text-lg font-semibold mb-1',
                                                            isEnrolled
                                                                ? 'text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400'
                                                                : 'text-gray-600 dark:text-gray-400'
                                                        ]">
                                                            {{ getLocalizedContent(content, 'title') }}
                                                        </h3>
                                                        <p :class="[
                                                            'text-sm line-clamp-2',
                                                            isEnrolled
                                                                ? 'text-gray-600 dark:text-gray-300'
                                                                : 'text-gray-500 dark:text-gray-500'
                                                        ]">
                                                            {{ getLocalizedContent(content, 'content').substring(0, 120)
                                                            }}...
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Right Side - Lesson Meta -->
                                                <div class="flex items-center gap-4" :class="isRTL ? 'mr-6' : 'ml-6'">
                                                    <!-- Video Badge -->
                                                    <div v-if="content.video_url" :class="[
                                                        'flex items-center px-3 py-1 rounded-full text-xs font-medium',
                                                        isRTL ? 'space-x-reverse space-x-1' : 'space-x-1',
                                                        isEnrolled
                                                            ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                                            : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                                    ]">
                                                        <i class="fas fa-play"></i>
                                                        <span>{{ getTranslation('curriculum.video_badge') }}</span>
                                                    </div>

                                                    <!-- Duration -->
                                                    <div :class="[
                                                        'text-sm font-medium',
                                                        isEnrolled
                                                            ? 'text-gray-500 dark:text-gray-400'
                                                            : 'text-gray-400 dark:text-gray-500'
                                                    ]">
                                                        {{ isRTL ? '١٥ دقيقة' : '15 min' }}
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
                                                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm transition-colors"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                <i class="fas fa-arrow-right"
                                                    :class="isRTL ? 'ml-2 fas fa-arrow-left' : 'mr-2'"></i>
                                                {{ getTranslation('curriculum.start_lesson') }}
                                                </Link>
                                            </div>

                                            <!-- Non-Enrolled: Lock Notice -->
                                            <div v-else class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                                <div class="flex items-center justify-between"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm"
                                                        :class="{ 'flex-row-reverse': isRTL }">
                                                        <i class="fas fa-lock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                        <span>{{ getTranslation('curriculum.enroll_to_access') }}</span>
                                                    </div>
                                                    <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm transition-colors disabled:opacity-50">
                                                        <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin"
                                                            :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                                        <i v-else class="fas fa-unlock"
                                                            :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                                        {{ enrollForm.processing ?
                                                            getTranslation('enrollment.processing') :
                                                        getTranslation('curriculum.unlock') }}
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
                                                {{ getTranslation('curriculum.ready_to_start') }}
                                            </h3>
                                            <p class="text-indigo-100 mb-6 text-lg">
                                                {{ isRTL ? 'انضم لـ' : 'Join' }} {{ course.contents.length }} {{
                                                getTranslation('curriculum.comprehensive_lessons') }}.
                                            </p>

                                            <!-- Features Grid -->
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                                <div class="bg-white/10 rounded-lg p-4">
                                                    <i class="fas fa-infinity text-2xl mb-2"></i>
                                                    <div class="text-sm font-medium">{{
                                                        getTranslation('cta.features.lifetime_access') }}</div>
                                                </div>
                                                <div class="bg-white/10 rounded-lg p-4">
                                                    <i class="fas fa-certificate text-2xl mb-2"></i>
                                                    <div class="text-sm font-medium">{{
                                                        getTranslation('cta.features.certificate') }}</div>
                                                </div>
                                                <div class="bg-white/10 rounded-lg p-4">
                                                    <i class="fas fa-mobile-alt text-2xl mb-2"></i>
                                                    <div class="text-sm font-medium">{{
                                                        getTranslation('cta.features.mobile_access') }}</div>
                                                </div>
                                            </div>

                                            <!-- CTA Button -->
                                            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4"
                                                :class="{ 'sm:space-x-reverse': isRTL }">
                                                <button @click="enrollInCourse" :disabled="enrollForm.processing"
                                                    class="bg-white text-indigo-600 hover:bg-gray-100 disabled:bg-gray-300 disabled:cursor-not-allowed px-8 py-3 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                    <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin"
                                                        :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    <i v-else class="fas fa-rocket"
                                                        :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    {{ enrollForm.processing ? getTranslation('enrollment.processing') :
                                                        `${getTranslation('enrollment.enroll_now')}
                                                    ${formatPrice(course.price)}` }}
                                                </button>
                                                <div class="text-indigo-100 text-sm">
                                                    <i class="fas fa-shield-alt" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                    {{ getTranslation('cta.guarantee') }}
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
                                                {{ getTranslation('curriculum.transform_skills') }}
                                            </h3>
                                            <p class="text-orange-100 mb-6 text-lg">
                                                {{ isRTL ? 'انضم لـ' : 'Join' }} {{ course.contents.length }} {{
                                                getTranslation('curriculum.comprehensive_lessons') }} {{
                                                getTranslation('curriculum.successful_graduates') }}.
                                            </p>

                                            <!-- Social Proof -->
                                            <div class="grid grid-cols-3 gap-6 mb-8">
                                                <div>
                                                    <div class="text-2xl font-bold">{{ isRTL ? '٥٠ ألف+' : '50K+' }}
                                                    </div>
                                                    <div class="text-orange-100 text-sm">{{
                                                        getTranslation('cta.social_proof.students') }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-2xl font-bold">{{ isRTL ? '٤.٩★' : '4.9★' }}</div>
                                                    <div class="text-orange-100 text-sm">{{
                                                        getTranslation('cta.social_proof.rating') }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-2xl font-bold">{{ isRTL ? '٢٥ ألف+' : '25K+' }}
                                                    </div>
                                                    <div class="text-orange-100 text-sm">{{
                                                        getTranslation('cta.social_proof.certificates') }}</div>
                                                </div>
                                            </div>

                                            <!-- CTA Buttons -->
                                            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4"
                                                :class="{ 'sm:space-x-reverse': isRTL }">
                                                <Link href="/register"
                                                    class="bg-white text-orange-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                <i class="fas fa-rocket" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                                {{ getTranslation('curriculum.start_learning_for') }} {{
                                                formatPrice(course.price) }}
                                                </Link>
                                                <Link href="/login"
                                                    class="text-orange-100 hover:text-white font-semibold">
                                                {{ getTranslation('enrollment.already_have_account') }}
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews Tab -->
                            <div v-if="activeTab === 'reviews'">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6"
                                    :class="{ 'text-right': isRTL }">
                                    {{ getTranslation('reviews.title') }}
                                </h2>

                                <!-- Reviews Summary -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
                                    <div class="flex items-center justify-between"
                                        :class="{ 'flex-row-reverse': isRTL }">
                                        <div :class="{ 'text-right': isRTL }">
                                            <div class="flex items-center mb-2" :class="{ 'flex-row-reverse': isRTL }">
                                                <span class="text-4xl font-bold text-gray-900 dark:text-white"
                                                    :class="isRTL ? 'ml-2' : 'mr-2'">
                                                    {{ isRTL ? '٤.٨' : '4.8' }}
                                                </span>
                                                <div class="flex text-yellow-400">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300">
                                                {{ getTranslation('reviews.based_on') }} {{ isRTL ? '٢٤٥' : '245' }} {{
                                                getTranslation('hero.reviews_text') }}
                                            </p>
                                        </div>
                                        <div>
                                            <button
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                                {{ getTranslation('reviews.write_review') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Review Form -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
                                        :class="{ 'text-right': isRTL }">
                                        {{ getTranslation('reviews.leave_review') }}
                                    </h3>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                            :class="{ 'text-right': isRTL }">
                                            {{ getTranslation('reviews.rating_label') }}
                                        </label>
                                        <div class="flex items-center"
                                            :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                            <button v-for="star in 5" :key="star" @click="newRating = star"
                                                :class="star <= newRating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                                class="text-xl hover:text-yellow-400 transition-colors">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                            :class="{ 'text-right': isRTL }">
                                            {{ getTranslation('reviews.comment_label') }}
                                        </label>
                                        <textarea v-model="newComment" rows="4"
                                            :placeholder="getTranslation('reviews.comment_placeholder')"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            :class="{ 'text-right': isRTL }"></textarea>
                                    </div>

                                    <button @click="submitComment"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                                        {{ getTranslation('reviews.submit_review') }}
                                    </button>
                                </div>

                                <!-- Existing Reviews -->
                                <div class="space-y-6">
                                    <div v-if="course.comments.length === 0"
                                        class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        {{ getTranslation('reviews.no_reviews') }}
                                    </div>

                                    <div v-for="comment in course.comments" :key="comment.id"
                                        class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                        <div class="flex items-start"
                                            :class="isRTL ? 'space-x-reverse space-x-4' : 'space-x-4'">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face"
                                                alt="User" class="w-10 h-10 rounded-full">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{
                                                        comment.user_name }}</h4>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{
                                                        formatDate(comment.created_at) }}</span>
                                                </div>
                                                <div class="flex items-center mb-2"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <div class="flex text-yellow-400" :class="isRTL ? 'ml-2' : 'mr-2'">
                                                        <i v-for="star in 5" :key="star"
                                                            :class="star <= comment.rating ? 'fas fa-star' : 'far fa-star'"></i>
                                                    </div>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{
                                                        comment.rating }}/5</span>
                                                </div>
                                                <p class="text-gray-700 dark:text-gray-300"
                                                    :class="{ 'text-right': isRTL }">
                                                    {{ comment.comment }}
                                                </p>
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
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
                                :class="{ 'text-right': isRTL }">
                                {{ getTranslation('sidebar.related_courses') }}
                            </h3>

                            <div class="space-y-4">
                                <div class="flex items-center"
                                    :class="isRTL ? 'space-x-reverse space-x-3' : 'space-x-3'">
                                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=60&h=60&fit=crop"
                                        alt="Course" class="w-15 h-15 rounded-lg object-cover">
                                    <div class="flex-1" :class="{ 'text-right': isRTL }">
                                        <h4 class="font-medium text-gray-900 dark:text-white text-sm">
                                            {{ isRTL ? 'تطوير React Native' : 'React Native Development' }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">$29.99</p>
                                    </div>
                                </div>

                                <div class="flex items-center"
                                    :class="isRTL ? 'space-x-reverse space-x-3' : 'space-x-3'">
                                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=60&h=60&fit=crop"
                                        alt="Course" class="w-15 h-15 rounded-lg object-cover">
                                    <div class="flex-1" :class="{ 'text-right': isRTL }">
                                        <h4 class="font-medium text-gray-900 dark:text-white text-sm">
                                            {{ isRTL ? 'تطوير iOS مع Swift' : 'iOS Development with Swift' }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">$39.99</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Progress (if enrolled) -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
                                :class="{ 'text-right': isRTL }">
                                {{ getTranslation('sidebar.your_progress') }}
                            </h3>

                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                    <span>{{ getTranslation('sidebar.completed') }}</span>
                                    <span>{{ isEnrolled ? '0' : '0' }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-400" :class="{ 'text-right': isRTL }">
                                {{ isEnrolled ? getTranslation('sidebar.start_tracking') :
                                    getTranslation('sidebar.enroll_to_track') }}
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
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ getTranslation('modal.course_preview') }}
                    </h3>
                    <button @click="toggleVideo" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="aspect-video bg-gray-900 rounded-lg flex items-center justify-center">
                        <p class="text-white">{{ getTranslation('modal.video_placeholder') }}</p>
                        <!-- You would embed your actual video player here -->
                    </div>
                </div>
            </div>
        </div>
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

/* RTL specific hover effects */
[dir="rtl"] .hover\:translate-x-1:hover {
    transform: translateX(-0.25rem);
}

[dir="rtl"] .hover\:-translate-x-1:hover {
    transform: translateX(-0.25rem);
}
</style>