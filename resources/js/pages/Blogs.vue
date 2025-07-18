<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Navbar from '@/components/Navbar.vue';

const page = usePage();

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

// Get current locale
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');

// Get translations from props with fallbacks
const translations = computed(() => page.props.translations?.blog || {});

// Comprehensive fallback translations
const fallbackTranslations = {
    header: {
        title: isRTL.value ? 'مدونة' : 'Blog',
        subtitle_programming: isRTL.value ? 'البرمجة' : 'Programming',
        description: isRTL.value
            ? 'رؤى وتعليمات وقصص من عالم تطوير البرمجيات'
            : 'Insights, tutorials, and stories from the world of software development'
    },
    article: {
        read_full_article: isRTL.value ? 'اقرأ المقال كاملاً' : 'Read Full Article',
        views: isRTL.value ? 'مشاهدة' : 'views',
        likes: isRTL.value ? 'إعجاب' : 'likes',
        min_read: isRTL.value ? 'دقيقة قراءة' : 'min read',
        author_default: isRTL.value ? 'أحمد خليل' : 'Ahmed Khalil',
        tech_trends: isRTL.value ? 'اتجاهات التكنولوجيا' : 'Tech Trends'
    },
    pagination: {
        previous: isRTL.value ? 'السابق' : 'Previous',
        next: isRTL.value ? 'التالي' : 'Next'
    },
    empty_state: {
        title: isRTL.value ? 'لا توجد مقالات بعد' : 'No articles yet',
        description: isRTL.value
            ? 'عد قريباً للحصول على رؤى ودروس برمجة جديدة.'
            : 'Check back soon for new programming insights and tutorials.'
    },
    footer: {
        title: isRTL.value ? 'أكاديمية برمجة' : 'Barmaja Academy',
        description: isRTL.value
            ? 'تمكين المطورين بالمعرفة والرؤى'
            : 'Empowering developers with knowledge and insights',
        links: {
            home: isRTL.value ? 'الرئيسية' : 'Home',
            courses: isRTL.value ? 'الدورات' : 'Courses',
            blog: isRTL.value ? 'المدونة' : 'Blog',
            about: isRTL.value ? 'من نحن' : 'About',
            contact: isRTL.value ? 'اتصل بنا' : 'Contact'
        },
        copyright: isRTL.value ? '© ٢٠٢٤ أكاديمية برمجة. جميع الحقوق محفوظة.' : '© 2024 Barmaja Academy. All rights reserved.'
    }
};

// Get translation with fallback
function getTranslation(path: string, fallback: string = '') {
    const keys = path.split('.');
    let value = translations.value;

    for (const key of keys) {
        if (value && typeof value === 'object' && key in value) {
            value = value[key];
        } else {
            // Use fallback translation
            let fallbackValue = fallbackTranslations;
            for (const fallbackKey of keys) {
                if (fallbackValue && typeof fallbackValue === 'object' && fallbackKey in fallbackValue) {
                    fallbackValue = fallbackValue[fallbackKey];
                } else {
                    return fallback;
                }
            }
            return fallbackValue;
        }
    }

    return value || fallback;
}

// Helper function to get localized content
function getLocalizedContent(item: any, field: string) {
    return isRTL.value ? item[`${field}_ar`] : item[`${field}_en`];
}

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
    return `${minutes} ${getTranslation('article.min_read')}`;
};

