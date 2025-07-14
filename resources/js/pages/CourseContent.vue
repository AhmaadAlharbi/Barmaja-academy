<script setup lang="ts">
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref, computed } from 'vue';

// Comment interface
interface Comment {
    id: number;
    user_id: number;
    course_content_id: number;
    comment: string;
    created_at: string;
    updated_at: string;
    user?: {
        name: string;
        avatar?: string;
    };
}

// Props from Laravel backend
const props = defineProps<{
    auth?: {
        user?: any;
    };
    content: {
        id: number;
        course_id: number;
        title_ar: string;
        title_en: string;
        content_ar: string;
        content_en: string;
        video_url: string | null;
        sort_order: number;
        is_active: number;
        created_at: string;
        updated_at: string;
        comments?: Comment[];
    };
    course?: {
        id: number;
        title_en: string;
        title_ar: string;
        description_en: string;
        slug: string;
    };
    allLessons?: Array<{
        id: number;
        title_en: string;
        sort_order: number;
        is_active: number;
        video_url: string | null;
    }>;
    progress?: {
        completed_lessons: number;
        total_lessons: number;
        percentage: number;
    };
}>();


const showComments = ref(true);

// Comment form
const commentForm = useForm({
    comment: '',
    course_content_id: props.content.id,
});

const commentsCount = computed(() => {
    return props.content.comments?.length || 0;
});

const sortedComments = computed(() => {
    if (!props.content.comments) return [];
    return [...props.content.comments].sort((a, b) =>
        new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
    );
});



const getVideoEmbedUrl = (url: string) => {
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        const videoId = url.split('v=')[1] || url.split('/').pop();
        return `https://www.youtube.com/embed/${videoId}`;
    }
    if (url.includes('vimeo.com')) {
        const videoId = url.split('/').pop();
        return `https://player.vimeo.com/video/${videoId}`;
    }
    return url;
};

// Comment methods
const submitComment = () => {
    if (!props.auth?.user) {
        alert('Please login to add comments');
        return;
    }

    commentForm.post('/course-content/comment', {
        onSuccess: () => {
            commentForm.reset();
            // Page will refresh with new comments
        },
        onError: (errors) => {
            console.error('Error submitting comment:', errors);
        }
    });
};

// Delete comment method with confirmation
const deleteComment = (commentId: number) => {
    // Show confirmation dialog
    const confirmed = confirm('Are you sure you want to delete this comment? This action cannot be undone.');

    if (confirmed) {
        router.delete(`/course-content/comment/${commentId}`, {
            onSuccess: () => {
                // Page will refresh and comment will be removed
                console.log('Comment deleted successfully');
            },
            onError: (errors) => {
                console.error('Error deleting comment:', errors);
                alert('Failed to delete comment. Please try again.');
            },
            onFinish: () => {
                // Optional: Handle any cleanup after the request finishes
            }
        });
    }
};

const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getInitials = (name: string) => {
    return name.split(' ').map(n => n[0]).join('').toUpperCase();
};
</script>

