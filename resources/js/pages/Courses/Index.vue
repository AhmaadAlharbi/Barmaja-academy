<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    Plus,
    Edit,
    Trash2,
    Eye,
    DollarSign,
    Video,
    BookOpen,
    CheckCircle,
    XCircle,
    Search
} from 'lucide-vue-next';

// Import shadcn/vue pagination components
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';

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

interface CoursesData {
    data: Course[];
    links?: any[];
    meta?: {
        current_page?: number;
        last_page?: number;
        per_page?: number;
        total?: number;
    };
}

const props = defineProps<{
    courses: CoursesData | Course[] | any; // Accept any structure
}>();

// Helper to safely get courses data
const coursesData = computed(() => {
    if (Array.isArray(props.courses)) {
        // If courses is just an array
        return props.courses;
    }
    // If courses has a data property (pagination)
    return props.courses?.data || [];
});

// Helper to safely get meta info
const metaInfo = computed(() => {
    if (Array.isArray(props.courses)) {
        return {
            total: props.courses.length,
            current_page: 1,
            last_page: 1,
            per_page: props.courses.length
        };
    }
    return props.courses?.meta || props.courses || {};
});

// Helper to safely get links
const paginationLinks = computed(() => {
    if (Array.isArray(props.courses)) {
        return [];
    }
    return props.courses?.links || [];
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Courses',
        href: '/courses',
    },
];

const searchQuery = ref('');

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-KW', {
        style: 'currency',
        currency: 'KWD'
    }).format(amount);
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const deleteCourse = (course: Course) => {
    if (confirm(`Are you sure you want to delete "${course.title_en}"? This action cannot be undone.`)) {
        router.delete(`/courses/${course.id}`, {
            onSuccess: () => {
                // Success message will be handled by the backend
            }
        });
    }
};

const getStatusColor = (isPublished: boolean) => {
    return isPublished ? 'text-green-600' : 'text-yellow-600';
};

// Handle pagination navigation
const handlePageChange = (page: number) => {
    router.get('/courses', {
        page: page,
        // Preserve any existing query parameters
        search: searchQuery.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>

    <Head title="Courses" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Courses</h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Manage your courses ({{ metaInfo.total || coursesData.length }} total)
                    </p>
                </div>
                <Link href="/courses/create"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <Plus class="h-4 w-4" />
                Add New Course
                </Link>
            </div>

            <!-- Search and Filters -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4">
                <div class="flex items-center gap-4">
                    <div class="relative flex-1 max-w-md">
                        <input v-model="searchQuery" type="text" placeholder="Search courses..."
                            class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                    </div>
                    <select
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                    <select
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Prices</option>
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
            </div>

            <!-- Courses Grid/Table -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Course
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Price
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Created
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="course in coursesData" :key="course.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Course Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-12 w-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <BookOpen class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ course.title_en }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ course.title_ar }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <Video v-if="course.preview_video_url" class="h-3 w-3 text-green-500"
                                                    title="Has preview video" />
                                                <span class="text-xs text-gray-500">{{ course.slug }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        <DollarSign class="h-4 w-4 text-gray-400" />
                                        <span
                                            :class="course.price === 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-900 dark:text-white'"
                                            class="font-medium">
                                            {{ course.price === 0 ? 'Free' : formatCurrency(course.price) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
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
                                </td>

                                <!-- Created Date -->
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ formatDate(course.created_at) }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link :href="`/courses/${course.id}`"
                                            class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                            title="View course">
                                        <Eye class="h-4 w-4" />
                                        </Link>
                                        <Link :href="`/courses/${course.id}/edit`"
                                            class="p-2 text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20"
                                            title="Edit course">
                                        <Edit class="h-4 w-4" />
                                        </Link>
                                        <button @click="deleteCourse(course)"
                                            class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20"
                                            title="Delete course">
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden">
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div v-for="course in coursesData" :key="course.id"
                            class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-3 flex-1">
                                    <div
                                        class="h-12 w-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <BookOpen class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{ course.title_en }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ course.title_ar }}</p>

                                        <div class="flex items-center gap-4 mt-2">
                                            <div class="flex items-center gap-1">
                                                <DollarSign class="h-3 w-3 text-gray-400" />
                                                <span
                                                    :class="course.price === 0 ? 'text-green-600' : 'text-gray-900 dark:text-white'"
                                                    class="text-sm font-medium">
                                                    {{ course.price === 0 ? 'Free' : formatCurrency(course.price) }}
                                                </span>
                                            </div>

                                            <span v-if="course.is_published === 1 || course.is_published === true"
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                                <CheckCircle class="h-2 w-2" />
                                                Published
                                            </span>
                                            <span v-else
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">
                                                <XCircle class="h-2 w-2" />
                                                Draft
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-between mt-3">
                                            <div class="text-xs text-gray-500">
                                                Created {{ formatDate(course.created_at) }}
                                            </div>
                                            <Video v-if="course.preview_video_url" class="h-4 w-4 text-green-500"
                                                title="Has preview video" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Mobile Actions -->
                                <div class="flex items-center gap-2 ml-4">
                                    <Link :href="`/courses/${course.id}`"
                                        class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                    <Eye class="h-4 w-4" />
                                    </Link>
                                    <Link :href="`/courses/${course.id}/edit`"
                                        class="p-2 text-gray-400 hover:text-green-600 transition-colors">
                                    <Edit class="h-4 w-4" />
                                    </Link>
                                    <button @click="deleteCourse(course)"
                                        class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- shadcn/vue Pagination -->
            <div v-if="metaInfo.last_page && metaInfo.last_page > 1" class="flex justify-center mt-6">
                <Pagination :items-per-page="metaInfo.per_page || 10" :total="metaInfo.total || 0"
                    :default-page="metaInfo.current_page || 1" v-slot="{ page }" @update:page="handlePageChange">
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious @click="handlePageChange(page - 1)" />
                        <template v-for="(item, index) in items" :key="index">
                            <PaginationEllipsis v-if="item.type === 'ellipsis'" :index="index" />
                            <PaginationItem v-else-if="item.type === 'page'" :value="item.value"
                                :is-active="item.value === page" @click="handlePageChange(item.value)">
                                {{ item.value }}
                            </PaginationItem>
                        </template>
                        <PaginationNext @click="handlePageChange(page + 1)" />
                    </PaginationContent>
                </Pagination>
            </div>

            <!-- Pagination Info -->
            <div v-if="metaInfo.last_page && metaInfo.last_page > 1" class="text-center">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Showing {{ ((metaInfo.current_page || 1) - 1) * (metaInfo.per_page || 10) + 1 }} to
                    {{ Math.min((metaInfo.current_page || 1) * (metaInfo.per_page || 10), metaInfo.total ||
                        coursesData.length) }}
                    of {{ metaInfo.total || coursesData.length }} results
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="coursesData.length === 0"
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-12 text-center">
                <BookOpen class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No courses found</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">
                    Get started by creating your first course.
                </p>
                <Link href="/courses/create"
                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <Plus class="h-4 w-4" />
                Add New Course
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Additional styles for better mobile experience */
@media (max-width: 640px) {
    .table-container {
        overflow-x: auto;
    }
}
</style>