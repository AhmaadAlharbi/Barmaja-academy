<script setup lang="ts">
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref, computed } from 'vue';

const page = usePage();

// Comment interface
interface Comment {
    id: number;
    user_id: number;
    course_content_id: number;
    comment: string;
    created_at: string;
    updated_at: string;
    user?: {
        name: string;
        avatar?: string;
    };
}

// Props from Laravel backend
const props = defineProps<{
    auth?: {
        user?: any;
    };
    content: {
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
        comments?: Comment[];
    };
    course?: {
        id: number;
        title_en: string;
        title_ar: string;
        description_en: string;
        description_ar: string;
        slug: string;
        price?: number;
    };
    allLessons?: Array<{
        id: number;
        course_id: number;
        title_en: string;
        title_ar: string;
        sort_order: number;
        is_active: number;
        video_url: string | null;
    }>;
    progress?: {
        completed_lessons: number;
        total_lessons: number;
        percentage: number;
    };
    isEnrolled?: boolean;
}>();

// Get current locale and RTL detection
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');

// Translation object
const t = {
    en: {
        page_title: 'Course Content',
        breadcrumb: {
            home: 'Home',
            courses: 'Courses',
        },
        enrollment: {
            preview_mode: 'Preview Mode',
            locked: 'You\'re in Preview Mode',
            locked_description: 'Enroll in this course to access the full lesson content, videos, and participate in discussions.',
            one_time_payment: 'One-time payment',
            enroll_now: 'Enroll Now',
            processing: 'Processing...',
            go_to_course: 'Go to Course',
        },
        lesson: {
            lesson: 'Lesson',
            min: 'min',
            views: 'views',
            comments: 'comments',
            hd_video: 'HD Video',
            embedded: 'Embedded',
            video_locked: 'Video Locked',
            video_locked_description: 'Enroll in this course to access the full video lesson and start learning.',
            content_locked: 'Content Locked',
            content_locked_description: 'Enroll in this course to access the full lesson content and learning materials.',
            text_only: 'This lesson contains text content only',
        },
        comments: {
            title: 'Comments',
            locked: 'Comments Locked',
            locked_description: 'Enroll in this course to read and participate in the discussion with other students.',
            add_comment: 'Add a Comment',
            placeholder: 'Share your thoughts about this lesson...',
            post_comment: 'Post Comment',
            posting: 'Posting...',
            login_prompt: 'Please login to add comments and join the discussion.',
            enroll_prompt: 'Please enroll in the course to add comments',
            no_comments: 'No comments yet',
            no_comments_description: 'Be the first to share your thoughts about this lesson!',
            delete: 'Delete',
            delete_confirm: 'Are you sure you want to delete this comment? This action cannot be undone.',
        },
        sidebar: {
            course_content: 'Course Content',
            back_to_course: 'Back to Course',
            download_resources: 'Download Resources',
            enroll_to_access: 'Enroll to Access',
            hd: 'HD',
            stream: 'Stream',
        },
        video_types: {
            hd_video: 'HD Video',
            embedded: 'Embedded Video',
        },
        alerts: {
            login_required: 'Please login to add comments',
            enroll_required: 'Please enroll in the course to add comments',
            delete_failed: 'Failed to delete comment. Please try again.',
            enroll_failed: 'Failed to enroll in course. Please try again.',
            invalid_course: 'Invalid course selected.',
        }
    },
    ar: {
        page_title: 'محتوى الدورة',
        breadcrumb: {
            home: 'الرئيسية',
            courses: 'الدورات',
        },
        enrollment: {
            preview_mode: 'وضع المعاينة',
            locked: 'أنت في وضع المعاينة',
            locked_description: 'اشترك في هذه الدورة للوصول إلى محتوى الدرس الكامل والفيديوهات والمشاركة في المناقشات.',
            one_time_payment: 'دفعة واحدة',
            enroll_now: 'اشترك الآن',
            processing: 'جاري المعالجة...',
            go_to_course: 'انتقل للدورة',
        },
        lesson: {
            lesson: 'الدرس',
            min: 'دقيقة',
            views: 'مشاهدة',
            comments: 'تعليق',
            hd_video: 'فيديو عالي الجودة',
            embedded: 'مضمن',
            video_locked: 'الفيديو مقفل',
            video_locked_description: 'اشترك في هذه الدورة للوصول إلى درس الفيديو الكامل وابدأ التعلم.',
            content_locked: 'المحتوى مقفل',
            content_locked_description: 'اشترك في هذه الدورة للوصول إلى محتوى الدرس الكامل والمواد التعليمية.',
            text_only: 'يحتوي هذا الدرس على محتوى نصي فقط',
        },
        comments: {
            title: 'التعليقات',
            locked: 'التعليقات مقفلة',
            locked_description: 'اشترك في هذه الدورة لقراءة والمشاركة في المناقشة مع الطلاب الآخرين.',
            add_comment: 'أضف تعليق',
            placeholder: 'شارك أفكارك حول هذا الدرس...',
            post_comment: 'نشر التعليق',
            posting: 'جاري النشر...',
            login_prompt: 'يرجى تسجيل الدخول لإضافة التعليقات والانضمام للمناقشة.',
            enroll_prompt: 'يرجى الاشتراك في الدورة لإضافة التعليقات',
            no_comments: 'لا توجد تعليقات بعد',
            no_comments_description: 'كن أول من يشارك أفكاره حول هذا الدرس!',
            delete: 'حذف',
            delete_confirm: 'هل أنت متأكد من حذف هذا التعليق؟ لا يمكن التراجع عن هذا الإجراء.',
        },
        sidebar: {
            course_content: 'محتوى الدورة',
            back_to_course: 'العودة للدورة',
            download_resources: 'تحميل المصادر',
            enroll_to_access: 'اشترك للوصول',
            hd: 'عالي الجودة',
            stream: 'بث',
        },
        video_types: {
            hd_video: 'فيديو عالي الجودة',
            embedded: 'فيديو مضمن',
        },
        alerts: {
            login_required: 'يرجى تسجيل الدخول لإضافة التعليقات',
            enroll_required: 'يرجى الاشتراك في الدورة لإضافة التعليقات',
            delete_failed: 'فشل في حذف التعليق. يرجى المحاولة مرة أخرى.',
            enroll_failed: 'فشل في الاشتراك في الدورة. يرجى المحاولة مرة أخرى.',
            invalid_course: 'تم اختيار دورة غير صالحة.',
        }
    },
};

