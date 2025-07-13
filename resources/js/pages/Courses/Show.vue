<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
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
    Eye,
    Plus,
    Move,
    Save,
    X,
    AlertCircle,
    GripVertical,
    Play
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
    contents?: CourseContent[];
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

// Modals state
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editingContent = ref<CourseContent | null>(null);

// Create form
const createForm = useForm({
    title_en: '',
    title_ar: '',
    content_en: '',
    content_ar: '',
    video_url: '',
    is_active: true,
});

// Edit form
const editForm = useForm({
    title_en: '',
    title_ar: '',
    content_en: '',
    content_ar: '',
    video_url: '',
    is_active: true,
});

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

// Content management functions
const openCreateModal = () => {
    createForm.reset();
    showCreateModal.value = true;
};

const openEditModal = (content: CourseContent) => {
    editingContent.value = content;
    editForm.reset();
    editForm.title_en = content.title_en;
    editForm.title_ar = content.title_ar;
    editForm.content_en = content.content_en;
    editForm.content_ar = content.content_ar;
    editForm.video_url = content.video_url || '';
    editForm.is_active = content.is_active;
    showEditModal.value = true;
};

const closeModals = () => {
    showCreateModal.value = false;
    showEditModal.value = false;
    editingContent.value = null;
    createForm.reset();
    editForm.reset();
};

const submitCreateForm = () => {
    createForm.post(`/courses/${props.course.id}/contents`, {
        onSuccess: () => {
            closeModals();
        }
    });
};

const submitEditForm = () => {
    if (!editingContent.value) return;

    editForm.put(`/courses/${props.course.id}/contents/${editingContent.value.id}`, {
        onSuccess: () => {
            closeModals();
        }
    });
};


const deleteContent = (content: CourseContent) => {
    if (confirm(`Are you sure you want to delete "${content.title_en}"? This action cannot be undone.`)) {
        router.delete(`/courses/${props.course.id}/content/${content.id}`);
    }
};

const toggleContentActive = (content: CourseContent) => {
    router.post(`/courses/${props.course.id}/content/${content.id}/toggle-active`);
};

const getWordCount = (text: string) => {
    if (!text) return 0;
    return text.trim().split(/\s+/).length;
};

