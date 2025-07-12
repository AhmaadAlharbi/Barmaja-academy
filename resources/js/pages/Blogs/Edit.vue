<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    ArrowLeft,
    Save,
    X,
    PenTool,
    Globe,
    FileText,
    Eye,
    EyeOff,
    AlertCircle,
    User,
    Calendar
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
    {
        title: 'Edit',
        href: `/blogs/${props.blogPost.id}/edit`,
    },
];

const form = useForm({
    title_en: props.blogPost.title_en,
    title_ar: props.blogPost.title_ar,
    content_en: props.blogPost.content_en,
    content_ar: props.blogPost.content_ar,
    is_published: props.blogPost.is_published,
});

const showPreview = ref(false);

const submitForm = () => {
    form.put(`/blogs/${props.blogPost.id}`, {
        onSuccess: () => {
            // Success message will be handled by the backend
        }
    });
};

const togglePreview = () => {
    showPreview.value = !showPreview.value;
};

const getWordCount = (text: string) => {
    if (!text) return 0;
    return text.trim().split(/\s+/).length;
};

const getReadingTime = (text: string) => {
    if (!text) return 0;
    const wordsPerMinute = 200;
    const words = getWordCount(text);
    return Math.ceil(words / wordsPerMinute);
};
</script>

<template>

    <Head :title="`Edit ${blogPost.title_en}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link :href="`/blogs/${blogPost.id}`"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <ArrowLeft class="h-5 w-5" />
                    </Link>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Blog Post</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ blogPost.title_en }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="togglePreview"
                        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <Eye v-if="!showPreview" class="h-4 w-4" />
                        <EyeOff v-else class="h-4 w-4" />
                        {{ showPreview ? 'Hide Preview' : 'Show Preview' }}
                    </button>
                </div>
            </div>

            <form @submit.prevent="submitForm">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="h-12 w-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                    <PenTool class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Edit blog post details</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- English Title -->
                                <div>
                                    <label for="title_en"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <Globe class="inline h-4 w-4 mr-1" />
                                        Blog Title (English) *
                                    </label>
                                    <input id="title_en" v-model="form.title_en" type="text" required maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter blog title in English" />
                                    <div v-if="form.errors.title_en"
                                        class="flex items-center gap-2 mt-2 text-sm text-red-600 dark:text-red-400">
                                        <AlertCircle class="h-4 w-4" />
                                        {{ form.errors.title_en }}
                                    </div>
                                </div>

                                <!-- Arabic Title -->
                                <div>
                                    <label for="title_ar"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <Globe class="inline h-4 w-4 mr-1" />
                                        Blog Title (Arabic) *
                                    </label>
                                    <input id="title_ar" v-model="form.title_ar" type="text" required maxlength="255"
                                        dir="rtl"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="أدخل عنوان المقال بالعربية" />
                                    <div v-if="form.errors.title_ar"
                                        class="flex items-center gap-2 mt-2 text-sm text-red-600 dark:text-red-400">
                                        <AlertCircle class="h-4 w-4" />
                                        {{ form.errors.title_ar }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="h-12 w-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <FileText class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Blog Content</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Write your blog post content</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- English Content -->
                                <div>
                                    <label for="content_en"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <FileText class="inline h-4 w-4 mr-1" />
                                        Content (English) *
                                    </label>
                                    <textarea id="content_en" v-model="form.content_en" required rows="8" minlength="50"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-vertical"
                                        placeholder="Write your blog post content in English (minimum 50 characters)"></textarea>
                                    <div class="flex items-center justify-between mt-2">
                                        <div v-if="form.errors.content_en"
                                            class="flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
                                            <AlertCircle class="h-4 w-4" />
                                            {{ form.errors.content_en }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ getWordCount(form.content_en) }} words • {{
                                            getReadingTime(form.content_en) }} min read
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Content -->
                                <div>
                                    <label for="content_ar"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <FileText class="inline h-4 w-4 mr-1" />
                                        Content (Arabic) *
                                    </label>
                                    <textarea id="content_ar" v-model="form.content_ar" required rows="8" minlength="50"
                                        dir="rtl"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-vertical"
                                        placeholder="اكتب محتوى مقالك بالعربية (50 حرف على الأقل)"></textarea>
                                    <div class="flex items-center justify-between mt-2">
                                        <div v-if="form.errors.content_ar"
                                            class="flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
                                            <AlertCircle class="h-4 w-4" />
                                            {{ form.errors.content_ar }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ getWordCount(form.content_ar) }} words • {{
                                            getReadingTime(form.content_ar) }} min read
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div v-if="showPreview"
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Blog Post Preview</h3>
                            <div class="space-y-6">
                                <!-- English Preview -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ form.title_en || 'Blog Title (English)' }}
                                    </h4>
                                    <div class="prose prose-sm max-w-none">
                                        <div class="text-gray-900 dark:text-white whitespace-pre-wrap">
                                            {{ form.content_en || 'English content will appear here...' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Preview -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg" dir="rtl">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ form.title_ar || 'عنوان المقال (العربية)' }}
                                    </h4>
                                    <div class="prose prose-sm max-w-none">
                                        <div class="text-gray-900 dark:text-white whitespace-pre-wrap">
                                            {{ form.content_ar || 'المحتوى العربي سيظهر هنا...' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Publication Settings -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Publication Settings
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <label for="is_published"
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Publish Blog Post
                                        </label>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Make this post visible to
                                            readers</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input id="is_published" v-model="form.is_published" type="checkbox"
                                            class="sr-only peer" />
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Content Statistics -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Content Statistics</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">English Words</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{
                                        getWordCount(form.content_en) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Arabic Words</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{
                                        getWordCount(form.content_ar) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Reading Time (EN)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{
                                        getReadingTime(form.content_en) }} min</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Reading Time (AR)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{
                                        getReadingTime(form.content_ar) }} min</span>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Post Info -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Post Info</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Post ID</span>
                                    <span class="font-medium text-gray-900 dark:text-white">#{{ blogPost.id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Current Slug</span>
                                    <code class="text-xs text-blue-600 dark:text-blue-400">{{ blogPost.slug }}</code>
                                </div>
                                <div v-if="blogPost.author" class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Author</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ blogPost.author.name
                                        }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Created</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ new Date(blogPost.created_at).toLocaleDateString() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                            <div class="space-y-3">
                                <button type="submit" :disabled="form.processing"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                    <Save class="h-4 w-4" />
                                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                                </button>

                                <Link :href="`/blogs/${blogPost.id}`"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <X class="h-4 w-4" />
                                Cancel
                                </Link>

                                <Link href="/blogs"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <ArrowLeft class="h-4 w-4" />
                                Back to Blog Posts
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>