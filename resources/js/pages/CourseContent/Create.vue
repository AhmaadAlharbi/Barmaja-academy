<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    Save,
    X,
    Video,
    Eye,
    FileText,
    BookOpen,
    Hash,
    ToggleLeft
} from 'lucide-vue-next';

interface Props {
    course: {
        id: number;
        title_en: string;
        title_ar: string;
    };
}

const props = defineProps<Props>();

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
        title: 'Add Content',
        href: `/courses/${props.course.id}/content/create`,
    },
];

const form = useForm({
    title_en: '',
    title_ar: '',
    content_en: '',
    content_ar: '',
    video_url: '',
    sort_order: 1,
    is_active: true,
});

const isSubmitting = ref(false);

const submitForm = () => {
    isSubmitting.value = true;
    form.post(`/courses/${props.course.id}/content`, {
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

    <Head title="Add Course Content" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add Course Content</h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Add new lesson content to: {{ props.course.title_en }}
                    </p>
                </div>
                <div class="flex gap-3">
                    <a :href="`/courses/${props.course.id}`"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <X class="h-4 w-4" />
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Course Content Form -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <form @submit.prevent="submitForm" class="space-y-6">

                    <!-- Lesson Titles -->
                    <div class="grid gap-6 lg:grid-cols-2">
                        <!-- English Title -->
                        <div>
                            <label for="title_en"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                English Lesson Title *
                            </label>
                            <div class="relative">
                                <input id="title_en" v-model="form.title_en" type="text"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter lesson title in English"
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
                                Arabic Lesson Title *
                            </label>
                            <div class="relative">
                                <input id="title_ar" v-model="form.title_ar" type="text" dir="rtl"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="أدخل عنوان الدرس بالعربية"
                                    :class="{ 'border-red-500': form.errors.title_ar }" />
                                <BookOpen
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.title_ar" class="mt-1 text-sm text-red-600">{{ form.errors.title_ar }}
                            </p>
                        </div>
                    </div>

                    <!-- Lesson Content -->
                    <div class="grid gap-6 lg:grid-cols-2">
                        <!-- English Content -->
                        <div>
                            <label for="content_en"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                English Lesson Content *
                            </label>
                            <div class="relative">
                                <textarea id="content_en" v-model="form.content_en" rows="12"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    placeholder="Write the lesson content in detail..."
                                    :class="{ 'border-red-500': form.errors.content_en }"></textarea>
                                <FileText class="absolute right-3 top-3 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.content_en" class="mt-1 text-sm text-red-600">{{
                                form.errors.content_en }}</p>
                        </div>

                        <!-- Arabic Content -->
                        <div>
                            <label for="content_ar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Arabic Lesson Content *
                            </label>
                            <div class="relative">
                                <textarea id="content_ar" v-model="form.content_ar" rows="12" dir="rtl"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    placeholder="اكتب محتوى الدرس بالتفصيل..."
                                    :class="{ 'border-red-500': form.errors.content_ar }"></textarea>
                                <FileText class="absolute left-3 top-3 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.content_ar" class="mt-1 text-sm text-red-600">{{
                                form.errors.content_ar }}</p>
                        </div>
                    </div>

                    <!-- Lesson Details -->
                    <div class="grid gap-6 lg:grid-cols-2">
                        <!-- Video URL -->
                        <div>
                            <label for="video_url"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Lesson Video URL
                            </label>
                            <div class="relative">
                                <input id="video_url" v-model="form.video_url" type="url"
                                    class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://youtube.com/watch?v=..."
                                    :class="{ 'border-red-500': form.errors.video_url }" />
                                <Video
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.video_url" class="mt-1 text-sm text-red-600">{{
                                form.errors.video_url }}</p>
                            <p class="mt-1 text-xs text-gray-500">Optional: YouTube or Vimeo URL for this lesson</p>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Lesson Order *
                            </label>
                            <div class="relative">
                                <input id="sort_order" v-model.number="form.sort_order" type="number" min="1"
                                    class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="1" :class="{ 'border-red-500': form.errors.sort_order }" />
                                <Hash
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                            </div>
                            <p v-if="form.errors.sort_order" class="mt-1 text-sm text-red-600">{{ form.errors.sort_order
                                }}</p>
                            <p class="mt-1 text-xs text-gray-500">Determines the order of lessons in the course</p>
                        </div>
                    </div>

                    <!-- Status Options -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Status Options</h3>

                        <div class="flex items-center gap-3">
                            <input id="is_active" v-model="form.is_active" type="checkbox"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            <label for="is_active"
                                class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                <Eye class="h-4 w-4" />
                                Make lesson active
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            If unchecked, the lesson will be saved as inactive and won't be visible to students
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <a :href="`/courses/${props.course.id}`"
                            class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" :disabled="form.processing || isSubmitting"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <Save class="h-4 w-4" />
                            <span v-if="form.processing || isSubmitting">Creating...</span>
                            <span v-else">Add Content</span>
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