<template>

    <Head :title="`${content.title_en} - ${course?.title_en || 'Course'} - Barmaja Academy`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <Navbar />

        <!-- Course Progress Bar -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-16 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                        <Link href="/" class="hover:text-blue-600 dark:hover:text-blue-400">Home</Link>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <Link href="/courses" class="hover:text-blue-600 dark:hover:text-blue-400">Courses</Link>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <Link :href="`/course/${course?.id}`" class="hover:text-blue-600 dark:hover:text-blue-400">
                        {{ course?.title_en }}
                        </Link>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-gray-900 dark:text-white">{{ content.title_en }}</span>
                    </nav>


                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Video Player -->
                    <div v-if="content.video_url"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                        <div class="aspect-video">
                            <iframe :src="getVideoEmbedUrl(content.video_url)" class="w-full h-full" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- Lesson Content -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <!-- Lesson Header -->
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <span
                                        class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium rounded-full">
                                        Lesson {{ content.sort_order }}
                                    </span>
                                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span>15 min</span>
                                    </div>
                                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        <span>1,234 views</span>
                                    </div>
                                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                        <i class="fas fa-comments mr-1"></i>
                                        <span>{{ commentsCount }} comments</span>
                                    </div>
                                </div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                    {{ content.title_en }}
                                </h1>
                            </div>


                        </div>

                        <!-- Lesson Content -->
                        <div class="prose dark:prose-invert max-w-none mb-8">
                            <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ content.content_en }}
                            </div>
                        </div>




                    </div>

                    <!-- Comments Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <!-- Comments Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Comments ({{ commentsCount }})
                            </h3>
                            <button @click="showComments = !showComments"
                                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                <i :class="showComments ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                            </button>
                        </div>

                        <div v-if="showComments">
                            <!-- Add Comment Form -->
                            <div v-if="auth?.user" class="mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Add a Comment</h4>

                                <form @submit.prevent="submitComment">
                                    <div class="mb-4">
                                        <textarea v-model="commentForm.comment" rows="4"
                                            placeholder="Share your thoughts about this lesson..."
                                            class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                                            :class="{
                                                'border-red-500 focus:ring-red-500': commentForm.errors.comment,
                                                'border-gray-300 dark:border-gray-600': !commentForm.errors.comment
                                            }"></textarea>

                                        <!-- Error Message -->
                                        <div v-if="commentForm.errors.comment"
                                            class="mt-2 text-red-600 dark:text-red-400 text-sm">
                                            {{ commentForm.errors.comment }}
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit"
                                            :disabled="commentForm.processing || !commentForm.comment.trim()"
                                            class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg font-semibold transition-colors flex items-center">
                                            <i v-if="commentForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                            <i v-else class="fas fa-comment mr-2"></i>
                                            {{ commentForm.processing ? 'Posting...' : 'Post Comment' }}
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Login prompt for guests -->
                            <div v-else
                                class="mb-8 p-6 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mr-3"></i>
                                    <div>
                                        <p class="text-blue-800 dark:text-blue-200">
                                            Please
                                            <Link href="/login" class="font-semibold underline hover:no-underline">login
                                            </Link>
                                            to add comments and join the discussion.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments List -->
                            <div v-if="commentsCount > 0" class="space-y-6">
                                <div v-for="comment in sortedComments" :key="comment.id"
                                    class="flex space-x-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0">
                                        <div v-if="comment.user?.avatar" class="w-10 h-10 rounded-full overflow-hidden">
                                            <img :src="comment.user.avatar" :alt="comment.user?.name || 'User'"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div v-else
                                            class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ getInitials(comment.user?.name || 'Anonymous User') }}
                                        </div>
                                    </div>

                                    <!-- Comment Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <h5 class="font-semibold text-gray-900 dark:text-white">
                                                {{ comment.user?.name || 'Anonymous User' }}
                                            </h5>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ formatDate(comment.created_at) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ comment.comment }}
                                        </p>

                                        <!-- Comment Actions -->
                                        <div class="flex items-center space-x-4 mt-3">

                                            <button
                                                v-if="auth?.user?.id === comment.user_id || auth?.user?.role === 'admin'"
                                                @click="deleteComment(comment.id)"
                                                class="text-gray-500 hover:text-red-600 dark:hover:text-red-400 text-sm transition-colors">
                                                <i class="fas fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- No Comments State -->
                            <div v-else class="text-center py-12">
                                <i class="fas fa-comments text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">No comments yet
                                </h4>
                                <p class="text-gray-500 dark:text-gray-500">Be the first to share your thoughts about
                                    this lesson!</p>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Course Playlist -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-32">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Content</h3>

                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            <div v-for="lesson in allLessons" :key="lesson.id"
                                :class="lesson.id === content.id ? 'bg-blue-50 dark:bg-blue-900/30 border-blue-200 dark:border-blue-700' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                class="border rounded-lg p-3 transition-colors cursor-pointer">
                                <Link :href="`/course-content/${lesson.id}`" class="block">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-sm font-medium">
                                            {{ lesson.sort_order }}
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-white text-sm line-clamp-2">
                                                {{ lesson.title_en }}
                                            </h4>
                                            <div
                                                class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <i v-if="lesson.video_url" class="fas fa-play mr-1"></i>
                                                <span>15 min</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="lesson.id === content.id" class="text-blue-600 dark:text-blue-400">
                                        <i class="fas fa-play text-sm"></i>
                                    </div>
                                </div>
                                </Link>
                            </div>
                        </div>

                        <!-- Course Actions -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
                            <Link :href="`/course/${course?.id}`"
                                class="w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-lg font-medium transition-colors text-center block">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Course
                            </Link>
                            <button
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                                <i class="fas fa-download mr-2"></i>
                                Download Resources
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    max-width: none;
}

/* Custom scrollbar for playlist */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.5);
    border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.7);
}
</style>