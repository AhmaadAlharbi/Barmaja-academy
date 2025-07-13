<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';

// Props that would come from your Laravel backend
defineProps<{
    auth?: {
        user?: any;
    };
    blog: {
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
    };
    relatedBlogs?: Array<{
        id: number;
        title_en: string;
        slug: string;
        content_en: string;
        published_at: string;
        created_at: string;
    }>;
}>();

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

// Helper function to truncate text
const truncate = (text: string, length: number = 100) => {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
};
</script>

<template>

    <Head :title="`${blog.title_en} - Barmaja Academy Blog`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <meta name="description" :content="truncate(blog.content_en, 160)">
        <meta property="og:title" :content="blog.title_en">
        <meta property="og:description" :content="truncate(blog.content_en, 160)">
        <meta property="og:type" content="article">
    </Head>

    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
        <Navbar />

        <!-- Back to Blog Navigation -->
        <section class="py-6 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <Link href="/blogs/list"
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Blog
                </Link>
            </div>
        </section>

        <!-- Article Header -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Article Meta -->
                <div class="mb-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face"
                            alt="Author" class="w-12 h-12 rounded-full">
                        <div>
                            <p class="text-lg font-medium text-gray-900 dark:text-white">Ahmed Khalil</p>
                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ formatDate(blog.published_at || blog.created_at) }}</span>
                                <span>•</span>
                                <span>{{ getReadingTime(blog.content_en) }}</span>
                                <span>•</span>
                                <span>Senior Developer</span>
                            </div>
                        </div>
                    </div>

                    <!-- Article Title -->
                    <h1 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white leading-tight mb-6">
                        {{ blog.title_en }}
                    </h1>

                    <!-- Article Stats -->
                    <div class="flex items-center justify-between py-4 border-y border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                            <span class="flex items-center">
                                <i class="fas fa-eye mr-1"></i>
                                2.1k views
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-heart mr-1"></i>
                                89 likes
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-comment mr-1"></i>
                                12 comments
                            </span>
                        </div>

                        <!-- Share Buttons -->
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">Share:</span>
                            <button
                                class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <i class="fab fa-twitter text-xs"></i>
                            </button>
                            <button
                                class="w-8 h-8 bg-blue-800 text-white rounded-full flex items-center justify-center hover:bg-blue-900 transition-colors">
                                <i class="fab fa-linkedin text-xs"></i>
                            </button>
                            <button
                                class="w-8 h-8 bg-gray-800 text-white rounded-full flex items-center justify-center hover:bg-gray-900 transition-colors">
                                <i class="fas fa-link text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="mb-10">
                    <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=1200&h=600&fit=crop"
                        alt="Article featured image" class="w-full h-64 lg:h-96 object-cover rounded-2xl">
                </div>
            </div>
        </section>

        <!-- Article Content -->
        <section class="pb-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    <!-- Blog Content - You'll replace this with your actual content -->
                    <div class="text-gray-800 dark:text-gray-200 leading-relaxed space-y-6">
                        <!-- Split content into paragraphs for better formatting -->
                        <template v-for="(paragraph, index) in blog.content_en.split('\n\n')" :key="index">
                            <p v-if="paragraph.trim()" class="text-lg leading-8">
                                {{ paragraph.trim() }}
                            </p>
                        </template>
                    </div>
                </div>

                <!-- Article Tags -->
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Tags:</h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer">
                            JavaScript
                        </span>
                        <span
                            class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer">
                            Vue.js
                        </span>
                        <span
                            class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer">
                            Web Development
                        </span>
                        <span
                            class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer">
                            Tutorial
                        </span>
                    </div>
                </div>

                <!-- Author Bio -->
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8">
                        <div class="flex items-start space-x-4">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=face"
                                alt="Author" class="w-16 h-16 rounded-full">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Ahmed Khalil</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">
                                    Senior Full-Stack Developer at Barmaja Academy with 8+ years of experience in modern
                                    web
                                    technologies.
                                    Passionate about teaching and sharing knowledge with the developer community.
                                </p>
                                <div class="flex items-center space-x-4">
                                    <a href="#"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
                                        More articles by Ahmed
                                    </a>
                                    <div class="flex space-x-2">
                                        <a href="#" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <i class="fab fa-github"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comments Section -->
        <section class="py-16 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Comments (12)</h3>

                <!-- Comment Form -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave a Comment</h4>
                    <div class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" placeholder="Your name"
                                class="px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <input type="email" placeholder="Your email"
                                class="px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        </div>
                        <textarea rows="4" placeholder="Write your comment..."
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"></textarea>
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            Post Comment
                        </button>
                    </div>
                </div>

                <!-- Sample Comments -->
                <div class="space-y-6">
                    <!-- Comment 1 -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6">
                        <div class="flex items-start space-x-4">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=40&h=40&fit=crop&crop=face"
                                alt="Commenter" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <h5 class="font-semibold text-gray-900 dark:text-white">Sarah Johnson</h5>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">2 hours ago</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Great article! This really helped me understand the concepts better.
                                    The examples are clear and easy to follow.
                                </p>
                                <button
                                    class="text-blue-600 dark:text-blue-400 text-sm font-medium mt-2 hover:text-blue-700 dark:hover:text-blue-300">
                                    Reply
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Comment 2 -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6">
                        <div class="flex items-start space-x-4">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face"
                                alt="Commenter" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <h5 class="font-semibold text-gray-900 dark:text-white">Mike Chen</h5>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">5 hours ago</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Thanks for sharing this knowledge! I've been struggling with this topic
                                    and your explanation makes it much clearer.
                                </p>
                                <button
                                    class="text-blue-600 dark:text-blue-400 text-sm font-medium mt-2 hover:text-blue-700 dark:hover:text-blue-300">
                                    Reply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Articles -->
        <section v-if="relatedBlogs?.length" class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Articles</h3>

                <div class="grid md:grid-cols-2 gap-8">
                    <article v-for="related in relatedBlogs" :key="related.id" class="group">
                        <Link :href="`/blog/${related.slug}`">
                        <img src="https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=400&h=200&fit=crop"
                            alt="Related article"
                            class="w-full h-40 object-cover rounded-2xl mb-4 group-hover:opacity-90 transition-opacity">
                        </Link>
                        <h4
                            class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            <Link :href="`/blog/${related.slug}`">
                            {{ related.title_en }}
                            </Link>
                        </h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                            {{ truncate(related.content_en, 120) }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ formatDate(related.published_at || related.created_at) }}</span>
                            <Link :href="`/blog/${related.slug}`"
                                class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Read more →
                            </Link>
                        </div>
                    </article>
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
/* Custom styles for better typography */
.prose {
    color: inherit;
}

.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.75;
}

.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: inherit;
}

.prose h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: inherit;
}

.prose ul,
.prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
}

.prose code {
    background-color: #f3f4f6;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.dark .prose code {
    background-color: #374151;
}
</style>