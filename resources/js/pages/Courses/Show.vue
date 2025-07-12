<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Edit,
    Trash2,
    DollarSign,
    Video,
    BookOpen,
    CheckCircle,
    XCircle,
    User,
    Calendar,
    Globe,
    Clock,
    FileText,
    Eye
} from 'lucide-vue-next';

interface Course {
    id: number;
    title_en: string;
    title_ar: string;
    slug: string;
    description_ar: string;
    description_en: string;
    price: number;
    is_published: boolean;
    preview_video_url?: string | null;
    created_at: string;
    updated_at: string;
    author?: {
        id: number;
        name: string;
    };
    contents?: Array<{
        id: number;
        title: string;
        type: string;
        sort_order: number;
        is_active: boolean;
    }>;
}

const props = defineProps<{
    course: Course;
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
];

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-KW', {
        style: 'currency',
        currency: 'KWD'
    }).format(amount);
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const deleteCourse = () => {
    if (confirm(`Are you sure you want to delete "${props.course.title_en}"? This action cannot be undone.`)) {
        router.delete(`/courses/${props.course.id}`, {
            onSuccess: () => {
                // Will redirect to index with success message
            }
        });
    }
};
</script>

<template>

    <Head :title="course.title_en" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link href="/courses"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <ArrowLeft class="h-5 w-5" />
                    </Link>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ course.title_en }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ course.title_ar }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <Link :href="`/courses/${course.id}/edit`"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <Edit class="h-4 w-4" />
                    Edit Course
                    </Link>
                    <button @click="deleteCourse"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <Trash2 class="h-4 w-4" />
                        Delete
                    </button>
                </div>
            </div>

            <!-- Course Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Course Info Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="h-12 w-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <BookOpen class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Course Information</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Basic course details</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- English Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <Globe class="inline h-4 w-4 mr-1" />
                                    Description (English)
                                </label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">{{ course.description_en }}</p>
                                </div>
                            </div>

                            <!-- Arabic Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <Globe class="inline h-4 w-4 mr-1" />
                                    Description (Arabic)
                                </label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg" dir="rtl">
                                    <p class="text-gray-900 dark:text-white">{{ course.description_ar }}</p>
                                </div>
                            </div>

                            <!-- Course Slug -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course
                                    Slug</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <code class="text-sm text-blue-600 dark:text-blue-400">{{ course.slug }}</code>
                                </div>
                            </div>

                            <!-- Preview Video -->
                            <div v-if="course.preview_video_url">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <Video class="inline h-4 w-4 mr-1" />
                                    Preview Video
                                </label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <a :href="course.preview_video_url" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
                                        {{ course.preview_video_url }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Contents -->
                    <div v-if="course.contents && course.contents.length > 0"
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="h-12 w-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                <FileText class="h-6 w-6 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Course Contents</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ course.contents.length }} items
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div v-for="content in course.contents" :key="content.id"
                                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-8 w-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400">{{
                                            content.sort_order }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ content.title }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 capitalize">{{ content.type
                                            }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span v-if="content.is_active"
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                        <CheckCircle class="h-2 w-2" />
                                        Active
                                    </span>
                                    <span v-else
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400 rounded-full">
                                        <XCircle class="h-2 w-2" />
                                        Inactive
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Course Status -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Status</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Publication Status</span>
                                <span v-if="course.is_published === 1 || course.is_published === true"
                                    class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                    <CheckCircle class="h-3 w-3" />
                                    Published
                                </span>
                                <span v-else
                                    class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">
                                    <XCircle class="h-3 w-3" />
                                    Draft
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Price</span>
                                <div class="flex items-center gap-1">
                                    <DollarSign class="h-4 w-4 text-gray-400" />
                                    <span
                                        :class="course.price === 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-900 dark:text-white'"
                                        class="font-medium">
                                        {{ course.price === 0 ? 'Free' : formatCurrency(course.price) }}
                                    </span>
                                </div>
                            </div>

                            <div v-if="course.preview_video_url" class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Preview Video</span>
                                <Video class="h-4 w-4 text-green-500" />
                            </div>
                        </div>
                    </div>

                    <!-- Course Meta -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Details</h3>
                        <div class="space-y-4">
                            <div v-if="course.author" class="flex items-center gap-3">
                                <User class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Author</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ course.author.name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Calendar class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Created</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{
                                        formatDate(course.created_at) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Clock class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Last Updated</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{
                                        formatDate(course.updated_at) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <FileText class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Contents</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ course.contents?.length || 0 }} items
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
                            <Link :href="`/courses/${course.id}/edit`"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <Edit class="h-4 w-4" />
                            Edit Course
                            </Link>

                            <button @click="deleteCourse"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <Trash2 class="h-4 w-4" />
                                Delete Course
                            </button>

                            <Link href="/courses"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <ArrowLeft class="h-4 w-4" />
                            Back to Courses
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>