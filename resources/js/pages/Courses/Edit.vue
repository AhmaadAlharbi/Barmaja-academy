<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    ArrowLeft,
    Save,
    X,
    DollarSign,
    Video,
    BookOpen,
    Globe,
    FileText,
    Eye,
    EyeOff,
    AlertCircle
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
    {
        title: 'Edit',
        href: `/courses/${props.course.id}/edit`,
    },
];

const form = useForm({
    title_en: props.course.title_en,
    title_ar: props.course.title_ar,
    description_en: props.course.description_en,
    description_ar: props.course.description_ar,
    price: props.course.price,
    preview_video_url: props.course.preview_video_url || '',
    is_published: props.course.is_published,
});

const showPreview = ref(false);

const submitForm = () => {
    form.put(`/courses/${props.course.id}`, {
        onSuccess: () => {
            // Success message will be handled by the backend
        }
    });
};

const togglePreview = () => {
    showPreview.value = !showPreview.value;
};
</script>

<template>

    <Head :title="`Edit ${course.title_en}`" />

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
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Course</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ course.title_en }}</p>
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
                                    class="h-12 w-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <BookOpen class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Edit course details</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- English Title -->
                                <div>
                                    <label for="title_en"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <Globe class="inline h-4 w-4 mr-1" />
                                        Course Title (English) *
                                    </label>
                                    <input id="title_en" v-model="form.title_en" type="text" required maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter course title in English" />
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
                                        Course Title (Arabic) *
                                    </label>
                                    <input id="title_ar" v-model="form.title_ar" type="text" required maxlength="255"
                                        dir="rtl"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="أدخل عنوان الدورة بالعربية" />
                                    <div v-if="form.errors.title_ar"
                                        class="flex items-center gap-2 mt-2 text-sm text-red-600 dark:text-red-400">
                                        <AlertCircle class="h-4 w-4" />
                                        {{ form.errors.title_ar }}
                                    </div>
                                </div>

                                <!-- English Description -->
                                <div>
                                    <label for="description_en"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <FileText class="inline h-4 w-4 mr-1" />
                                        Description (English) *
                                    </label>
                                    <textarea id="description_en" v-model="form.description_en" required rows="4"
                                        minlength="10"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-vertical"
                                        placeholder="Describe your course in English (minimum 10 characters)"></textarea>
                                    <div v-if="form.errors.description_en"
                                        class="flex items-center gap-2 mt-2 text-sm text-red-600 dark:text-red-400">
                                        <AlertCircle class="h-4 w-4" />
                                        {{ form.errors.description_en }}
                                    </div>
                                </div>

                                <!-- Arabic Description -->
                                <div>
                                    <label for="description_ar"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <FileText class="inline h-4 w-4 mr-1" />
                                        Description (Arabic) *
                                    </label>
                                    <textarea id="description_ar" v-model="form.description_ar" required rows="4"
                                        minlength="10" dir="rtl"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-vertical"
                                        placeholder="اوصف دورتك بالعربية (10 أحرف على الأقل)"></textarea>
                                    <div v-if="form.errors.description_ar"
                                        class="flex items-center gap-2 mt-2 text-sm text-red-600 dark:text-red-400">
                                        <AlertCircle class="h-4 w-4" />
                                        {{ form.errors.description_ar }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media & Pricing -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="h-12 w-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <DollarSign class="h-6 w-6 text-green-600 dark:text-green-400" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Pricing & Media</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Set course price and media</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- Price -->
                                <div>
                                    <label for="price"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <DollarSign class="inline h-4 w-4 mr-1" />
                                        Course Price (KWD) *
                                    </label>
                                    <div class="relative">
                                        <input id="price" v-model="form.price" type="number" step="0.01" min="0"
                                            max="999999.99" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="0.00" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Set to 0 for free courses
                                    </p>
                                    <div v-if="form.errors.price"
                                        class="flex items-center gap-2 mt-2 text-sm text-red-600 dark:text-red-400">
                                        <AlertCircle class="h-4 w-4" />
                                        {{ form.errors.price }}
                                    </div>
                                </div>

                                <!-- Preview Video URL -->
                                <div>
                                    <label for="preview_video_url"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <Video class="inline h-4 w-4 mr-1" />
                                        Preview Video URL (Optional)
                                    </label>
                                    <input id="preview_video_url" v-model="form.preview_video_url" type="url"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="https://youtube.com/watch?v=..." />
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">YouTube, Vimeo, or other
                                        video platform URL</p>
                                    <div v-if="form.errors.preview_video_url"
                                        class="flex items-center gap-2 mt-2 text-sm text-red-600 dark:text-red-400">
                                        <AlertCircle class="h-4 w-4" />
                                        {{ form.errors.preview_video_url }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div v-if="showPreview"
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Preview</h3>
                            <div class="space-y-4">
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ form.title_en ||
                                        'Course Title (English)' }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400" dir="rtl">{{ form.title_ar ||
                                        'عنوان الدورة (العربية)' }}</p>
                                    <div class="mt-3">
                                        <p class="text-gray-900 dark:text-white">{{ form.description_en ||
                                            'English description will appear here...' }}</p>
                                    </div>
                                    <div class="mt-3" dir="rtl">
                                        <p class="text-gray-900 dark:text-white">{{ form.description_ar ||
                                            'الوصف العربي سيظهر هنا...' }}</p>
                                    </div>
                                    <div class="flex items-center gap-4 mt-4">
                                        <span class="font-semibold text-lg text-green-600 dark:text-green-400">
                                            {{ form.price == 0 ? 'Free' : `${form.price} KWD` }}
                                        </span>
                                        <span v-if="form.preview_video_url"
                                            class="flex items-center gap-1 text-sm text-blue-600 dark:text-blue-400">
                                            <Video class="h-4 w-4" />
                                            Preview Available
                                        </span>
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
                                            Publish Course
                                        </label>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Make this course visible to
                                            students</p>
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

                        <!-- Course Info -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Info</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Course ID</span>
                                    <span class="font-medium text-gray-900 dark:text-white">#{{ course.id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Current Slug</span>
                                    <code class="text-xs text-blue-600 dark:text-blue-400">{{ course.slug }}</code>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Created</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ new Date(course.created_at).toLocaleDateString() }}
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

                                <Link :href="`/courses/${course.id}`"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <X class="h-4 w-4" />
                                Cancel
                                </Link>

                                <Link href="/courses"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <ArrowLeft class="h-4 w-4" />
                                Back to Courses
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>