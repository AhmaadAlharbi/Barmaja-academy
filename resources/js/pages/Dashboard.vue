<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import {
    BookOpen,
    Users,
    FileText,
    MessageSquare,
    GraduationCap,
    ShoppingCart,
    BookOpenCheck,
    UsersRound
} from 'lucide-vue-next';

interface DashboardStats {
    total_courses: number;
    published_courses: number;
    total_users: number;
    total_students: number;
    total_blog_posts: number;
    published_blog_posts: number;
    total_lessons: number;
    total_comments: number;
    course_enrollments: number;
}

const props = defineProps<{
    stats: DashboardStats;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Main Statistics Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                <!-- Total Courses -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Courses</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ stats.total_courses }}</h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <BookOpen class="h-7 w-7 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                </div>

                <!-- Published Courses -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Published Courses</p>
                            <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">{{ stats.published_courses
                                }}</h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <BookOpenCheck class="h-7 w-7 text-green-600 dark:text-green-400" />
                        </div>
                    </div>
                </div>

                <!-- Course Enrollments -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Course Enrollments</p>
                            <h3 class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{
                                stats.course_enrollments }}</h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <ShoppingCart class="h-7 w-7 text-purple-600 dark:text-purple-400" />
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Students</p>
                            <h3 class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ stats.total_students
                                }}</h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                            <GraduationCap class="h-7 w-7 text-orange-600 dark:text-orange-400" />
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Users</p>
                            <h3 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ stats.total_users }}
                            </h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <UsersRound class="h-7 w-7 text-indigo-600 dark:text-indigo-400" />
                        </div>
                    </div>
                </div>

                <!-- Total Blog Posts -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Blog Posts</p>
                            <h3 class="text-3xl font-bold text-teal-600 dark:text-teal-400">{{ stats.total_blog_posts }}
                            </h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                            <FileText class="h-7 w-7 text-teal-600 dark:text-teal-400" />
                        </div>
                    </div>
                </div>

                <!-- Published Blog Posts -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Published Blog Posts</p>
                            <h3 class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{
                                stats.published_blog_posts }}</h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                            <FileText class="h-7 w-7 text-emerald-600 dark:text-emerald-400" />
                        </div>
                    </div>
                </div>

                <!-- Total Lessons -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Lessons</p>
                            <h3 class="text-3xl font-bold text-cyan-600 dark:text-cyan-400">{{ stats.total_lessons }}
                            </h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center">
                            <BookOpen class="h-7 w-7 text-cyan-600 dark:text-cyan-400" />
                        </div>
                    </div>
                </div>

                <!-- Total Comments -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Comments</p>
                            <h3 class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ stats.total_comments }}
                            </h3>
                        </div>
                        <div
                            class="h-14 w-14 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                            <MessageSquare class="h-7 w-7 text-pink-600 dark:text-pink-400" />
                        </div>
                    </div>
                </div>

            </div>

            <!-- Simple Welcome Message -->
            <div
                class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Welcome to Your Dashboard</h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Here you can easily monitor your learning platform statistics
                </p>
            </div>
        </div>
    </AppLayout>
</template>