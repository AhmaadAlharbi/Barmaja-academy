<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const currentUrl = page.url;

defineProps<{
    auth?: {
        user?: any;
    };
}>();

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
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

                    <Link href="/blog" :class="[
                        currentUrl.startsWith('/blog') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-300',
                        'hover:text-blue-700 dark:hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium transition-colors'
                    ]">Blog</Link>

                    <Link href="/about" :class="[
                        currentUrl.startsWith('/about') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-300',
                        'hover:text-blue-700 dark:hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium transition-colors'
                    ]">About</Link>

                    <Link href="/contact" :class="[
                        currentUrl.startsWith('/contact') ? 'text-blue-600 dark:text-blue-400 font-semibold' : 'text-gray-600 dark:text-gray-300',
                        'hover:text-blue-700 dark:hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium transition-colors'
                    ]">Contact</Link>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <select
                        class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 focus:outline-none">
                        <option value="en">🇺🇸 English</option>
                        <option value="ar">🇸🇦 العربية</option>
                    </select>

                    <!-- Theme Switcher -->
                    <button
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <i class="fas fa-sun dark:hidden"></i>
                        <i class="fas fa-moon hidden dark:inline"></i>
                    </button>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-2">
                        <template v-if="$page.props.auth?.user">
                            <Link href="/dashboard"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Dashboard
                            </Link>
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
                    <Link href="/blog"
                        :class="currentUrl.startsWith('/blog') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300'"
                        class="block px-3 py-2 rounded-md text-base font-medium">Blog</Link>
                    <Link href="/about"
                        :class="currentUrl.startsWith('/about') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300'"
                        class="block px-3 py-2 rounded-md text-base font-medium">About</Link>
                    <Link href="/contact"
                        :class="currentUrl.startsWith('/contact') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300'"
                        class="block px-3 py-2 rounded-md text-base font-medium">Contact</Link>

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
