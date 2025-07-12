<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Edit,
    Trash2,
    PenTool,
    CheckCircle,
    XCircle,
    User,
    Calendar,
    Globe,
    Clock,
    FileText,
    Eye
} from 'lucide-vue-next';

interface BlogPost {
    id: number;
    title_en: string;
    title_ar: string;
    slug: string;
    content_ar: string;
    content_en: string;
    is_published: boolean;
    published_at?: string | null;
    created_at: string;
    updated_at: string;
    author?: {
        id: number;
        name: string;
    };
}

const props = defineProps<{
    blogPost: BlogPost;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Blog Posts',
        href: '/blogs',
    },
    {
        title: props.blogPost.title_en,
        href: `/blogs/${props.blogPost.id}`,
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

const deleteBlogPost = () => {
    if (confirm(`Are you sure you want to delete "${props.blogPost.title_en}"? This action cannot be undone.`)) {
        router.delete(`/blogs/${props.blogPost.id}`, {
            onSuccess: () => {
                // Will redirect to index with success message
            }
        });
    }
};

const getWordCount = (text: string) => {
    return text.trim().split(/\s+/).length;
};

const getReadingTime = (text: string) => {
    const wordsPerMinute = 200;
    const words = getWordCount(text);
    return Math.ceil(words / wordsPerMinute);
};
</script>

<template>

    <Head :title="blogPost.title_en" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link href="/blogs"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <ArrowLeft class="h-5 w-5" />
                    </Link>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ blogPost.title_en }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ blogPost.title_ar }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <Link :href="`/blogs/${blogPost.id}/edit`"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <Edit class="h-4 w-4" />
                    Edit Post
                    </Link>
                    <button @click="deleteBlogPost"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <Trash2 class="h-4 w-4" />
                        Delete
                    </button>
                </div>
            </div>

            <!-- Blog Post Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Blog Post Content Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="h-12 w-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                <PenTool class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Blog Post Content</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Full blog post content</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- English Content -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <Globe class="inline h-4 w-4 mr-1" />
                                    Content (English)
                                </label>
                                <div class="prose prose-sm max-w-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="text-gray-900 dark:text-white whitespace-pre-wrap">{{
                                        blogPost.content_en }}</div>
                                </div>
                            </div>

                            <!-- Arabic Content -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <Globe class="inline h-4 w-4 mr-1" />
                                    Content (Arabic)
                                </label>
                                <div class="prose prose-sm max-w-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg"
                                    dir="rtl">
                                    <div class="text-gray-900 dark:text-white whitespace-pre-wrap">{{
                                        blogPost.content_ar }}</div>
                                </div>
                            </div>

                            <!-- Blog Post Slug -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blog Post
                                    Slug</label>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <code class="text-sm text-blue-600 dark:text-blue-400">{{ blogPost.slug }}</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Statistics -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="h-12 w-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <FileText class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Content Statistics</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Reading metrics and word counts</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{
                                    getWordCount(blogPost.content_en) }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Words (EN)</div>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{
                                    getWordCount(blogPost.content_ar) }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Words (AR)</div>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{
                                    getReadingTime(blogPost.content_en) }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Min Read (EN)</div>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{
                                    getReadingTime(blogPost.content_ar) }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Min Read (AR)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Blog Post Status -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Post Status</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Publication Status</span>
                                <span v-if="blogPost.is_published === 1 || blogPost.is_published === true"
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

                            <div v-if="blogPost.published_at" class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Published Date</span>
                                <div class="flex items-center gap-1">
                                    <Calendar class="h-4 w-4 text-gray-400" />
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ formatDate(blogPost.published_at).split(',')[0] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Post Meta -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Post Details</h3>
                        <div class="space-y-4">
                            <div v-if="blogPost.author" class="flex items-center gap-3">
                                <User class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Author</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ blogPost.author.name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Calendar class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Created</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{
                                        formatDate(blogPost.created_at) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Clock class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Last Updated</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{
                                        formatDate(blogPost.updated_at) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <FileText class="h-4 w-4 text-gray-400" />
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Words</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ getWordCount(blogPost.content_en) + getWordCount(blogPost.content_ar) }}
                                        words
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
                            <Link :href="`/blogs/${blogPost.id}/edit`"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <Edit class="h-4 w-4" />
                            Edit Post
                            </Link>

                            <button @click="deleteBlogPost"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <Trash2 class="h-4 w-4" />
                                Delete Post
                            </button>

                            <Link href="/blogs"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <ArrowLeft class="h-4 w-4" />
                            Back to Blog Posts
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>