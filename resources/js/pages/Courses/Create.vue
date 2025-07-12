<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    Save,
    X,
    DollarSign,
    Video,
    Eye,
    FileText,
    BookOpen
} from 'lucide-vue-next';

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
        title: 'Create Course',
        href: '/courses/create',
    },
];

const form = useForm({
    title_en: '',
    title_ar: '',
    description_en: '',
    description_ar: '',
    price: 0,
    preview_video_url: '',
    is_published: false,
});

const isSubmitting = ref(false);

const submitForm = () => {
    isSubmitting.value = true;
    form.post('/courses', {
        onFinish: () => {
            isSubmitting.value = false;
        },
        onSuccess: () => {
            // Form will redirect automatically on success
        },
        onError: () => {
            // Errors will be handled by the form object
        }
    });
};
</script>

<template>

    <Head title="Create Course" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Course</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add a new course to your platform</p>
                </div>
                <div class="flex gap-3">
                    <a href="/courses"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <X class="h-4 w-4" />
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Course Form -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <form @submit.prevent="submitForm" class="space-y-6">

                    <!-- Course Titles -->
                    <div class="grid gap-6 lg:grid-cols-2">
                        <!-- English Title -->
                        <div>
                            <label for="title_en"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                English Title *
                            </label>
                            <div class="relative">
                                <input id="title_en" v-model="form.title_en" type="text"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter course title in English"
                                    :class="{ 'border-red-500': form.errors.title_en }" />
                                <BookOpen
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.title_en" class="mt-1 text-sm text-red-600">{{ form.errors.title_en }}
                            </p>
                        </div>

                        <!-- Arabic Title -->
                        <div>
                            <label for="title_ar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Arabic Title *
                            </label>
                            <div class="relative">
                                <input id="title_ar" v-model="form.title_ar" type="text" dir="rtl"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="أدخل عنوان الدورة بالعربية"
                                    :class="{ 'border-red-500': form.errors.title_ar }" />
                                <BookOpen
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.title_ar" class="mt-1 text-sm text-red-600">{{ form.errors.title_ar }}
                            </p>
                        </div>
                    </div>

                    <!-- Course Descriptions -->
                    <div class="grid gap-6 lg:grid-cols-2">
                        <!-- English Description -->
                        <div>
                            <label for="description_en"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                English Description *
                            </label>
                            <div class="relative">
                                <textarea id="description_en" v-model="form.description_en" rows="6"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    placeholder="Describe your course in detail..."
                                    :class="{ 'border-red-500': form.errors.description_en }"></textarea>
                                <FileText class="absolute right-3 top-3 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.description_en" class="mt-1 text-sm text-red-600">{{
                                form.errors.description_en }}</p>
                        </div>

                        <!-- Arabic Description -->
                        <div>
                            <label for="description_ar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Arabic Description *
                            </label>
                            <div class="relative">
                                <textarea id="description_ar" v-model="form.description_ar" rows="6" dir="rtl"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    placeholder="اكتب وصف الدورة بالتفصيل..."
                                    :class="{ 'border-red-500': form.errors.description_ar }"></textarea>
                                <FileText class="absolute left-3 top-3 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.description_ar" class="mt-1 text-sm text-red-600">{{
                                form.errors.description_ar }}</p>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div class="grid gap-6 lg:grid-cols-2">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Course Price (KWD) *
                            </label>
                            <div class="relative">
                                <input id="price" v-model.number="form.price" type="number" step="0.01" min="0"
                                    class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="0.00" :class="{ 'border-red-500': form.errors.price }" />
                                <DollarSign
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.price" class="mt-1 text-sm text-red-600">{{ form.errors.price }}</p>
                            <p class="mt-1 text-xs text-gray-500">Set to 0 for free courses</p>
                        </div>

                        <!-- Preview Video URL -->
                        <div>
                            <label for="preview_video_url"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Preview Video URL
                            </label>
                            <div class="relative">
                                <input id="preview_video_url" v-model="form.preview_video_url" type="url"
                                    class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://youtube.com/watch?v=..."
                                    :class="{ 'border-red-500': form.errors.preview_video_url }" />
                                <Video
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.preview_video_url" class="mt-1 text-sm text-red-600">{{
                                form.errors.preview_video_url }}</p>
                            <p class="mt-1 text-xs text-gray-500">Optional: YouTube or Vimeo URL</p>
                        </div>
                    </div>

                    <!-- Publishing Options -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Publishing Options</h3>

                        <div class="flex items-center gap-3">
                            <input id="is_published" v-model="form.is_published" type="checkbox"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            <label for="is_published"
                                class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                <Eye class="h-4 w-4" />
                                Publish course immediately
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            If unchecked, the course will be saved as a draft and won't be visible to students
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <a href="/courses"
                            class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" :disabled="form.processing || isSubmitting"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <Save class="h-4 w-4" />
                            <span v-if="form.processing || isSubmitting">Creating...</span>
                            <span v-else>Create Course</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Custom styles for better form appearance */
input:focus,
textarea:focus {
    outline: none;
}
</style>