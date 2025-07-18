<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const page = usePage();
const currentUrl = page.url;

defineProps<{
    auth?: {
        user?: any;
    };
}>();

// Language switcher state
const showLanguageDropdown = ref(false);
const languageDropdownRef = ref(null);

// Get current locale and translations
const currentLocale = computed(() => {
    return page.props.locale?.current || 'en';
});

const translations = computed(() => {
    return page.props.translations?.navbar || {};
});

// Get supported locales from middleware (already includes URLs)
const supportedLocales = computed(() => {
    console.log('Supported locales:', page.props.locale?.supported); // Debug log
    return page.props.locale?.supported || [];
});

// Get current locale display info
const currentLocaleInfo = computed(() => {
    return supportedLocales.value.find(l => l.code === currentLocale.value) || {
        code: 'en',
        native: 'English'
    };
});

// Navigation items with translations
const navItems = computed(() => [
    { name: translations.value.home || (currentLocale.value === 'ar' ? 'الرئيسية' : 'Home'), href: '/' },
    { name: translations.value.courses || (currentLocale.value === 'ar' ? 'الدورات' : 'Courses'), href: '/courses/list' },
    { name: translations.value.blog || (currentLocale.value === 'ar' ? 'المدونة' : 'Blog'), href: '/blogs/list' },
]);

// Helper function to get flag emoji
function getFlagEmoji(localeCode: string) {
    const flags = {
        'en': '🇺🇸',
        'ar': '🇸🇦',
        'es': '🇪🇸',
        'fr': '🇫🇷',
        'de': '🇩🇪',
    };
    return flags[localeCode] || '🌐';
}

