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

// Get current locale from middleware
const currentLocale = computed(() => {
    return page.props.locale?.current || 'en';
});

// Get supported locales from middleware
const supportedLocales = computed(() => {
    return page.props.locale?.supported || [];
});

// Get current locale display info
const currentLocaleInfo = computed(() => {
    return supportedLocales.value.find(l => l.code === currentLocale.value) || {
        code: 'en',
        native: 'English'
    };
});

// Helper function to get flag emoji
function getFlagEmoji(localeCode: string) {
    const flags = {
        'en': '🇺🇸',
        'ar': '🇸🇦',
        'es': '🇪🇸',
        'fr': '🇫🇷',
        'de': '🇩🇪',
        // Add more as needed
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
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
}

const isLoggingOut = ref(false);

function logout() {
    isLoggingOut.value = true;

    // Slight delay before firing logout to make UX feel smoother
    setTimeout(() => {
        router.post('/logout', {}, {
            onFinish: () => {
                isLoggingOut.value = false;
            },
            progress: false,
        });
    }, 300); // delay 300ms
}

function switchLanguage(localeCode: string) {
    const locale = supportedLocales.value.find(l => l.code === localeCode);
    if (locale) {
        window.location.href = locale.url;
    }
    showLanguageDropdown.value = false;
}
</script>

<template>
    <nav class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Barmaja Academy</h1>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <Link href="/" :class="[
                        currentUrl === '/' ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-300',
                        'hover:text-blue-700 dark:hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium transition-colors'
                    ]">Home</Link>

                    <Link href="/courses/list" :class="[
                        currentUrl.startsWith('/courses') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-300',
                        'hover:text-blue-700 dark:hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium transition-colors'
                    ]">Courses</Link>

                    <Link href="/blogs/list" :class="[
                        currentUrl.startsWith('/blog') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-300',
                        'hover:text-blue-700 dark:hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium transition-colors'
                    ]">Blog</Link>

                    <Link href="/contact-us" :class="[
                        currentUrl.startsWith('/contact') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-300',
                        'hover:text-blue-700 dark:hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium transition-colors'
                    ]">Contact</Link>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher Dropdown -->
                    <div class="relative" ref="languageDropdownRef">
                        <button @click="showLanguageDropdown = !showLanguageDropdown"
                            class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 focus:outline-none hover:bg-gray-200 dark:hover:bg-gray-600 flex items-center space-x-2">
                            <span>{{ getFlagEmoji(currentLocale) }}</span>
                            <span>{{ currentLocaleInfo.native }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div v-if="showLanguageDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                            <div class="py-1">
                                <button v-for="locale in supportedLocales" :key="locale.code"
                                    @click="switchLanguage(locale.code)" :class="[
                                        locale.code === currentLocale ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300',
                                        'w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2'
                                    ]">
                                    <span>{{ getFlagEmoji(locale.code) }}</span>
                                    <span>{{ locale.native }}</span>
                                    <i v-if="locale.code === currentLocale"
                                        class="fas fa-check text-blue-600 dark:text-blue-400 ml-auto"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Switcher -->
                    <button
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <i class="fas fa-sun dark:hidden"></i>
                        <i class="fas fa-moon hidden dark:inline"></i>
                    </button>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-2">
                        <template v-if="$page.props.auth?.user">
                            <Link v-if="$page.props.auth?.user.role == 'admin'" href="/dashboard"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Dashboard
                            </Link>
                            <p class="bg-red-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Hello, {{ $page.props.auth.user.name }}
                            </p>
                            <button @click="logout" :disabled="isLoggingOut"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                                <span v-if="isLoggingOut">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> Logging out...
                                </span>
                                <span v-else>
                                    Log Out
                                </span>
                            </button>
                        </template>
                        <template v-else>
                            <Link href="/login"
                                class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-md text-sm font-medium">
                            Sign In
                            </Link>
                            <Link href="/register"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Get Started
                            </Link>
                        </template>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button
                        class="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                        @click="toggleMobileMenu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200 dark:border-gray-700">
                    <Link href="/"
                        :class="currentUrl === '/' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300'"
                        class="block px-3 py-2 rounded-md text-base font-medium">Home</Link>
                    <Link href="/courses/list"
                        :class="currentUrl.startsWith('/courses') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300'"
                        class="block px-3 py-2 rounded-md text-base font-medium">Courses</Link>
                    <Link href="/blogs/list"
                        :class="currentUrl.startsWith('/blog') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300'"
                        class="block px-3 py-2 rounded-md text-base font-medium">Blog</Link>
                    <Link href="/contact-us"
                        :class="currentUrl.startsWith('/contact') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300'"
                        class="block px-3 py-2 rounded-md text-base font-medium">Contact</Link>

                    <!-- Mobile Language Switcher -->
                    <div class="pt-2">
                        <p class="text-gray-500 dark:text-gray-400 text-sm px-3 py-1">Language</p>
                        <div class="space-y-1">
                            <button v-for="locale in supportedLocales" :key="locale.code"
                                @click="switchLanguage(locale.code)" :class="[
                                    locale.code === currentLocale ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300',
                                    'w-full text-left px-3 py-2 text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2'
                                ]">
                                <span>{{ getFlagEmoji(locale.code) }}</span>
                                <span>{{ locale.native }}</span>
                                <i v-if="locale.code === currentLocale"
                                    class="fas fa-check text-blue-600 dark:text-blue-400 ml-auto"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Auth -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <template v-if="$page.props.auth?.user">
                            <Link href="/dashboard"
                                class="bg-blue-600 hover:bg-blue-700 text-white block px-3 py-2 rounded-md text-base font-medium text-center">
                            Dashboard</Link>
                        </template>
                        <template v-else>
                            <Link href="/login"
                                class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 block px-3 py-2 rounded-md text-base font-medium">
                            Sign In</Link>
                            <Link href="/register"
                                class="bg-blue-600 hover:bg-blue-700 text-white block px-3 py-2 rounded-md text-base font-medium text-center mt-2">
                            Get Started</Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>