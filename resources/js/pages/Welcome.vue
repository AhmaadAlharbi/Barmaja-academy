<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import Navbar from '@/components/Navbar.vue';

const page = usePage();

defineProps<{
    auth?: {
        user?: any;
    };
    translations?: any;
    threeCourses?: Array<{
        id: number;
        title_ar: string;
        title_en: string;
        slug: string;
        description_ar: string;
        description_en: string;
        price: number;
        preview_video_url: string | null;
        is_published: number;
        created_at: string;
        updated_at: string;
    }>;
    threeBlogs?: Array<{
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
}>();

// Get current locale
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');

// Get translations from props with fallbacks
const translations = computed(() => page.props.translations?.home || {});

// Comprehensive fallback translations
const fallbackTranslations = {
    hero: {
        title: isRTL.value ? 'إتقان' : 'Master',
        subtitle: isRTL.value ? 'البرمجة' : 'Programming',
        description: isRTL.value
            ? 'انضم إلى أكاديمية برمجة وتعلم البرمجة من خبراء الصناعة. ابدأ رحلتك في عالم التكنولوجيا اليوم.'
            : 'Join Barmaja Academy and learn programming from industry experts. Start your journey in the world of technology today.',
        explore_courses: isRTL.value ? 'استكشف الدورات' : 'Explore Courses',
        watch_demo: isRTL.value ? 'شاهد العرض التوضيحي' : 'Watch Demo',
        stats: {
            students: isRTL.value ? 'طالب' : 'Students',
            courses: isRTL.value ? 'دورة' : 'Courses',
            instructors: isRTL.value ? 'مدرس' : 'Instructors'
        }
    },
    featured_courses: {
        title: isRTL.value ? 'الدورات المميزة' : 'Featured Courses',
        subtitle: isRTL.value ? 'اكتشف أشهر دوراتنا المقدمة من خبراء الصناعة' : 'Discover our most popular courses taught by industry experts',
        bestseller: isRTL.value ? 'الأكثر مبيعاً' : 'Bestseller',
        preview_available: isRTL.value ? 'معاينة متاحة' : 'Preview Available',
        enroll_now: isRTL.value ? 'اشترك الآن' : 'Enroll Now',
        view_all: isRTL.value ? 'عرض جميع الدورات' : 'View All Courses',
        hours: isRTL.value ? 'ساعة' : 'hours',
        students: isRTL.value ? 'طالب' : 'students'
    },
    features: {
        title: isRTL.value ? 'لماذا تختار أكاديمية برمجة؟' : 'Why Choose Barmaja Academy?',
        subtitle: isRTL.value ? 'نوفر لك كل ما تحتاجه لإتقان البرمجة والتقدم في مسيرتك المهنية' : 'We provide everything you need to master programming and advance your career',
        items: {
            videos: {
                title: isRTL.value ? 'فيديوهات عالية الجودة' : 'High-Quality Videos',
                description: isRTL.value ? 'تعلم مع فيديوهات واضحة بدقة عالية ووصول مدى الحياة.' : 'Learn with crystal-clear HD videos and lifetime access.'
            },
            instructors: {
                title: isRTL.value ? 'مدرسون خبراء' : 'Expert Instructors',
                description: isRTL.value ? 'تعلم من المحترفين في الصناعة مع سنوات من الخبرة العملية.' : 'Learn from industry professionals with years of real-world experience.'
            },
            certificates: {
                title: isRTL.value ? 'شهادات معترف بها' : 'Recognized Certificates',
                description: isRTL.value ? 'احصل على شهادات معترف بها عند الانتهاء لإظهار مهاراتك.' : 'Earn recognized certificates upon completion to showcase your skills.'
            },
            labs: {
                title: isRTL.value ? 'مختبرات تطبيقية' : 'Hands-on Labs',
                description: isRTL.value ? 'تدرب على البرمجة مع مختبراتنا التفاعلية ومشاريع حقيقية.' : 'Practice coding with our interactive labs and real projects.'
            },
            support: {
                title: isRTL.value ? 'دعم ٢٤/٧' : '24/7 Support',
                description: isRTL.value ? 'احصل على المساعدة وقتما تحتاجها من فريق الدعم المخصص.' : 'Get help whenever you need it from our dedicated support team.'
            },
            mobile: {
                title: isRTL.value ? 'التعلم المحمول' : 'Mobile Learning',
                description: isRTL.value ? 'تعلم أثناء التنقل مع منصتنا المحسنة للهواتف.' : 'Learn on the go with our mobile-optimized platform.'
            }
        }
    },
    blog: {
        title: isRTL.value ? 'آخر مقالات مدونتنا' : 'Latest from Our Blog',
        subtitle: isRTL.value ? 'ابق على اطلاع على أحدث الاتجاهات والنصائح في عالم التكنولوجيا' : 'Stay updated with the latest trends and insights from the tech world',
        tech_trends: isRTL.value ? 'اتجاهات التكنولوجيا' : 'Tech Trends',
        read_more: isRTL.value ? 'اقرأ المزيد' : 'Read More',
        view_all: isRTL.value ? 'عرض جميع المقالات' : 'View All Posts'
    },
    cta: {
        title: isRTL.value ? 'هل أنت مستعد لبدء رحلتك في البرمجة؟' : 'Ready to Start Your Programming Journey?',
        subtitle: isRTL.value ? 'انضم إلى آلاف الطلاب في أكاديمية برمجة الذين يبنون تطبيقات مذهلة' : 'Join thousands of students building amazing applications at Barmaja Academy',
        browse_courses: isRTL.value ? 'تصفح الدورات' : 'Browse Courses',
        sign_up_free: isRTL.value ? 'سجل مجاناً' : 'Sign Up Free'
    },
    footer: {
        description: isRTL.value ? 'تمكين المبرمجين الطموحين بدورات شاملة ومشاريع عملية لبناء مسيرة مهنية ناجحة.' : 'Empowering aspiring programmers with comprehensive courses and hands-on projects.',
        quick_links: isRTL.value ? 'روابط سريعة' : 'Quick Links',
        categories: isRTL.value ? 'الفئات' : 'Categories',
        support: isRTL.value ? 'الدعم' : 'Support',
        copyright: isRTL.value ? '© ٢٠٢ل أكاديمية برمجة. جميع الحقوق محفوظة.' : '© 2024 Barmaja Academy. All rights reserved.',
        links: {
            courses: isRTL.value ? 'الدورات' : 'Courses',
            blog: isRTL.value ? 'المدونة' : 'Blog',
            about: isRTL.value ? 'من نحن' : 'About Us',
            contact: isRTL.value ? 'اتصل بنا' : 'Contact',
            careers: isRTL.value ? 'الوظائف' : 'Careers',
            help_center: isRTL.value ? 'مركز المساعدة' : 'Help Center',
            privacy_policy: isRTL.value ? 'سياسة الخصوصية' : 'Privacy Policy',
            terms_of_service: isRTL.value ? 'شروط الخدمة' : 'Terms of Service',
            privacy: isRTL.value ? 'الخصوصية' : 'Privacy',
            terms: isRTL.value ? 'الشروط' : 'Terms'
        },
        categories_list: {
            web_development: isRTL.value ? 'تطوير الويب' : 'Web Development',
            mobile_development: isRTL.value ? 'تطوير تطبيقات الجوال' : 'Mobile Development',
            backend_development: isRTL.value ? 'تطوير الخلفية' : 'Backend Development',
            frontend_frameworks: isRTL.value ? 'إطارات العمل الأمامية' : 'Frontend Frameworks',
            database_design: isRTL.value ? 'تصميم قواعد البيانات' : 'Database Design'
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

// Animation states
const heroVisible = ref(false);

onMounted(() => {
    setTimeout(() => heroVisible.value = true, 100);
});

// Enhanced feature configuration with improved icons and styling
const enhancedFeatures = [
    {
        key: 'videos',
        icon: 'fas fa-play-circle',
        gradient: 'from-red-500 to-pink-600',
        bgPattern: 'from-red-50 to-pink-50 dark:from-red-900/10 dark:to-pink-900/10'
    },
    {
        key: 'instructors',
        icon: 'fas fa-user-graduate',
        gradient: 'from-blue-500 to-indigo-600',
        bgPattern: 'from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10'
    },
    {
        key: 'certificates',
        icon: 'fas fa-award',
        gradient: 'from-yellow-500 to-orange-600',
        bgPattern: 'from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10'
    },
    {
        key: 'labs',
        icon: 'fas fa-code',
        gradient: 'from-green-500 to-emerald-600',
        bgPattern: 'from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10'
    },
    {
        key: 'support',
        icon: 'fas fa-comments',
        gradient: 'from-purple-500 to-violet-600',
        bgPattern: 'from-purple-50 to-violet-50 dark:from-purple-900/10 dark:to-violet-900/10'
    },
    {
        key: 'mobile',
        icon: 'fas fa-mobile-alt',
        gradient: 'from-cyan-500 to-blue-600',
        bgPattern: 'from-cyan-50 to-blue-50 dark:from-cyan-900/10 dark:to-blue-900/10'
    }
];

// Course images array - high quality programming-related images
const courseImages = [
    'https://images.unsplash.com/photo-1517180102446-f3ece451e9d8?w=500&h=300&fit=crop', // JavaScript/Web Development
    'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=500&h=300&fit=crop', // Mobile Development  
    'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=500&h=300&fit=crop', // Backend Development
    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500&h=300&fit=crop', // Frontend Frameworks
    'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=500&h=300&fit=crop', // Database Design
    'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=500&h=300&fit=crop'  // API Development
];

// Blog images array - diverse tech and programming images
const blogImages = [
    'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=500&h=300&fit=crop', // Technology/Programming
    'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=500&h=300&fit=crop', // Code editor
    'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=500&h=300&fit=crop', // Data/Analytics
    'https://images.unsplash.com/photo-1526378722484-bd91ca387119?w=500&h=300&fit=crop', // Mobile apps
    'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=500&h=300&fit=crop', // Startup/Tech
    'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=500&h=300&fit=crop'  // Programming setup
];
</script>

<template>

    <Head :title="`${getTranslation('hero.title')} ${getTranslation('hero.subtitle')} - Barmaja Academy`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <meta name="description" :content="getTranslation('hero.description')" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 transition-all duration-500"
        :dir="isRTL ? 'rtl' : 'ltr'" :class="{ 'font-tajawal': isRTL }">

        <!-- Navigation -->
        <Navbar />

        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background Elements -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-purple-900/20">
            </div>
            <div class="absolute -top-40 w-80 h-80 bg-blue-500/10 dark:bg-blue-400/5 rounded-full blur-3xl"
                :class="isRTL ? '-left-40' : '-right-40'"></div>
            <div class="absolute -bottom-40 w-80 h-80 bg-purple-500/10 dark:bg-purple-400/5 rounded-full blur-3xl"
                :class="isRTL ? '-right-40' : '-left-40'"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    <!-- Content -->
                    <div class="text-center lg:text-start" :class="{ 'lg:text-end': isRTL }">
                        <Transition appear enter-active-class="transition duration-1000 ease-out"
                            enter-from-class="transform translate-y-8 opacity-0"
                            enter-to-class="transform translate-y-0 opacity-100">
                            <div v-if="heroVisible">
                                <h1
                                    class="text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                                    {{ getTranslation('hero.title') }}
                                    <span
                                        class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600">
                                        {{ getTranslation('hero.subtitle') }}
                                    </span>
                                </h1>
                                <p class="text-xl lg:text-2xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed max-w-2xl"
                                    :class="isRTL ? 'lg:mr-auto' : 'lg:ml-0'">
                                    {{ getTranslation('hero.description') }}
                                </p>
                            </div>
                        </Transition>

                        <Transition appear enter-active-class="transition duration-1000 ease-out delay-300"
                            enter-from-class="transform translate-y-8 opacity-0"
                            enter-to-class="transform translate-y-0 opacity-100">
                            <div v-if="heroVisible"
                                class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-start mb-12"
                                :class="{ 'lg:justify-end': isRTL }">
                                <Link href="/courses/list"
                                    class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-2xl text-lg font-semibold shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <span class="relative z-10">{{ getTranslation('hero.explore_courses') }}</span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-blue-700 to-purple-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                </Link>
                                <button
                                    class="group px-8 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-600 dark:hover:border-blue-400 rounded-2xl text-lg font-semibold transition-all duration-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                    <i class="fas fa-play" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                    {{ getTranslation('hero.watch_demo') }}
                                </button>
                            </div>
                        </Transition>

                        <!-- Stats -->
                        <Transition appear enter-active-class="transition duration-1000 ease-out delay-500"
                            enter-from-class="transform translate-y-8 opacity-0"
                            enter-to-class="transform translate-y-0 opacity-100">
                            <div v-if="heroVisible"
                                class="grid grid-cols-3 gap-8 pt-12 border-t border-gray-200/50 dark:border-gray-700/50">
                                <div class="text-center group">
                                    <div
                                        class="text-4xl lg:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 group-hover:scale-110 transition-transform duration-300">
                                        10K+</div>
                                    <div class="text-sm lg:text-base text-gray-600 dark:text-gray-400 mt-2 font-medium">
                                        {{ getTranslation('hero.stats.students') }}
                                    </div>
                                </div>
                                <div class="text-center group">
                                    <div
                                        class="text-4xl lg:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 group-hover:scale-110 transition-transform duration-300">
                                        100+</div>
                                    <div class="text-sm lg:text-base text-gray-600 dark:text-gray-400 mt-2 font-medium">
                                        {{ getTranslation('hero.stats.courses') }}
                                    </div>
                                </div>
                                <div class="text-center group">
                                    <div
                                        class="text-4xl lg:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600 group-hover:scale-110 transition-transform duration-300">
                                        50+</div>
                                    <div class="text-sm lg:text-base text-gray-600 dark:text-gray-400 mt-2 font-medium">
                                        {{ getTranslation('hero.stats.instructors') }}
                                    </div>
                                </div>
                            </div>
                        </Transition>
                    </div>

                    <!-- Hero Illustration -->
                    <div class="relative lg:h-96">
                        <Transition appear enter-active-class="transition duration-1000 ease-out delay-200"
                            enter-from-class="transform opacity-0"
                            :enter-from-style="{ transform: isRTL ? 'translateX(-2rem)' : 'translateX(2rem)' }"
                            enter-to-class="transform translate-x-0 opacity-100">
                            <div v-if="heroVisible" class="relative">
                                <!-- Main Card -->
                                <div
                                    class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-2xl transform rotate-2 hover:rotate-0 transition-all duration-500 border border-white/20 dark:border-gray-700/20">
                                    <div class="flex items-center mb-6" :class="{ 'flex-row-reverse': isRTL }">
                                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg"
                                            :class="isRTL ? 'ml-4' : 'mr-4'">
                                            <i class="fas fa-code text-white text-2xl"></i>
                                        </div>
                                        <div :class="{ 'text-right': isRTL }">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                                {{ isRTL ? 'دورة جافاسكريبت الشاملة' : 'Complete JavaScript Course' }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                {{ isRTL ? 'من المبتدئ إلى الاحتراف' : 'From beginner to professional'
                                                }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600 dark:text-gray-400">
                                                {{ isRTL ? 'التقدم' : 'Progress' }}
                                            </span>
                                            <span
                                                class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">75%</span>
                                        </div>
                                        <div
                                            class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                            <div
                                                class="bg-gradient-to-r from-blue-600 to-purple-600 h-full rounded-full w-3/4 transition-all duration-1000 ease-out">
                                            </div>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                            <span>{{ isRTL ? '١٢ من ١٦ درس' : '12 of 16 lessons' }}</span>
                                            <span>{{ isRTL ? '٤ ساعات و٣٠ دقيقة متبقية' : '4h 30m left' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Floating Elements -->
                                <div class="absolute -top-6 w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full opacity-20 animate-pulse"
                                    :class="isRTL ? '-right-6' : '-left-6'"></div>
                                <div class="absolute -bottom-6 w-20 h-20 bg-gradient-to-br from-pink-400 to-rose-500 rounded-full opacity-20 animate-pulse"
                                    :class="isRTL ? '-left-6' : '-right-6'" style="animation-delay: 1s;"></div>
                                <div class="absolute top-1/2 w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full opacity-20 animate-pulse"
                                    :class="isRTL ? '-left-8' : '-right-8'" style="animation-delay: 2s;"></div>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Courses Section -->
        <section class="py-20 lg:py-32 bg-white dark:bg-gray-800 relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-purple-50/50 dark:from-blue-900/10 dark:to-purple-900/10">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ getTranslation('featured_courses.title') }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                        {{ getTranslation('featured_courses.subtitle') }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                    <div v-for="(course, index) in threeCourses" :key="course.id"
                        class="group bg-white dark:bg-gray-900 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 dark:border-gray-800">

                        <div class="relative overflow-hidden">
                            <!-- Dynamic programming-related images based on course index -->
                            <img :src="courseImages[index % courseImages.length]"
                                :alt="getLocalizedContent(course, 'title')"
                                class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            <!-- Badges -->
                            <div class="absolute top-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg"
                                :class="isRTL ? 'left-4' : 'right-4'">
                                {{ getTranslation('featured_courses.bestseller') }}
                            </div>
                            <div class="absolute bottom-4 bg-black/70 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium"
                                :class="isRTL ? 'right-4' : 'left-4'">
                                <i class="fas fa-play" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                {{ getTranslation('featured_courses.preview_available') }}
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="flex items-center justify-between mb-4">
                                <span
                                    class="text-sm text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wider">
                                    {{ course.slug }}
                                </span>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium"
                                        :class="isRTL ? 'mr-2' : 'ml-2'">4.9</span>
                                </div>
                            </div>

                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white mb-4 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                :class="{ 'text-right': isRTL }">
                                {{ getLocalizedContent(course, 'title') }}
                            </h3>

                            <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3 leading-relaxed"
                                :class="{ 'text-right': isRTL }">
                                {{ getLocalizedContent(course, 'description') }}
                            </p>

                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center text-gray-600 dark:text-gray-400"
                                    :class="isRTL ? 'space-x-reverse space-x-4' : 'space-x-4'">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        <span class="text-sm font-medium">24 {{ getTranslation('featured_courses.hours')
                                        }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-users" :class="isRTL ? 'ml-2' : 'mr-2'"></i>
                                        <span class="text-sm font-medium">1,234 {{
                                            getTranslation('featured_courses.students') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-6">
                                <div class="text-3xl font-bold text-gray-900 dark:text-white">
                                    ${{ course.price }}
                                </div>
                            </div>

                            <button
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-4 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                {{ getTranslation('featured_courses.enroll_now') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-16">
                    <Link href="/courses/list"
                        class="inline-flex items-center px-8 py-4 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-bold text-lg bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-2xl transition-all duration-300"
                        :class="isRTL ? 'space-x-reverse space-x-3' : 'space-x-3'">
                    <span>{{ getTranslation('featured_courses.view_all') }}</span>
                    <i class="fas fa-arrow-right" :class="{ 'fas fa-arrow-left': isRTL }"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Features Section - Enhanced with better icons and design -->
        <section class="py-20 lg:py-32 bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-40">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 via-purple-600/5 to-indigo-600/5"></div>
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background-image: radial-gradient(circle at 25% 25%, #3b82f640 0%, transparent 50%), radial-gradient(circle at 75% 75%, #8b5cf640 0%, transparent 50%)">
                </div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ getTranslation('features.title') }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                        {{ getTranslation('features.subtitle') }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                    <!-- Enhanced Feature Cards -->
                    <div v-for="(feature, index) in enhancedFeatures" :key="feature.key"
                        class="group relative p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 text-center border border-gray-100 dark:border-gray-700 overflow-hidden"
                        :class="{ 'text-right': isRTL }">

                        <!-- Background Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-br opacity-0 group-hover:opacity-5 transition-opacity duration-500"
                            :class="feature.bgPattern"></div>

                        <!-- Icon Container with Enhanced Design -->
                        <div class="relative mb-8">
                            <!-- Outer Ring -->
                            <div class="absolute inset-0 w-24 h-24 mx-auto rounded-full bg-gradient-to-r opacity-20 group-hover:opacity-30 transition-opacity duration-300 animate-pulse"
                                :class="feature.gradient"></div>

                            <!-- Main Icon Container -->
                            <div class="relative w-24 h-24 mx-auto bg-gradient-to-r rounded-full flex items-center justify-center shadow-xl group-hover:shadow-2xl group-hover:scale-110 transition-all duration-300"
                                :class="feature.gradient">
                                <i :class="feature.icon" class="text-white text-4xl"></i>
                            </div>

                            <!-- Decorative Elements -->
                            <div class="absolute top-2 right-2 w-3 h-3 bg-white/30 rounded-full animate-ping"
                                style="animation-delay: 0.5s;"></div>
                            <div class="absolute bottom-2 left-2 w-2 h-2 bg-white/40 rounded-full animate-ping"
                                style="animation-delay: 1s;"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white mb-4 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r transition-all duration-300"
                                :class="`group-hover:${feature.gradient}`">
                                {{ getTranslation(`features.items.${feature.key}.title`) }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ getTranslation(`features.items.${feature.key}.description`) }}
                            </p>
                        </div>

                        <!-- Hover Effect Border -->
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-r opacity-0 group-hover:opacity-20 transition-opacity duration-300 pointer-events-none"
                            :class="feature.gradient" style="padding: 2px;">
                            <div class="w-full h-full bg-white dark:bg-gray-800 rounded-3xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section with Better Images -->
        <section class="py-20 lg:py-32 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ getTranslation('blog.title') }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                        {{ getTranslation('blog.subtitle') }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                    <article v-for="(blog, index) in threeBlogs" :key="blog.id"
                        class="group bg-white dark:bg-gray-900 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 dark:border-gray-800">
                        <div class="relative overflow-hidden">
                            <!-- Dynamic tech-related images -->
                            <img :src="blogImages[index % blogImages.length]" :alt="getLocalizedContent(blog, 'title')"
                                class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                            <!-- Category Badge -->
                            <div
                                class="absolute top-4 left-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ getTranslation('blog.tech_trends') }}
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="flex items-center text-sm text-blue-600 dark:text-blue-400 font-medium mb-4"
                                :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                                <span>{{ getTranslation('blog.tech_trends') }}</span>
                                <span>•</span>
                                <span>{{ isRTL ? '١٥ يناير ٢٠٢٤' : 'Jan 15, 2024' }}</span>
                            </div>

                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white mb-4 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                :class="{ 'text-right': isRTL }">
                                {{ getLocalizedContent(blog, 'title') }}
                            </h3>

                            <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3 leading-relaxed"
                                :class="{ 'text-right': isRTL }">
                                {{ getLocalizedContent(blog, 'content').substring(0, 150) }}...
                            </p>

                            <Link :href="`/blogs/${blog.slug}`"
                                class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-bold transition-colors"
                                :class="isRTL ? 'space-x-reverse space-x-2' : 'space-x-2'">
                            <span>{{ getTranslation('blog.read_more') }}</span>
                            <i class="fas fa-arrow-right" :class="{ 'fas fa-arrow-left': isRTL }"></i>
                            </Link>
                        </div>
                    </article>
                </div>

                <div class="text-center mt-16">
                    <Link href="/blogs/list"
                        class="inline-flex items-center px-8 py-4 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-bold text-lg bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-2xl transition-all duration-300"
                        :class="isRTL ? 'space-x-reverse space-x-3' : 'space-x-3'">
                    <span>{{ getTranslation('blog.view_all') }}</span>
                    <i class="fas fa-arrow-right" :class="{ 'fas fa-arrow-left': isRTL }"></i>
                    </Link>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 lg:py-32 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700"></div>
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-8 leading-tight">
                    {{ getTranslation('cta.title') }}
                </h2>
                <p class="text-xl lg:text-2xl text-blue-100 mb-12 max-w-3xl mx-auto leading-relaxed">
                    {{ getTranslation('cta.subtitle') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <Link href="/courses/list"
                        class="px-10 py-5 bg-white text-blue-600 hover:bg-gray-100 rounded-2xl text-lg font-bold shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    {{ getTranslation('cta.browse_courses') }}
                    </Link>
                    <Link href="/register"
                        class="px-10 py-5 border-2 border-white text-white hover:bg-white hover:text-blue-600 rounded-2xl text-lg font-bold shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    {{ getTranslation('cta.sign_up_free') }}
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-black"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
                    <!-- Company Info -->
                    <div class="lg:col-span-1">
                        <div class="flex items-center mb-8" :class="{ 'flex-row-reverse': isRTL }">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg"
                                :class="isRTL ? 'ml-4' : 'mr-4'">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold">
                                {{ isRTL ? 'أكاديمية برمجة' : 'Barmaja Academy' }}
                            </h3>
                        </div>
                        <p class="text-gray-400 mb-8 leading-relaxed" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.description') }}
                        </p>
                        <div class="flex space-x-6" :class="{ 'space-x-reverse': isRTL }">
                            <a href="#"
                                class="text-gray-400 hover:text-white transition-colors transform hover:scale-110">
                                <i class="fab fa-facebook text-2xl"></i>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-white transition-colors transform hover:scale-110">
                                <i class="fab fa-twitter text-2xl"></i>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-white transition-colors transform hover:scale-110">
                                <i class="fab fa-linkedin text-2xl"></i>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-white transition-colors transform hover:scale-110">
                                <i class="fab fa-youtube text-2xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-bold mb-8" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.quick_links') }}
                        </h4>
                        <ul class="space-y-4">
                            <li>
                                <Link href="/courses/list"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.courses') }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/blogs/list"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.blog') }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/about"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.about') }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/contact-us"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                {{ getTranslation('footer.links.contact') }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h4 class="text-lg font-bold mb-8" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.categories') }}
                        </h4>
                        <ul class="space-y-4">
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.categories_list.web_development') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.categories_list.mobile_development') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.categories_list.backend_development') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.categories_list.frontend_frameworks') }}
                                </a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-lg font-bold mb-8" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.support') }}
                        </h4>
                        <ul class="space-y-4">
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.help_center') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.privacy_policy') }}
                                </a></li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors hover:translate-x-1 inline-block"
                                    :class="{ 'text-right': isRTL, 'hover:-translate-x-1': isRTL }">
                                    {{ getTranslation('footer.links.terms_of_service') }}
                                </a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-12 mt-16">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p class="text-gray-400" :class="{ 'text-right': isRTL }">
                            {{ getTranslation('footer.copyright') }}
                        </p>
                        <div class="flex items-center space-x-8" :class="{ 'space-x-reverse': isRTL }">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                {{ getTranslation('footer.links.privacy') }}
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                {{ getTranslation('footer.links.terms') }}
                            </a>
                        </div>
                    </div>
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

/* Custom animations */
@keyframes float {

    0%,
    100% {
        transform: translateY(0px);
    }

    50% {
        transform: translateY(-10px);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

/* Enhanced pulse animation */
@keyframes enhanced-pulse {

    0%,
    100% {
        opacity: 0.6;
        transform: scale(1);
    }

    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

.animate-enhanced-pulse {
    animation: enhanced-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Custom gradient text hover effect */
.gradient-text-hover {
    background: linear-gradient(45deg, #3b82f6, #8b5cf6);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient-shift 3s ease infinite;
}

@keyframes gradient-shift {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}
</style>