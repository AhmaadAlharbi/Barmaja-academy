<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Edit,
    Trash2,
    Video,
    BookOpen,
    CheckCircle,
    XCircle,
    Calendar,
    Globe,
    Clock,
    FileText,
    Eye,
    EyeOff,
    Hash,
    Play,
    ExternalLink
} from 'lucide-vue-next';

interface CourseContent {
    id: number;
    title_ar: string;
    title_en: string;
    content_ar: string;
    content_en: string;
    video_url?: string | null;
    sort_order: number;
    is_active: boolean;
    created_at: string;
    updated_at: string;
}

interface Course {
    id: number;
    title_en: string;
    title_ar: string;
    slug: string;
}

const props = defineProps<{
    course: Course;
    content: CourseContent;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Courses',
        href: '/courses',
    },
    {
        title: props.course.title_en,
        href: `/courses/${props.course.id}`,
    },
    {
        title: props.content.title_en,
        href: `/courses/${props.course.id}/content/${props.content.id}`,
    },
];

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getWordCount = (text: string) => {
    if (!text) return 0;
    return text.trim().split(/\s+/).length;
};

const deleteContent = () => {
    if (confirm(`Are you sure you want to delete "${props.content.title_en}"? This action cannot be undone.`)) {
        router.delete(`/courses/${props.course.id}/content/${props.content.id}`, {
            onSuccess: () => {
                // Will redirect to course show page
            }
        });
    }
};

const toggleContentActive = () => {
    router.post(`/courses/${props.course.id}/content/${props.content.id}/toggle-active`);
};

const getYouTubeVideoId = (url: string) => {
    if (!url) return null;
    const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/);
    return match ? match[1] : null;
};

const isYouTubeUrl = (url: string) => {
    return url && (url.includes('youtube.com') || url.includes('youtu.be'));
};
</script>

<template>

    <Head :title="content.title_en" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link :href="`/courses/${course.id}`"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <ArrowLeft class="h-5 w-5" />
                    </Link>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ content.title_en }}</h1>
                            <!-- Status Badge -->
                            <span v-if="content.is_active"
                                class="inline-flex items-center gap-1 px-3 py-1 text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                <CheckCircle class="h-4 w-4" />
                                Active
                            </span>
                            <span v-else
                                class="inline-flex items-center gap-1 px-3 py-1 text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 rounded-full">
                                <XCircle class="h-4 w-4" />
                                Inactive
                            </span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400" dir="rtl">{{ content.title_ar }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Lesson {{ content.sort_order }} in {{ course.title_en }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="toggleContentActive" :class="[
                        'inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-colors',
                        content.is_active
                            ? 'bg-red-600 hover:bg-red-700 text-white'
                            : 'bg-green-600 hover:bg-green-700 text-white'
                    ]">
                        <EyeOff v-if="content.is_active" class="h-4 w-4" />
                        <Eye v-else class="h-4 w-4" />
                        {{ content.is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                    <Link :href="`/courses/${course.id}/content/${content.id}/edit`"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <Edit class="h-4 w-4" />
                    Edit
                    </Link>
                    <button @click="deleteContent"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <Trash2 class="h-4 w-4" />
                        Delete
                    </button>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Video Section -->
                    <div v-if="content.video_url"
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="h-12 w-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                <Video class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Lesson Video</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Watch the lesson content</p>
                            </div>
                        </div>

                        <!-- YouTube Embed or Link -->
                        <div v-if="isYouTubeUrl(content.video_url)"
                            class="aspect-video bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <iframe :src="`https://www.youtube.com/embed/${getYouTubeVideoId(content.video_url)}`"
                                class="w-full h-full" frameborder="0" allowfullscreen>
                            </iframe>
                        </div>
                        <div v-else class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <a :href="content.video_url" target="_blank"
                                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <Play class="h-4 w-4" />
                                {{ content.video_url }}
                                <ExternalLink class="h-3 w-3" />
                            </a>
                        </div>
                    </div>

                    <!-- English Content -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="h-12 w-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <Globe class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">English Content</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ getWordCount(content.content_en)
                                    }} words</p>
                            </div>
                        </div>

                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-gray-900 dark:text-white whitespace-pre-wrap leading-relaxed">{{
                                    content.content_en }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="h-12 w-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                <Globe class="h-6 w-6 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Arabic Content</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ getWordCount(content.content_ar)
                                    }} words</p>
                            </div>
                        </div>

                        <div class="prose prose-gray dark:prose-invert max-w-none" dir="rtl">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-gray-900 dark:text-white whitespace-pre-wrap leading-relaxed">{{
                                    content.content_ar }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Content Details -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Content Details</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <Hash class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Lesson Order</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ content.sort_order }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Calendar class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Created</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{
                                        formatDate(content.created_at) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Clock class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Last Updated</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{
                                        formatDate(content.updated_at) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <FileText class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Content Length</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ getWordCount(content.content_en) + getWordCount(content.content_ar) }} total
                                        words
                                    </p>
                                </div>
                            </div>

                            <div v-if="content.video_url" class="flex items-center gap-3">
                                <Video class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Video</p>
                                    <p class="font-medium text-green-600 dark:text-green-400">Available</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Context -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Context</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <BookOpen class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Course</p>
                                    <Link :href="`/courses/${course.id}`"
                                        class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    {{ course.title_en }}
                                    </Link>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Globe class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Course (Arabic)</p>
                                    <p class="font-medium text-gray-900 dark:text-white" dir="rtl">{{ course.title_ar }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <Link :href="`/courses/${course.id}/content/${content.id}/edit`"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <Edit class="h-4 w-4" />
                            Edit Content
                            </Link>

                            <button @click="toggleContentActive" :class="[
                                'w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg transition-colors',
                                content.is_active
                                    ? 'bg-red-600 hover:bg-red-700 text-white'
                                    : 'bg-green-600 hover:bg-green-700 text-white'
                            ]">
                                <EyeOff v-if="content.is_active" class="h-4 w-4" />
                                <Eye v-else class="h-4 w-4" />
                                {{ content.is_active ? 'Deactivate' : 'Activate' }}
                            </button>

                            <button @click="deleteContent"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <Trash2 class="h-4 w-4" />
                                Delete Content
                            </button>

                            <Link :href="`/courses/${course.id}`"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <ArrowLeft class="h-4 w-4" />
                            Back to Course
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>