// Translation helper function
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

const showComments = ref(true);

// Enrollment form
const enrollForm = useForm({
    course_id: props.course?.id,
});

// Comment form
const commentForm = useForm({
    comment: '',
    course_content_id: props.content.id,
});

const commentsCount = computed(() => {
    return props.content.comments?.length || 0;
});

const sortedComments = computed(() => {
    if (!props.content.comments) return [];
    return [...props.content.comments].sort((a, b) =>
        new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
    );
});

// Video handling methods
const isDirectVideoFile = (url: string | null) => {
    if (!url) return false;
    const videoExtensions = ['.mp4', '.webm', '.ogg', '.mov', '.avi'];
    return videoExtensions.some(ext => url.toLowerCase().includes(ext));
};

const getVideoEmbedUrl = (url: string) => {
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        const videoId = url.split('v=')[1] || url.split('/').pop();
        return `https://www.youtube.com/embed/${videoId}`;
    }
    if (url.includes('vimeo.com')) {
        const videoId = url.split('/').pop();
        return `https://player.vimeo.com/video/${videoId}`;
    }
    return url;
};

// Enrollment function
const enrollInCourse = () => {
    if (!props.auth?.user) {
        window.location.href = '/login';
        return;
    }

    enrollForm.post('/enroll-course', {
        onSuccess: () => {
            console.log('Enrollment successful');
        },
        onError: (errors) => {
            console.error('Enrollment failed:', errors);
            if (errors.course_id) {
                alert(getTranslation('alerts.invalid_course'));
            } else {
                alert(getTranslation('alerts.enroll_failed'));
            }
        }
    });
};