// Helper function to format date
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    if (isRTL.value) {
        return date.toLocaleDateString('ar-EG', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>

    <Head :title="`${getTranslation('header.title')} - ${getTranslation('footer.title')}`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <meta name="description" :content="getTranslation('header.description')" />
    </Head>

    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300" :dir="isRTL ? 'rtl' : 'ltr'"
        :class="{ 'font-tajawal': isRTL }">
        <Navbar />

        <!-- Simple Blog Header -->
        <section class="py-16 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ getTranslation('header.subtitle_programming') }}
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                        {{ getTranslation('header.title') }}
                    </span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    {{ getTranslation('header.description') }}
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
                            <div class="flex items-center mb-4"
                                :class="isRTL ? 'space-x-reverse space-x-4' : 'space-x-4'">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face"
                                    alt="Author" class="w-10 h-10 rounded-full">
                                <div :class="{ 'text-right': isRTL }">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ getTranslation('article.author_default') }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ formatDate(blog.published_at || blog.created_at) }}
                                    </p>
                                </div>
                            </div>

                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                :class="{ 'text-right': isRTL }">
                                <Link :href="route('frontend.show.blog', { id: blog.id })" class="hover:underline">
                                {{ getLocalizedContent(blog, 'title') }}
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
                            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed"
                                :class="{ 'text-right': isRTL }">
                                {{ getExcerpt(getLocalizedContent(blog, 'content'), 40) }}
                            </p>
                        </div>

                        <!-- Article Footer -->
                        <div class="flex items-center justify-between" :class="{ 'flex-row-reverse': isRTL }">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400"
                                :class="isRTL ? 'space-x-reverse space-x-6' : 'space-x-6'">
                                <span class="flex items-center">
                                    <i class="fas fa-clock" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                    {{ getReadingTime(getLocalizedContent(blog, 'content')) }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                    1.2k {{ getTranslation('article.views') }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-heart" :class="isRTL ? 'ml-1' : 'mr-1'"></i>
                                    32 {{ getTranslation('article.likes') }}
                                </span>
                            </div>

                            <Link :href="route('frontend.show.blog', { id: blog.id })"
                                class="inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                            <span>{{ getTranslation('article.read_full_article') }}</span>
                            <i class="fas fa-arrow-right" :class="{ 'fas fa-arrow-left': isRTL }"></i>
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
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ getTranslation('empty_state.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ getTranslation('empty_state.description') }}
                    </p>
                </div>

                <!-- Simple Pagination -->
                <div v-if="blogs && blogs.last_page > 1" class="mt-16 flex justify-center">
                    <div class="flex items-center" :class="isRTL ? 'space-x-reverse space-x-4' : 'space-x-4'">
                        <Link v-if="blogs.prev_page_url" :href="blogs.prev_page_url"
                            class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <span v-if="isRTL">{{ getTranslation('pagination.previous') }} ←</span>
                        <span v-else>← {{ getTranslation('pagination.previous') }}</span>
                        </Link>

                        <div class="flex items-center" :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
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
                        <span v-if="isRTL">→ {{ getTranslation('pagination.next') }}</span>
                        <span v-else">{{ getTranslation('pagination.next') }} →</span>
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
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center"
                            :class="isRTL ? 'ml-2' : 'mr-2'">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ getTranslation('footer.title') }}
                        </h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        {{ getTranslation('footer.description') }}
                    </p>
                    <div class="flex justify-center" :class="isRTL ? 'space-x-reverse space-x-6' : 'space-x-6'">
                        <Link href="/"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        {{ getTranslation('footer.links.home') }}
                        </Link>
                        <Link href="/courses"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        {{ getTranslation('footer.links.courses') }}
                        </Link>
                        <Link href="/blog"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        {{ getTranslation('footer.links.blog') }}
                        </Link>
                        <Link href="/about"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        {{ getTranslation('footer.links.about') }}
                        </Link>
                        <Link href="/contact"
                            class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        {{ getTranslation('footer.links.contact') }}
                        </Link>
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8 mt-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        {{ getTranslation('footer.copyright') }}
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap');

.font-tajawal {
    font-family: 'Tajawal', sans-serif;
}

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

/* RTL specific hover effects */
[dir="rtl"] .hover\:translate-x-1:hover {
    transform: translateX(-0.25rem);
}

[dir="rtl"] .hover\:-translate-x-1:hover {
    transform: translateX(-0.25rem);
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}
</style>