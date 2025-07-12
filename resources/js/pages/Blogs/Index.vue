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
    FileText,
    PenTool,
    CheckCircle,
    XCircle,
    Search,
    User,
    Calendar
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

interface BlogPostsData {
    data: BlogPost[];
    links?: any[];
    meta?: {
        current_page?: number;
        last_page?: number;
        per_page?: number;
        total?: number;
    };
}

const props = defineProps<{
    blogPosts: BlogPostsData | BlogPost[] | any;
}>();

// Helper to safely get blog posts data
const blogPostsData = computed(() => {
    if (Array.isArray(props.blogPosts)) {
        return props.blogPosts;
    }
    return props.blogPosts?.data || [];
});

// Helper to safely get meta info
const metaInfo = computed(() => {
    if (Array.isArray(props.blogPosts)) {
        return {
            total: props.blogPosts.length,
            current_page: 1,
            last_page: 1,
            per_page: props.blogPosts.length
        };
    }
    return props.blogPosts?.meta || props.blogPosts || {};
});

// Helper to safely get links
const paginationLinks = computed(() => {
    if (Array.isArray(props.blogPosts)) {
        return [];
    }
    return props.blogPosts?.links || [];
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Blog Posts',
        href: '/blogs',
    },
];

const searchQuery = ref('');

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const formatDateTime = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getExcerpt = (content: string, maxLength: number = 100) => {
    if (!content) return '';
    return content.length > maxLength ? content.substring(0, maxLength) + '...' : content;
};

const deleteBlogPost = (blogPost: BlogPost) => {
    if (confirm(`Are you sure you want to delete "${blogPost.title_en}"? This action cannot be undone.`)) {
        router.delete(`/blogs/${blogPost.id}`, {
            onSuccess: () => {
                // Success message will be handled by the backend
            }
        });
    }
};

// Handle pagination navigation
const handlePageChange = (page: number) => {
    router.get('/blogs', {
        page: page,
        search: searchQuery.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>

    <Head title="Blog Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Blog Posts</h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Manage your blog posts ({{ metaInfo.total || blogPostsData.length }} total)
                    </p>
                </div>
                <Link href="/blogs/create"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <Plus class="h-4 w-4" />
                Add New Post
                </Link>
            </div>

            <!-- Search and Filters -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4">
                <div class="flex items-center gap-4">
                    <div class="relative flex-1 max-w-md">
                        <input v-model="searchQuery" type="text" placeholder="Search blog posts..."
                            class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                    </div>
                    <select
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <!-- Blog Posts Grid/Table -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Blog Post
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Author
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Published
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="blogPost in blogPostsData" :key="blogPost.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Blog Post Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-12 w-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                            <PenTool class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="font-medium text-gray-900 dark:text-white truncate">
                                                {{ blogPost.title_en }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                                {{ blogPost.title_ar }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-gray-500">{{ blogPost.slug }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ getExcerpt(blogPost.content_en, 80) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Author -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <User class="h-4 w-4 text-gray-400" />
                                        <span class="text-sm text-gray-900 dark:text-white">
                                            {{ blogPost.author?.name || 'Unknown' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
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
                                </td>

                                <!-- Published Date -->
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    <div v-if="blogPost.published_at" class="flex items-center gap-1">
                                        <Calendar class="h-3 w-3" />
                                        {{ formatDate(blogPost.published_at) }}
                                    </div>
                                    <div v-else class="text-gray-400">—</div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link :href="`/blogs/${blogPost.id}`"
                                            class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                            title="View blog post">
                                        <Eye class="h-4 w-4" />
                                        </Link>
                                        <Link :href="`/blogs/${blogPost.id}/edit`"
                                            class="p-2 text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20"
                                            title="Edit blog post">
                                        <Edit class="h-4 w-4" />
                                        </Link>
                                        <button @click="deleteBlogPost(blogPost)"
                                            class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20"
                                            title="Delete blog post">
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
                        <div v-for="blogPost in blogPostsData" :key="blogPost.id"
                            class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-3 flex-1">
                                    <div
                                        class="h-12 w-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <PenTool class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{ blogPost.title_en }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ blogPost.title_ar }}</p>

                                        <div class="text-xs text-gray-500 mt-2">
                                            {{ getExcerpt(blogPost.content_en, 100) }}
                                        </div>

                                        <div class="flex items-center gap-4 mt-3">
                                            <div class="flex items-center gap-1">
                                                <User class="h-3 w-3 text-gray-400" />
                                                <span class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{ blogPost.author?.name || 'Unknown' }}
                                                </span>
                                            </div>

                                            <span v-if="blogPost.is_published === 1 || blogPost.is_published === true"
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
                                                {{ blogPost.published_at ? 'Published ' +
                                                    formatDate(blogPost.published_at) : 'Created ' +
                                                formatDate(blogPost.created_at) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mobile Actions -->
                                <div class="flex items-center gap-2 ml-4">
                                    <Link :href="`/blogs/${blogPost.id}`"
                                        class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                    <Eye class="h-4 w-4" />
                                    </Link>
                                    <Link :href="`/blogs/${blogPost.id}/edit`"
                                        class="p-2 text-gray-400 hover:text-green-600 transition-colors">
                                    <Edit class="h-4 w-4" />
                                    </Link>
                                    <button @click="deleteBlogPost(blogPost)"
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
                        blogPostsData.length) }}
                    of {{ metaInfo.total || blogPostsData.length }} results
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="blogPostsData.length === 0"
                class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-12 text-center">
                <PenTool class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No blog posts found</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">
                    Get started by creating your first blog post.
                </p>
                <Link href="/blogs/create"
                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <Plus class="h-4 w-4" />
                Add New Post
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