// Click outside handler
function handleClickOutside(event) {
    if (languageDropdownRef.value && !languageDropdownRef.value.contains(event.target)) {
        showLanguageDropdown.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    // Debug: Check what data we have
    console.log('Current locale:', currentLocale.value);
    console.log('Page props:', page.props);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

// Mobile menu state
const isMenuOpen = ref(false);

function toggleMobileMenu() {
    isMenuOpen.value = !isMenuOpen.value;
}

function toggleMenu() {
    isMenuOpen.value = !isMenuOpen.value;
}

const isLoggingOut = ref(false);

function logout() {
    isLoggingOut.value = true;
    setTimeout(() => {
        router.post('/logout', {}, {
            onFinish: () => {
                isLoggingOut.value = false;
            },
            progress: false,
        });
    }, 300);
}

function switchLanguage(localeCode: string) {
    console.log('Switching to:', localeCode); // Debug log
    const locale = supportedLocales.value.find(l => l.code === localeCode);
    console.log('Found locale:', locale); // Debug log

    if (locale && locale.url) {
        window.location.href = locale.url;
    } else {
        // Fallback: construct URL manually
        const baseUrl = window.location.origin;
        const currentPath = window.location.pathname;

        // Remove existing locale from path
        const cleanPath = currentPath.replace(/^\/[a-z]{2}(\/|$)/, '/');

        // Add new locale
        const newUrl = localeCode === 'en'
            ? `${baseUrl}${cleanPath}`
            : `${baseUrl}/${localeCode}${cleanPath}`;

        console.log('Redirecting to:', newUrl); // Debug log
        window.location.href = newUrl;
    }
    showLanguageDropdown.value = false;
}

function toggleLanguageDropdown() {
    console.log('Toggling dropdown, current state:', showLanguageDropdown.value); // Debug log
    showLanguageDropdown.value = !showLanguageDropdown.value;
}
</script>

<template>
    <nav class="bg-white dark:bg-gray-900 shadow-lg sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <Link href="/" class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ currentLocale === 'ar' ? 'أكاديمية برمجة' : 'Barmaja Academy' }}
                </span>
                </Link>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8"
                    :class="{ 'space-x-reverse': currentLocale === 'ar' }">
                    <Link v-for="item in navItems" :key="item.name" :href="item.href"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">
                    {{ item.name }}
                    </Link>
                </div>

                <!-- Desktop Actions -->
                <div class="hidden md:flex items-center space-x-4"
                    :class="{ 'space-x-reverse': currentLocale === 'ar' }">
                    <!-- Dark Mode Toggle -->
                    <button
                        class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <i class="fas fa-sun dark:hidden text-lg"></i>
                        <i class="fas fa-moon hidden dark:block text-lg"></i>
                    </button>

                    <!-- Language Switcher -->
                    <div class="relative" ref="languageDropdownRef">
                        <button @click="toggleLanguageDropdown"
                            class="flex items-center space-x-2 p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors border border-transparent hover:border-gray-300">
                            <span class="text-lg">{{ getFlagEmoji(currentLocale) }}</span>
                            <span class="text-sm font-medium">{{ currentLocaleInfo.native }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform"
                                :class="{ 'rotate-180': showLanguageDropdown }"></i>
                        </button>

                        <!-- Language Dropdown -->
                        <div v-if="showLanguageDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 py-1">
                            <!-- Debug: Show if we have locales -->
                            <div v-if="supportedLocales.length === 0" class="px-4 py-2 text-sm text-gray-500">
                                No locales available
                            </div>

                            <button v-for="locale in supportedLocales" :key="locale.code"
                                @click="switchLanguage(locale.code)"
                                class="flex items-center space-x-3 w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                :class="{
                                    'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400': locale.code === currentLocale,
                                    'text-gray-700 dark:text-gray-300': locale.code !== currentLocale
                                }">
                                <span class="text-lg">{{ getFlagEmoji(locale.code) }}</span>
                                <span class="text-sm">{{ locale.native }}</span>
                                <i v-if="locale.code === currentLocale" class="fas fa-check text-xs ml-auto"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Auth Buttons -->
                    <div v-if="!$page.props.auth.user" class="flex items-center space-x-3"
                        :class="{ 'space-x-reverse': currentLocale === 'ar' }">
                        <Link href="/login"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">
                        {{ currentLocale === 'ar' ? 'دخول' : 'Login' }}
                        </Link>
                        <Link href="/register"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        {{ currentLocale === 'ar' ? 'تسجيل' : 'Sign Up' }}
                        </Link>
                    </div>

                    <!-- User Menu (if authenticated) -->
                    <div v-else class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">
                                    {{ $page.props.auth.user.name?.charAt(0).toUpperCase() }}
                                </span>
                            </div>
                            <span>{{ $page.props.auth.user.name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- User Dropdown -->
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="py-2">
                                <Link href="/dashboard"
                                    class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ currentLocale === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                                </Link>
                                <Link href="/profile"
                                    class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ currentLocale === 'ar' ? 'الملف الشخصي' : 'Profile' }}
                                </Link>
                                <hr class="my-2 border-gray-200 dark:border-gray-700">
                                <Link href="/logout" method="post"
                                    class="block px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900">
                                {{ currentLocale === 'ar' ? 'خروج' : 'Logout' }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center space-x-2">
                    <!-- Mobile Language Switcher -->
                    <div class="relative">
                        <button @click="toggleLanguageDropdown"
                            class="flex items-center p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <span class="text-lg">{{ getFlagEmoji(currentLocale) }}</span>
                        </button>

                        <!-- Mobile Language Dropdown -->
                        <div v-if="showLanguageDropdown"
                            class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                            <div class="py-2">
                                <button v-for="locale in supportedLocales" :key="locale.code"
                                    @click="switchLanguage(locale.code)"
                                    class="flex items-center space-x-2 w-full px-3 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                    :class="{ 'bg-blue-50 dark:bg-blue-900': locale.code === currentLocale }">
                                    <span class="text-lg">{{ getFlagEmoji(locale.code) }}</span>
                                    <span class="text-sm">{{ locale.native }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button @click="toggleMenu"
                        class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <i class="fas fa-bars text-lg" :class="{ 'fa-times': isMenuOpen, 'fa-bars': !isMenuOpen }"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div v-show="isMenuOpen" class="md:hidden border-t border-gray-200 dark:border-gray-700 py-4 space-y-2">
                <Link v-for="item in navItems" :key="item.name" :href="item.href"
                    class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                    @click="isMenuOpen = false">
                {{ item.name }}
                </Link>

                <hr class="border-gray-200 dark:border-gray-700">

                <div v-if="!$page.props.auth.user" class="space-y-2">
                    <Link href="/login"
                        class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                        @click="isMenuOpen = false">
                    {{ currentLocale === 'ar' ? 'دخول' : 'Login' }}
                    </Link>
                    <Link href="/register"
                        class="block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors text-center"
                        @click="isMenuOpen = false">
                    {{ currentLocale === 'ar' ? 'تسجيل' : 'Sign Up' }}
                    </Link>
                </div>

                <div v-else class="space-y-2">
                    <div class="px-4 py-2 text-gray-500 dark:text-gray-400 text-sm">
                        {{ currentLocale === 'ar' ? 'مرحباً' : 'Welcome' }}, {{ $page.props.auth.user.name }}
                    </div>
                    <Link href="/dashboard"
                        class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    {{ currentLocale === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                    </Link>
                    <Link href="/profile"
                        class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    {{ currentLocale === 'ar' ? 'الملف الشخصي' : 'Profile' }}
                    </Link>
                    <Link href="/logout" method="post"
                        class="block px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900 rounded-lg transition-colors">
                    {{ currentLocale === 'ar' ? 'خروج' : 'Logout' }}
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>