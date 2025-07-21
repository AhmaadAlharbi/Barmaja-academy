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
        // Author relationship data
        author?: {
            id: number;
            name: string;
            email: string;
            avatar?: string;
            bio_ar?: string;
            bio_en?: string;
            title_ar?: string;
            title_en?: string;
            social_twitter?: string;
            social_github?: string;
            social_linkedin?: string;
        };
    };
    relatedBlogs?: Array<{
        id: number;
        title_ar: string;
        title_en: string;
        slug: string;
        content_ar: string;
        content_en: string;
        published_at: string;
        created_at: string;
        author?: {
            name: string;
            avatar?: string;
        };
    }>;
}>();

// Get current locale
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');

// Get translations from props with fallbacks
const translations = computed(() => page.props.translations?.blog_single || {});

// Comprehensive fallback translations
const fallbackTranslations = {
    navigation: {
        back_to_blog: isRTL.value ? 'العودة إلى المدونة' : 'Back to Blog'
    },
    article: {
        author_default: isRTL.value ? 'أحمد خليل' : 'Ahmed Khalil',
        author_title_default: isRTL.value ? 'مطور أول' : 'Senior Developer',
        author_bio_default: isRTL.value
            ? 'مطور ويب متكامل أول في أكاديمية برمجة مع أكثر من ٨ سنوات من الخبرة في تقنيات الويب الحديثة.'
            : 'Senior Full-Stack Developer at Barmaja Academy with 8+ years of experience in modern web technologies.',
        views: isRTL.value ? 'مشاهدة' : 'views',
        likes: isRTL.value ? 'إعجاب' : 'likes',
        comments: isRTL.value ? 'تعليق' : 'comments',
        min_read: isRTL.value ? 'دقيقة قراءة' : 'min read',
        share: isRTL.value ? 'شارك:' : 'Share:',
        tags_title: isRTL.value ? 'العلامات:' : 'Tags:',
        published_on: isRTL.value ? 'نُشر في' : 'Published on',
        updated_on: isRTL.value ? 'تم التحديث في' : 'Updated on',
        reading_time: isRTL.value ? 'وقت القراءة' : 'Reading time',
        featured_image_alt: isRTL.value ? 'صورة المقال المميزة' : 'Article featured image',
        author_bio_title: isRTL.value ? 'نبذة عن الكاتب' : 'About the Author',
        anonymous_author: isRTL.value ? 'مؤلف مجهول' : 'Anonymous Author'
    },
    author: {
        more_articles: isRTL.value ? 'المزيد من المقالات' : 'More articles',
        follow_on: isRTL.value ? 'تابع على' : 'Follow on',
        view_profile: isRTL.value ? 'عرض الملف الشخصي' : 'View Profile'
    },
    comments: {
        title: isRTL.value ? 'التعليقات' : 'Comments',
        leave_comment: isRTL.value ? 'اترك تعليق' : 'Leave a Comment',
        your_name: isRTL.value ? 'اسمك' : 'Your name',
        your_email: isRTL.value ? 'بريدك الإلكتروني' : 'Your email',
        write_comment: isRTL.value ? 'اكتب تعليقك...' : 'Write your comment...',
        post_comment: isRTL.value ? 'نشر التعليق' : 'Post Comment',
        reply: isRTL.value ? 'رد' : 'Reply',
        ago: isRTL.value ? 'منذ' : 'ago',
        hours: isRTL.value ? 'ساعات' : 'hours',
        minutes: isRTL.value ? 'دقائق' : 'minutes',
        days: isRTL.value ? 'أيام' : 'days'
    },
    related: {
        title: isRTL.value ? 'مقالات ذات صلة' : 'Related Articles',
        read_more: isRTL.value ? 'اقرأ المزيد' : 'Read more'
    },
    tags: {
        javascript: isRTL.value ? 'جافاسكريبت' : 'JavaScript',
        vue_js: isRTL.value ? 'فيو.جي اس' : 'Vue.js',
        web_development: isRTL.value ? 'تطوير الويب' : 'Web Development',
        tutorial: isRTL.value ? 'درس تعليمي' : 'Tutorial',
        react: isRTL.value ? 'ريأكت' : 'React',
        node_js: isRTL.value ? 'نود.جي اس' : 'Node.js',
        css: isRTL.value ? 'سي اس اس' : 'CSS',
        html: isRTL.value ? 'اتش تي ام ال' : 'HTML',
        programming: isRTL.value ? 'البرمجة' : 'Programming',
        frontend: isRTL.value ? 'الواجهة الأمامية' : 'Frontend',
        backend: isRTL.value ? 'الخلفية' : 'Backend',
        database: isRTL.value ? 'قاعدة البيانات' : 'Database'
    },
    social: {
        twitter: isRTL.value ? 'تويتر' : 'Twitter',
        linkedin: isRTL.value ? 'لينكد إن' : 'LinkedIn',
        facebook: isRTL.value ? 'فيس بوك' : 'Facebook',
        github: isRTL.value ? 'جيت هاب' : 'GitHub',
        copy_link: isRTL.value ? 'نسخ الرابط' : 'Copy Link',
        share_on: isRTL.value ? 'شارك على' : 'Share on'
    },
    footer: {
        title: isRTL.value ? 'أكاديمية برمجة' : 'Barmaja Academy',
        description: isRTL.value
            ? 'تمكين المطورين بالمعرفة والرؤى'
            : 'Empowering developers with knowledge and insights',
        copyright: isRTL.value ? '© ٢٠٢٤ أكاديمية برمجة. جميع الحقوق محفوظة.' : '© 2024 Barmaja Academy. All rights reserved.',
        links: {
            home: isRTL.value ? 'الرئيسية' : 'Home',
            courses: isRTL.value ? 'الدورات' : 'Courses',
            blog: isRTL.value ? 'المدونة' : 'Blog',
            about: isRTL.value ? 'من نحن' : 'About',
            contact: isRTL.value ? 'اتصل بنا' : 'Contact'
        }
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

// Helper functions for author information
const getAuthorName = (blog: any) => {
    if (blog.author?.name) {
        return blog.author.name;
    }
    return getTranslation('article.author_default');
};

const getAuthorTitle = (blog: any) => {
    if (blog.author && (blog.author.title_ar || blog.author.title_en)) {
        return getLocalizedContent(blog.author, 'title');
    }
    return getTranslation('article.author_title_default');
};

const getAuthorBio = (blog: any) => {
    if (blog.author && (blog.author.bio_ar || blog.author.bio_en)) {
        return getLocalizedContent(blog.author, 'bio');
    }
    return getTranslation('article.author_bio_default');
};

const getAuthorAvatar = (blog: any) => {
    if (blog.author?.avatar) {
        return blog.author.avatar;
    }
    // Default avatar from Unsplash
    return "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=face";
};

const getAuthorInitials = (name: string) => {
    return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
};

// Helper function to estimate reading time
const getReadingTime = (content: string) => {
    const wordsPerMinute = isRTL.value ? 180 : 200; // Arabic is typically slower to read
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

// Helper function to truncate text
const truncate = (text: string, length: number = 100) => {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
};

// Helper function to format time ago
const timeAgo = (dateString: string) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now.getTime() - date.getTime();
    const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
    const diffDays = Math.floor(diffHours / 24);

    if (diffHours < 1) {
        const diffMinutes = Math.floor(diffMs / (1000 * 60));
        return `${diffMinutes} ${getTranslation('comments.minutes')} ${getTranslation('comments.ago')}`;
    } else if (diffHours < 24) {
        return `${diffHours} ${getTranslation('comments.hours')} ${getTranslation('comments.ago')}`;
    } else {
        return `${diffDays} ${getTranslation('comments.days')} ${getTranslation('comments.ago')}`;
    }
};

// Helper function to extract sample tags from content
const extractTags = (blog: any) => {
    const content = getLocalizedContent(blog, 'content').toLowerCase();
    const availableTags = ['javascript', 'vue_js', 'react', 'node_js', 'css', 'html', 'web_development', 'tutorial', 'programming', 'frontend', 'backend', 'database'];

    const foundTags = availableTags.filter(tag => {
        const tagText = getTranslation(`tags.${tag}`).toLowerCase();
        return content.includes(tagText) || content.includes(tag.replace('_', ''));
    });

    // Return at least a few default tags if none found
    return foundTags.length > 0 ? foundTags.slice(0, 4) : ['programming', 'web_development', 'tutorial'];
};
</script>

<template>

    <Head :title="`${getLocalizedContent(blog, 'title')} - ${getTranslation('footer.title')}`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <meta name="description" :content="truncate(getLocalizedContent(blog, 'content'), 160)">
        <meta property="og:title" :content="getLocalizedContent(blog, 'title')">
        <meta property="og:description" :content="truncate(getLocalizedContent(blog, 'content'), 160)">
        <meta property="og:type" content="article">
        <meta name="author" :content="getAuthorName(blog)">
    </Head>

    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300" :dir="isRTL ? 'rtl' : 'ltr'"
        :class="{ 'font-tajawal': isRTL }">
        <Navbar />

        <!-- Back to Blog Navigation -->
        <section class="py-6 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <Link href="/blogs"
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                    :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                <i class="fas fa-arrow-left" :class="{ 'fas fa-arrow-right': isRTL }"></i>
                <span>{{ getTranslation('navigation.back_to_blog') }}</span>
                </Link>
            </div>
        </section>

        <!-- Article Header -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Article Meta -->
                <div class="mb-8">
                    <div class="flex items-center mb-6" :class="isRTL ? 'space-x-reverse space-x-4' : 'space-x-4'">
                        <!-- Author Avatar -->
                        <div class="relative">
                            <img v-if="blog.author?.avatar || getAuthorAvatar(blog)" :src="getAuthorAvatar(blog)"
                                :alt="getAuthorName(blog)"
                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                            <div v-else
                                class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ getAuthorInitials(getAuthorName(blog)) }}
                            </div>
                        </div>

                        <!-- Author Info -->
                        <div :class="{ 'text-right': isRTL }">
                            <p class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ getAuthorName(blog) }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400"
                                :class="isRTL ? 'space-x-reverse space-x-4' : 'space-x-4'">
                                <span>{{ formatDate(blog.published_at || blog.created_at) }}</span>
                                <span>•</span>
                                <span>{{ getReadingTime(getLocalizedContent(blog, 'content')) }}</span>
                                <span>•</span>
                                <span>{{ getAuthorTitle(blog) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Article Title -->
                    <h1 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white leading-tight mb-6"
                        :class="{ 'text-right': isRTL }">
                        {{ getLocalizedContent(blog, 'title') }}
                    </h1>


                </div>

                <!-- Featured Image -->
                <div class="mb-10">
                    <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=1200&h=600&fit=crop"
                        :alt="getTranslation('article.featured_image_alt')"
                        class="w-full h-64 lg:h-96 object-cover rounded-2xl shadow-lg">
                </div>
            </div>
        </section>

        <!-- Article Content -->
        <section class="pb-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    <!-- Blog Content -->
                    <div class="text-gray-800 dark:text-gray-200 leading-relaxed space-y-6"
                        :class="{ 'text-right': isRTL }">
                        <!-- Split content into paragraphs for better formatting -->
                        <template v-for="(paragraph, index) in getLocalizedContent(blog, 'content').split('\n\n')"
                            :key="index">
                            <p v-if="paragraph.trim()" class="text-lg leading-8">
                                {{ paragraph.trim() }}
                            </p>
                        </template>
                    </div>
                </div>





                <!-- Related Articles -->
                <div v-if="relatedBlogs && relatedBlogs.length > 0" class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8" :class="{ 'text-right': isRTL }">
                        {{ getTranslation('related.title') }}
                    </h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <article v-for="relatedBlog in relatedBlogs.slice(0, 4)" :key="relatedBlog.id"
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center mb-3"
                                    :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                                    <img v-if="relatedBlog.author?.avatar" :src="relatedBlog.author.avatar"
                                        :alt="relatedBlog.author.name" class="w-8 h-8 rounded-full">
                                    <div v-else
                                        class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-xs">
                                        {{ getAuthorInitials(relatedBlog.author?.name ||
                                            getTranslation('article.anonymous_author')) }}
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ relatedBlog.author?.name || getTranslation('article.anonymous_author') }}
                                    </span>
                                    <span class="text-sm text-gray-400">•</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ formatDate(relatedBlog.published_at || relatedBlog.created_at) }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 line-clamp-2"
                                    :class="{ 'text-right': isRTL }">
                                    {{ getLocalizedContent(relatedBlog, 'title') }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3"
                                    :class="{ 'text-right': isRTL }">
                                    {{ truncate(getLocalizedContent(relatedBlog, 'content'), 120) }}
                                </p>
                                <Link :href="`/blog/${relatedBlog.slug}`"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium inline-flex items-center"
                                    :class="isRTL ? 'space-x-reverse space-x-1' : 'space-x-1'">
                                <span>{{ getTranslation('related.read_more') }}</span>
                                <i class="fas fa-arrow-right text-xs" :class="{ 'fas fa-arrow-left': isRTL }"></i>
                                </Link>
                            </div>
                        </article>
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

[dir="rtl"] .prose ul,
[dir="rtl"] .prose ol {
    padding-right: 1.5rem;
    padding-left: 0;
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

[dir="rtl"] .prose blockquote {
    border-right: 4px solid #3b82f6;
    border-left: none;
    padding-right: 1rem;
    padding-left: 0;
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