const sortedContents = computed(() => {
    return props.course.contents?.sort((a, b) => a.sort_order - b.sort_order) || [];
});
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

                    <!-- Course Contents Management -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-12 w-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <FileText class="h-6 w-6 text-green-600 dark:text-green-400" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Course Contents</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ sortedContents.length }}
                                        lessons</p>
                                </div>
                            </div>
                            <Link :href="route('courses.content.create', { course: course.id })"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <Plus class="h-4 w-4" />
                            Add Content
                            </Link>
                        </div>

                        <!-- Content List -->
                        <!-- Content List -->
                        <div v-if="sortedContents.length > 0" class="space-y-3">
                            <div v-for="content in sortedContents" :key="content.id" :class="[
                                'group p-4 rounded-lg border-2 border-transparent hover:border-blue-200 dark:hover:border-blue-800 transition-all',
                                content.is_active
                                    ? 'bg-gray-50 dark:bg-gray-700'
                                    : 'bg-red-50 dark:bg-red-900/20 opacity-75'
                            ]">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start gap-3 flex-1">
                                        <!-- Drag Handle -->
                                        <div
                                            class="p-1 text-gray-400 cursor-move opacity-0 group-hover:opacity-100 transition-opacity">
                                            <GripVertical class="h-4 w-4" />
                                        </div>

                                        <!-- Order Number -->
                                        <div :class="[
                                            'h-8 w-8 rounded-lg flex items-center justify-center flex-shrink-0',
                                            content.is_active
                                                ? 'bg-blue-100 dark:bg-blue-900/30'
                                                : 'bg-gray-200 dark:bg-gray-600'
                                        ]">
                                            <span :class="[
                                                'text-xs font-medium',
                                                content.is_active
                                                    ? 'text-blue-600 dark:text-blue-400'
                                                    : 'text-gray-500 dark:text-gray-400'
                                            ]">{{ content.sort_order }}</span>
                                        </div>

                                        <!-- Content Info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h3 :class="[
                                                    'font-medium truncate',
                                                    content.is_active
                                                        ? 'text-gray-900 dark:text-white'
                                                        : 'text-gray-500 dark:text-gray-400'
                                                ]">{{ content.title_en }}</h3>

                                                <!-- Status Badge -->
                                                <span v-if="content.is_active"
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                                    <CheckCircle class="h-2 w-2" />
                                                    Active
                                                </span>
                                                <span v-else
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 rounded-full">
                                                    <XCircle class="h-2 w-2" />
                                                    Inactive
                                                </span>

                                                <span v-if="content.video_url"
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 rounded-full">
                                                    <Play class="h-2 w-2" />
                                                    Video
                                                </span>
                                            </div>

                                            <p :class="[
                                                'text-sm truncate mb-2',
                                                content.is_active
                                                    ? 'text-gray-600 dark:text-gray-400'
                                                    : 'text-gray-500 dark:text-gray-500'
                                            ]" dir="rtl">{{ content.title_ar }}</p>

                                            <!-- Content Stats -->
                                            <div :class="[
                                                'flex items-center gap-4 text-xs',
                                                content.is_active
                                                    ? 'text-gray-500'
                                                    : 'text-gray-400'
                                            ]">
                                                <span>{{ getWordCount(content.content_en) }} words (EN)</span>
                                                <span>{{ getWordCount(content.content_ar) }} words (AR)</span>
                                                <span>{{ formatDate(content.created_at).split(',')[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div
                                        class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- Status Toggle -->
                                        <button @click="toggleContentActive(content)" :class="[
                                            'p-2 rounded-lg transition-all duration-200 border',
                                            content.is_active
                                                ? 'text-green-600 hover:text-red-600 border-green-200 hover:border-red-300 hover:bg-red-50 dark:border-green-800 dark:hover:border-red-800 dark:hover:bg-red-900/20'
                                                : 'text-red-600 hover:text-green-600 border-red-200 hover:border-green-300 hover:bg-green-50 dark:border-red-800 dark:hover:border-green-800 dark:hover:bg-green-900/20'
                                        ]"
                                            :title="content.is_active ? 'Click to deactivate this content' : 'Click to activate this content'">
                                            <CheckCircle v-if="content.is_active" class="h-4 w-4" />
                                            <XCircle v-else class="h-4 w-4" />
                                        </button>

                                        <!-- Edit -->
                                        <Link
                                            :href="route('courses.content.edit', { course: course.id, content: content.id })"
                                            class="p-2 text-blue-600 hover:text-blue-800 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 border border-transparent hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-200">
                                        <Edit class="h-4 w-4" />
                                        </Link>

                                        <!-- Delete -->
                                        <button @click="deleteContent(content)"
                                            class="p-2 text-red-600 hover:text-red-800 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 border border-transparent hover:border-red-200 dark:hover:border-red-800 transition-all duration-200"
                                            title="Delete content">
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-12">
                            <FileText class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No content yet</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">
                                Start building your course by adding the first lesson.
                            </p>
                            <button @click="openCreateModal"
                                class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <Plus class="h-4 w-4" />
                                Add First Content
                            </button>
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
                                        {{ sortedContents.length }} lessons
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

                            <button @click="openCreateModal"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <Plus class="h-4 w-4" />
                                Add Content
                            </button>

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

        <!-- Create Content Modal -->
        <div v-if="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="closeModals"></div>

                <div
                    class="inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add New Content</h3>
                        <button @click="closeModals" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <form @submit.prevent="submitCreateForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- English Title -->
                            <div>
                                <label for="create_title_en"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (English) *
                                </label>
                                <input id="create_title_en" v-model="createForm.title_en" type="text" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter lesson title in English" />
                                <div v-if="createForm.errors.title_en"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ createForm.errors.title_en }}
                                </div>
                            </div>

                            <!-- Arabic Title -->
                            <div>
                                <label for="create_title_ar"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (Arabic) *
                                </label>
                                <input id="create_title_ar" v-model="createForm.title_ar" type="text" required dir="rtl"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="أدخل عنوان الدرس بالعربية" />
                                <div v-if="createForm.errors.title_ar"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ createForm.errors.title_ar }}
                                </div>
                            </div>
                        </div>

                        <!-- English Content -->
                        <div>
                            <label for="create_content_en"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content (English) *
                            </label>
                            <textarea id="create_content_en" v-model="createForm.content_en" required rows="6"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical"
                                placeholder="Enter lesson content in English"></textarea>
                            <div v-if="createForm.errors.content_en"
                                class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ createForm.errors.content_en }}
                            </div>
                        </div>

                        <!-- Arabic Content -->
                        <div>
                            <label for="create_content_ar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content (Arabic) *
                            </label>
                            <textarea id="create_content_ar" v-model="createForm.content_ar" required rows="6" dir="rtl"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical"
                                placeholder="اكتب محتوى الدرس بالعربية"></textarea>
                            <div v-if="createForm.errors.content_ar"
                                class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ createForm.errors.content_ar }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Video URL -->
                            <div>
                                <label for="create_video_url"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Video URL (Optional)
                                </label>
                                <input id="create_video_url" v-model="createForm.video_url" type="url"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="https://youtube.com/watch?v=..." />
                                <div v-if="createForm.errors.video_url"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ createForm.errors.video_url }}
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="create_is_active"
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Active Content
                                    </label>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Make this content visible to
                                        students</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="create_is_active" v-model="createForm.is_active" type="checkbox"
                                        class="sr-only peer" />
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" @click="closeModals"
                                class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" :disabled="createForm.processing"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <Save class="inline h-4 w-4 mr-2" />
                                {{ createForm.processing ? 'Creating...' : 'Create Content' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Content Modal -->
        <div v-if="showEditModal && editingContent" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="closeModals"></div>

                <div
                    class="inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Edit Content</h3>
                        <button @click="closeModals" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <form @submit.prevent="submitEditForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- English Title -->
                            <div>
                                <label for="edit_title_en"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (English) *
                                </label>
                                <input id="edit_title_en" v-model="editForm.title_en" type="text" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter lesson title in English" />
                                <div v-if="editForm.errors.title_en"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ editForm.errors.title_en }}
                                </div>
                            </div>

                            <!-- Arabic Title -->
                            <div>
                                <label for="edit_title_ar"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (Arabic) *
                                </label>
                                <input id="edit_title_ar" v-model="editForm.title_ar" type="text" required dir="rtl"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="أدخل عنوان الدرس بالعربية" />
                                <div v-if="editForm.errors.title_ar"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ editForm.errors.title_ar }}
                                </div>
                            </div>
                        </div>

                        <!-- English Content -->
                        <div>
                            <label for="edit_content_en"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content (English) *
                            </label>
                            <textarea id="edit_content_en" v-model="editForm.content_en" required rows="6"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical"
                                placeholder="Enter lesson content in English"></textarea>
                            <div v-if="editForm.errors.content_en" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ editForm.errors.content_en }}
                            </div>
                        </div>

                        <!-- Arabic Content -->
                        <div>
                            <label for="edit_content_ar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content (Arabic) *
                            </label>
                            <textarea id="edit_content_ar" v-model="editForm.content_ar" required rows="6" dir="rtl"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical"
                                placeholder="اكتب محتوى الدرس بالعربية"></textarea>
                            <div v-if="editForm.errors.content_ar" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ editForm.errors.content_ar }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Video URL -->
                            <div>
                                <label for="edit_video_url"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Video URL (Optional)
                                </label>
                                <input id="edit_video_url" v-model="editForm.video_url" type="url"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="https://youtube.com/watch?v=..." />
                                <div v-if="editForm.errors.video_url"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ editForm.errors.video_url }}
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="edit_is_active"
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Active Content
                                    </label>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Make this content visible to
                                        students</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="edit_is_active" v-model="editForm.is_active" type="checkbox"
                                        class="sr-only peer" />
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" @click="closeModals"
                                class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" :disabled="editForm.processing"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <Save class="inline h-4 w-4 mr-2" />
                                {{ editForm.processing ? 'Updating...' : 'Update Content' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>