// Comment methods
const submitComment = () => {
    if (!props.auth?.user) {
        alert(getTranslation('alerts.login_required'));
        return;
    }

    if (!props.isEnrolled) {
        alert(getTranslation('alerts.enroll_required'));
        return;
    }

    commentForm.post('/course-content/comment', {
        onSuccess: () => {
            commentForm.reset();
        },
        onError: (errors) => {
            console.error('Error submitting comment:', errors);
        }
    });
};

// Delete comment method with confirmation
const deleteComment = (commentId: number) => {
    const confirmed = confirm(getTranslation('comments.delete_confirm'));

    if (confirmed) {
        router.delete(`/course-content/comment/${commentId}`, {
            onSuccess: () => {
                console.log('Comment deleted successfully');
            },
            onError: (errors) => {
                console.error('Error deleting comment:', errors);
                alert(getTranslation('alerts.delete_failed'));
            }
        });
    }
};

const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    const locale = currentLocale.value === 'ar' ? 'ar-SA' : 'en-US';
    return date.toLocaleDateString(locale, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getInitials = (name: string) => {
    return name.split(' ').map(n => n[0]).join('').toUpperCase();
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat(currentLocale.value, {
        style: 'currency',
        currency: 'USD'
    }).format(price);
};
</script>

<template>

    <Head
        :title="`${getLocalizedContent(content, 'title')} - ${getLocalizedContent(course, 'title') || getTranslation('page_title')} - Barmaja Academy`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300" :dir="isRTL ? 'rtl' : 'ltr'"
        :class="{ 'font-tajawal': isRTL }">
        <Navbar />

        <!-- Course Progress Bar -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-16 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4" :class="{ 'flex-row-reverse': isRTL }">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400"
                        :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                        <Link href="/" class="hover:text-blue-600 dark:hover:text-blue-400">
                        {{ getTranslation('breadcrumb.home') }}
                        </Link>
                        <i class="fas fa-chevron-right text-xs" :class="{ 'fas fa-chevron-left': isRTL }"></i>
                        <Link href="/courses" class="hover:text-blue-600 dark:hover:text-blue-400">
                        {{ getTranslation('breadcrumb.courses') }}
                        </Link>
                        <i class="fas fa-chevron-right text-xs" :class="{ 'fas fa-chevron-left': isRTL }"></i>
                        <Link :href="`/course/${course?.id}`" class="hover:text-blue-600 dark:hover:text-blue-400">
                        {{ getLocalizedContent(course, 'title') }}
                        </Link>
                        <i class="fas fa-chevron-right text-xs" :class="{ 'fas fa-chevron-left': isRTL }"></i>
                        <span class="text-gray-900 dark:text-white">{{ getLocalizedContent(content, 'title') }}</span>
                    </nav>

                    <!-- Enrollment Status -->
                    <div v-if="!isEnrolled" class="flex items-center space-x-4" :class="{ 'space-x-reverse': isRTL }">
                        <div class="flex items-center text-amber-600 dark:text-amber-400 text-sm"
                            :class="{ 'flex-row-reverse': isRTL }">
                            <i class="fas fa-lock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                            <span>{{ getTranslation('enrollment.preview_mode') }}</span>
                        </div>
                        <button @click="enrollInCourse" :disabled="enrollForm.processing"
                            class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors flex items-center"
                            :class="{ 'flex-row-reverse': isRTL }">
                            <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin"
                                :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                            <i v-else class="fas fa-unlock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                            {{ enrollForm.processing ? getTranslation('enrollment.processing') :
                                getTranslation('enrollment.enroll_now') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollment Notice for Non-Enrolled Users -->
        <div v-if="!isEnrolled" class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between" :class="{ 'flex-row-reverse': isRTL }">
                    <div class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"
                            :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                        <div :class="{ 'text-right': isRTL }">
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">
                                {{ getTranslation('enrollment.locked') }}
                            </h3>
                            <p class="text-blue-700 dark:text-blue-300 text-sm">
                                {{ getTranslation('enrollment.locked_description') }}
                            </p>
                        </div>
                    </div>
                    <div class="hidden md:block" :class="{ 'text-left': isRTL }">
                        <div :class="isRTL ? 'text-left' : 'text-right'">
                            <div class="text-2xl font-bold text-blue-800 dark:text-blue-200">
                                {{ course?.price ? formatPrice(course.price) : 'Free' }}
                            </div>
                            <div class="text-sm text-blue-600 dark:text-blue-400">{{
                                getTranslation('enrollment.one_time_payment') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Video Player -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                        <div class="aspect-video relative">
                            <!-- Enrolled User: Full Video Access -->
                            <div v-if="isEnrolled && content.video_url">
                                <!-- Direct Video File (MP4, etc.) -->
                                <video v-if="isDirectVideoFile(content.video_url)" class="w-full h-full bg-black"
                                    controls preload="metadata" controlslist="nodownload">
                                    <source :src="content.video_url" type="video/mp4">
                                    <p class="text-white p-8 text-center">
                                        Your browser does not support the video tag.
                                    </p>
                                </video>

                                <!-- Embedded Video (YouTube, Vimeo) -->
                                <iframe v-else :src="getVideoEmbedUrl(content.video_url)" class="w-full h-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>

                            <!-- Non-Enrolled User: Locked Video -->
                            <div v-else-if="!isEnrolled && content.video_url"
                                class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                <div class="text-center" :class="{ 'text-right': isRTL }">
                                    <div
                                        class="w-20 h-20 bg-white dark:bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                        <i class="fas fa-lock text-gray-400 dark:text-gray-300 text-2xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ getTranslation('lesson.video_locked') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md">
                                        {{ getTranslation('lesson.video_locked_description') }}
                                    </p>
                                </div>
                            </div>

                            <!-- No Video Available -->
                            <div v-else
                                class="w-full h-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <div class="text-center" :class="{ 'text-right': isRTL }">
                                    <i class="fas fa-file-text text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <p class="text-gray-600 dark:text-gray-400">{{ getTranslation('lesson.text_only') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lesson Content -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <!-- Lesson Header -->
                        <div class="flex items-start justify-between mb-6" :class="{ 'flex-row-reverse': isRTL }">
                            <div class="flex-1" :class="{ 'text-right': isRTL }">
                                <div class="flex items-center mb-3"
                                    :class="isRTL ? 'space-x-reverse space-x-3 flex-row-reverse' : 'space-x-3'">
                                    <span :class="[
                                        'px-3 py-1 text-sm font-medium rounded-full',
                                        isEnrolled
                                            ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                    ]">
                                        {{ getTranslation('lesson.lesson') }} {{ content.sort_order }}
                                    </span>
                                    <div :class="[
                                        'flex items-center text-sm',
                                        isEnrolled
                                            ? 'text-gray-500 dark:text-gray-400'
                                            : 'text-gray-400 dark:text-gray-500'
                                    ]" class="flex-row-reverse">
                                        <i class="fas fa-clock" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                        <span>15 {{ getTranslation('lesson.min') }}</span>
                                    </div>
                                    <div :class="[
                                        'flex items-center text-sm',
                                        isEnrolled
                                            ? 'text-gray-500 dark:text-gray-400'
                                            : 'text-gray-400 dark:text-gray-500'
                                    ]" class="flex-row-reverse">
                                        <i class="fas fa-eye" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                        <span>1,234 {{ getTranslation('lesson.views') }}</span>
                                    </div>
                                    <div :class="[
                                        'flex items-center text-sm',
                                        isEnrolled
                                            ? 'text-gray-500 dark:text-gray-400'
                                            : 'text-gray-400 dark:text-gray-500'
                                    ]" class="flex-row-reverse">
                                        <i class="fas fa-comments" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                        <span>{{ commentsCount }} {{ getTranslation('lesson.comments') }}</span>
                                    </div>
                                    <!-- Video type indicator -->
                                    <div v-if="content.video_url" :class="[
                                        'flex items-center text-sm px-2 py-1 rounded-full',
                                        isEnrolled
                                            ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400'
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'
                                    ]" class="flex-row-reverse">
                                        <i class="fas fa-play" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                        <span>{{ isDirectVideoFile(content.video_url) ?
                                            getTranslation('lesson.hd_video') : getTranslation('lesson.embedded')
                                            }}</span>
                                    </div>
                                </div>
                                <h1 :class="[
                                    'text-3xl font-bold mb-4',
                                    isEnrolled
                                        ? 'text-gray-900 dark:text-white'
                                        : 'text-gray-600 dark:text-gray-400'
                                ]">
                                    {{ getLocalizedContent(content, 'title') }}
                                </h1>
                            </div>
                        </div>

                        <!-- Lesson Content -->
                        <div class="relative">
                            <!-- Enrolled User: Full Content Access -->
                            <div v-if="isEnrolled" class="prose dark:prose-invert max-w-none mb-8"
                                :class="{ 'text-right': isRTL }">
                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ getLocalizedContent(content, 'content') }}
                                </div>
                            </div>

                            <!-- Non-Enrolled User: Locked Content -->
                            <div v-else class="relative">
                                <!-- Lock Overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-white via-white/95 to-white/80 dark:from-gray-800 dark:via-gray-800/95 dark:to-gray-800/80 z-10 flex items-center justify-center rounded-lg">
                                    <div class="text-center p-8" :class="{ 'text-right': isRTL }">
                                        <div
                                            class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-lock text-gray-500 dark:text-gray-400 text-xl"></i>
                                        </div>
                                        <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            {{ getTranslation('lesson.content_locked') }}
                                        </h4>
                                        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md">
                                            {{ getTranslation('lesson.content_locked_description') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Blurred Content Preview -->
                                <div class="prose dark:prose-invert max-w-none mb-8 filter blur-sm select-none pointer-events-none"
                                    :class="{ 'text-right': isRTL }">
                                    <div class="text-gray-500 dark:text-gray-500 leading-relaxed">
                                        {{ getLocalizedContent(content, 'content').substring(0, 300) }}...
                                    </div>
                                    <div class="space-y-3 mt-4">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full"></div>
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <!-- Comments Header -->
                        <div class="flex items-center justify-between mb-6" :class="{ 'flex-row-reverse': isRTL }">
                            <h3 :class="[
                                'text-2xl font-bold',
                                isEnrolled
                                    ? 'text-gray-900 dark:text-white'
                                    : 'text-gray-600 dark:text-gray-400'
                            ]">
                                {{ getTranslation('comments.title') }} ({{ commentsCount }})
                            </h3>
                            <button @click="showComments = !showComments"
                                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                <i :class="showComments ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                            </button>
                        </div>

                        <div v-if="showComments">
                            <!-- Enrollment required notice -->
                            <div v-if="!isEnrolled"
                                class="mb-8 p-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                                <div class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                    <i class="fas fa-lock text-amber-600 dark:text-amber-400"
                                        :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                    <div class="flex-1" :class="{ 'text-right': isRTL }">
                                        <h4 class="font-semibold text-amber-800 dark:text-amber-200">
                                            {{ getTranslation('comments.locked') }}
                                        </h4>
                                        <p class="text-amber-700 dark:text-amber-300 text-sm mt-1">
                                            {{ getTranslation('comments.locked_description') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Comment Form (Enrolled Users Only) -->
                            <div v-else-if="auth?.user" class="mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
                                    :class="{ 'text-right': isRTL }">
                                    {{ getTranslation('comments.add_comment') }}
                                </h4>

                                <form @submit.prevent="submitComment">
                                    <div class="mb-4">
                                        <textarea v-model="commentForm.comment" rows="4"
                                            :placeholder="getTranslation('comments.placeholder')"
                                            class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                                            :class="{
                                                'border-red-500 focus:ring-red-500': commentForm.errors.comment,
                                                'border-gray-300 dark:border-gray-600': !commentForm.errors.comment,
                                                'text-right': isRTL
                                            }"></textarea>

                                        <div v-if="commentForm.errors.comment"
                                            class="mt-2 text-red-600 dark:text-red-400 text-sm"
                                            :class="{ 'text-right': isRTL }">
                                            {{ commentForm.errors.comment }}
                                        </div>
                                    </div>

                                    <div class="flex justify-end" :class="{ 'justify-start': isRTL }">
                                        <button type="submit"
                                            :disabled="commentForm.processing || !commentForm.comment.trim()"
                                            class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg font-semibold transition-colors flex items-center"
                                            :class="{ 'flex-row-reverse': isRTL }">
                                            <i v-if="commentForm.processing" class="fas fa-spinner fa-spin"
                                                :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                            <i v-else class="fas fa-comment" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                            {{ commentForm.processing ? getTranslation('comments.posting') :
                                            getTranslation('comments.post_comment') }}
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Login prompt for guests -->
                            <div v-else-if="isEnrolled"
                                class="mb-8 p-6 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"
                                        :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                    <div :class="{ 'text-right': isRTL }">
                                        <p class="text-blue-800 dark:text-blue-200">
                                            {{ getTranslation('comments.login_prompt') }}
                                            <Link href="/login" class="font-semibold underline hover:no-underline">
                                            {{ getTranslation('breadcrumb.home') }}
                                            </Link>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments List (Enrolled Users Only) -->
                            <div v-if="isEnrolled && commentsCount > 0" class="space-y-6">
                                <div v-for="comment in sortedComments" :key="comment.id"
                                    class="flex p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    :class="isRTL ? 'space-x-reverse space-x-4 flex-row-reverse' : 'space-x-4'">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0">
                                        <div v-if="comment.user?.avatar" class="w-10 h-10 rounded-full overflow-hidden">
                                            <img :src="comment.user.avatar" :alt="comment.user?.name || 'User'"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div v-else
                                            class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ getInitials(comment.user?.name || 'Anonymous User') }}
                                        </div>
                                    </div>

                                    <!-- Comment Content -->
                                    <div class="flex-1" :class="{ 'text-right': isRTL }">
                                        <div class="flex items-center mb-2"
                                            :class="isRTL ? 'space-x-reverse space-x-2 flex-row-reverse' : 'space-x-2'">
                                            <h5 class="font-semibold text-gray-900 dark:text-white">
                                                {{ comment.user?.name || 'Anonymous User' }}
                                            </h5>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ formatDate(comment.created_at) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ comment.comment }}
                                        </p>

                                        <!-- Comment Actions -->
                                        <div class="flex items-center mt-3"
                                            :class="isRTL ? 'space-x-reverse space-x-4 flex-row-reverse justify-end' : 'space-x-4'">
                                            <button
                                                v-if="auth?.user?.id === comment.user_id || auth?.user?.role === 'admin'"
                                                @click="deleteComment(comment.id)"
                                                class="text-gray-500 hover:text-red-600 dark:hover:text-red-400 text-sm transition-colors flex items-center"
                                                :class="{ 'flex-row-reverse': isRTL }">
                                                <i class="fas fa-trash" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                                {{ getTranslation('comments.delete') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- No Comments State -->
                            <div v-else-if="isEnrolled && commentsCount === 0" class="text-center py-12">
                                <i class="fas fa-comments text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">
                                    {{ getTranslation('comments.no_comments') }}
                                </h4>
                                <p class="text-gray-500 dark:text-gray-500">
                                    {{ getTranslation('comments.no_comments_description') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Course Playlist -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-32">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4"
                            :class="{ 'text-right': isRTL }">
                            {{ getTranslation('sidebar.course_content') }}
                        </h3>

                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            <div v-for="lesson in allLessons" :key="lesson.id" :class="[
                                'border rounded-lg p-3 transition-colors',
                                lesson.id === content.id
                                    ? 'bg-blue-50 dark:bg-blue-900/30 border-blue-200 dark:border-blue-700'
                                    : 'border-gray-200 dark:border-gray-700',
                                isEnrolled
                                    ? 'hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer'
                                    : 'opacity-75'
                            ]">

                                <Link v-if="isEnrolled" :href="route('course.content', {
                                    course_id: lesson.course_id,
                                    content_id: lesson.id
                                })" class="block">
                                <div class="flex items-center justify-between" :class="{ 'flex-row-reverse': isRTL }">
                                    <div class="flex items-center"
                                        :class="isRTL ? 'space-x-reverse space-x-3 flex-row-reverse' : 'space-x-3'">
                                        <div :class="[
                                            'w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium',
                                            lesson.id === content.id
                                                ? 'bg-blue-600 text-white'
                                                : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300'
                                        ]">
                                            {{ lesson.sort_order }}
                                        </div>
                                        <div class="flex-1" :class="{ 'text-right': isRTL }">
                                            <h4 class="font-medium text-gray-900 dark:text-white text-sm line-clamp-2">
                                                {{ getLocalizedContent(lesson, 'title') }}
                                            </h4>
                                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1"
                                                :class="isRTL ? 'space-x-reverse space-x-2 flex-row-reverse' : 'space-x-2'">
                                                <div class="flex items-center" :class="{ 'flex-row-reverse': isRTL }">
                                                    <i v-if="lesson.video_url" :class="[
                                                        'fas',
                                                        isRTL ? 'ml-1' : 'mr-1',
                                                        isDirectVideoFile(lesson.video_url) ? 'fa-play-circle text-green-500' : 'fa-play text-blue-500'
                                                    ]"></i>
                                                    <span>15 {{ getTranslation('lesson.min') }}</span>
                                                </div>
                                                <div v-if="lesson.video_url" class="text-xs px-2 py-0.5 rounded-full"
                                                    :class="[
                                                        isDirectVideoFile(lesson.video_url)
                                                            ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400'
                                                            : 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400'
                                                    ]">
                                                    {{ isDirectVideoFile(lesson.video_url) ?
                                                        getTranslation('sidebar.hd') : getTranslation('sidebar.stream') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="lesson.id === content.id" class="text-blue-600 dark:text-blue-400">
                                        <i class="fas fa-play text-sm"></i>
                                    </div>
                                </div>
                                </Link>

                                <div v-else class="block">
                                    <div class="flex items-center justify-between"
                                        :class="{ 'flex-row-reverse': isRTL }">
                                        <div class="flex items-center"
                                            :class="isRTL ? 'space-x-reverse space-x-3 flex-row-reverse' : 'space-x-3'">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-sm font-medium text-gray-400">
                                                {{ lesson.sort_order }}
                                            </div>
                                            <div class="flex-1" :class="{ 'text-right': isRTL }">
                                                <h4
                                                    class="font-medium text-gray-500 dark:text-gray-400 text-sm line-clamp-2">
                                                    {{ getLocalizedContent(lesson, 'title') }}
                                                </h4>
                                                <div class="flex items-center text-xs text-gray-400 dark:text-gray-500 mt-1"
                                                    :class="{ 'flex-row-reverse': isRTL }">
                                                    <i v-if="lesson.video_url" class="fas fa-play"
                                                        :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                                    <span>15 {{ getTranslation('lesson.min') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-gray-400">
                                            <i class="fas fa-lock text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Actions -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
                            <Link :href="(route('frontend.show.course', { id: content.course_id }))"
                                class="w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-lg font-medium transition-colors text-center block flex items-center justify-center"
                                :class="{ 'flex-row-reverse': isRTL }">
                            <i class="fas fa-arrow-left" :class="[isRTL ? 'ml-2 fas fa-arrow-right' : 'mr-2']"></i>
                            {{ getTranslation('sidebar.back_to_course') }}
                            </Link>
                            <button v-if="isEnrolled"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors flex items-center justify-center"
                                :class="{ 'flex-row-reverse': isRTL }">
                                <i class="fas fa-download" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                {{ getTranslation('sidebar.download_resources') }}
                            </button>
                            <div v-else>
                                <Link :href="route('enroll.page', { id: content.course_id })"
                                    class="w-full bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white py-2 px-4 rounded-lg font-medium transition-colors flex items-center justify-center"
                                    :class="{ 'flex-row-reverse': isRTL }">
                                <i v-if="enrollForm.processing" class="fas fa-spinner fa-spin"
                                    :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                <i v-else class="fas fa-unlock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                {{ enrollForm.processing ? getTranslation('enrollment.processing') :
                                    getTranslation('sidebar.enroll_to_access') }}
                                </Link>
                            </div>
                        </div>
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

/* Custom scrollbar for playlist */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.5);
    border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.7);
}

/* Video player styles */
video {
    background-color: #000;
}

video::-webkit-media-controls-panel {
    background-color: rgba(0, 0, 0, 0.8);
}

/* Video quality indicators */
.video-quality-hd {
    background: linear-gradient(45deg, #10b981, #059669);
}

.video-quality-stream {
    background: linear-gradient(45deg, #3b82f6, #2563eb);
}
</style>