<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';

// Props that would come from your Laravel backend
defineProps<{
    auth?: {
        user?: any;
    };
    blogs?: {
        data: Array<{
            id: number;
            author_id: number;
            title_ar: string;
            title_en: string;
            slug: string;
            content_ar: string;
            content_en: string;
            is_published: number;
            published_at: string;
            created_at: string;
            updated_at: string;
        }>;
        current_page: number;
        last_page: number;
        total: number;
        per_page: number;
        from: number;
        to: number;
        links: Array<any>;
        path: string;
        first_page_url: string;
        last_page_url: string;
        next_page_url: string | null;
        prev_page_url: string | null;
    };
}>();

// Helper function to truncate content for excerpt
const getExcerpt = (content: string, wordLimit: number = 30) => {
    const words = content.split(' ');
    if (words.length <= wordLimit) return content;
    return words.slice(0, wordLimit).join(' ') + '...';
};

// Helper function to estimate reading time
const getReadingTime = (content: string) => {
    const wordsPerMinute = 200;
    const wordCount = content.split(' ').length;
    const minutes = Math.ceil(wordCount / wordsPerMinute);
    return `${minutes} min read`;
};

// Helper function to format date
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>

    <Head title="Programming Blog - Barmaja Academy">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
        <Navbar />

        <!-- Simple Blog Header -->
        <section class="py-16 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Programming
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                        Blog
                    </span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Insights, tutorials, and stories from the world of software development
                </p>
            </div>
        </section>

        <!-- Blog Articles -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Articles List -->
                <div class="space-y-12">
                    <article v-for="blog in blogs?.data" :key="blog.id" class="group">

                        <!-- Article Header -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face"
                                    alt="Author" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Ahmed Khalil</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(blog.published_at
                                        || blog.created_at) }}</p>
                                </div>
                            </div>

                            <h2
                                class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                <Link :href="route('frontend.show.blog', { id: blog.id })" class="hover:underline">
                                {{ blog.title_en }}
                                </Link>
                            </h2>
                        </div>

                        <!-- Article Image -->
                        <div class="mb-6">
                            <Link :href="`/blog/${blog.slug}`">
                            <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=800&h=400&fit=crop"
                                alt="Article"
                                class="w-full h-64 lg:h-80 object-cover rounded-2xl group-hover:opacity-90 transition-opacity duration-300">
                            </Link>
                        </div>

                        <!-- Article Content -->
                        <div class="mb-6">
                            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ getExcerpt(blog.content_en, 40) }}
                            </p>
                        </div>

                        <!-- Article Footer -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ getReadingTime(blog.content_en) }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    1.2k views
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-heart mr-1"></i>
                                    32 likes
                                </span>
                            </div>

                            <Link :href="route('frontend.show.blog', { id: blog.id })"
                                class="inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                            Read Full Article
                            <i class="fas fa-arrow-right ml-2"></i>
                            </Link>
                        </div>

                        <!-- Divider -->
                        <div class="mt-12 border-b border-gray-200 dark:border-gray-700"></div>
                    </article>
                </div>

                <!-- Empty State -->
                <div v-if="!blogs?.data?.length" class="text-center py-16">
                    <div
                        class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-edit text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No articles yet</h3>
                    <p class="text-gray-600 dark:text-gray-300">Check back soon for new programming insights and
                        tutorials.</p>
                </div>

                <!-- Simple Pagination -->
                <div v-if="blogs && blogs.last_page > 1" class="mt-16 flex justify-center">
                    <div class="flex items-center space-x-4">
                        <Link v-if="blogs.prev_page_url" :href="blogs.prev_page_url"
                            class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        ← Previous
                        </Link>

                        <div class="flex items-center space-x-2">
                            <template v-for="link in blogs.links" :key="link.label">
                                <Link
                                    v-if="link.url && link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;'"
                                    :href="link.url" class="px-4 py-2 rounded-lg transition-colors" :class="link.active
                                        ? 'bg-blue-600 text-white'
                                        : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'"
                                    v-html="link.label">
                                </Link>
                            </template>
                        </div>

                        <Link v-if="blogs.next_page_url" :href="blogs.next_page_url"
                            class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Next →
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Simple Footer -->
        <footer class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Barmaja Academy</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Empowering developers with knowledge and insights
                    </p>
                    <div class="flex justify-center space-x-6">
                        <Link href="/"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Home</Link>
                        <Link href="/courses"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Courses</Link>
                        <Link href="/blog"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Blog</Link>
                        <Link href="/about"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        About</Link>
                        <Link href="/contact"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Contact</Link>
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8 mt-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        © 2024 Barmaja Academy. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>