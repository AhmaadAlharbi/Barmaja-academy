<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import { ref } from 'vue';

// Props that would come from your Laravel backend
defineProps<{
    auth?: {
        user?: any;
    };
}>();

// Form data
const form = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const isSubmitting = ref(false);

// Methods
const submitForm = async () => {
    isSubmitting.value = true;

    // Handle form submission here
    console.log('Form submitted:', form.value);

    // Simulate API call
    setTimeout(() => {
        isSubmitting.value = false;
        // Reset form
        form.value = {
            name: '',
            email: '',
            subject: '',
            message: ''
        };
        // Show success message (you can add a toast notification here)
        alert('Message sent successfully!');
    }, 1000);
};
</script>

<template>

    <Head title="Contact Us - Barmaja Academy">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <Navbar />

        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 py-20 lg:py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-8">
                    <Link href="/" class="hover:text-blue-600 dark:hover:text-blue-400">Home</Link>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-900 dark:text-white">Contact</span>
                </nav>

                <div class="text-center">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        Get in
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                            Touch
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                        Have questions about our courses? Need support? We're here to help you on your learning journey.
                    </p>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Let's Start a Conversation
                        </h2>

                        <div class="space-y-8">
                            <!-- Contact Item -->
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Visit Us</h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        123 Learning Street<br>
                                        Tech District, Kuwait City<br>
                                        Kuwait 12345
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Item -->
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Call Us</h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        +965 1234 5678<br>
                                        Available 24/7
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Item -->
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Email Us</h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        support@barmajaacademy.com<br>
                                        info@barmajaacademy.com
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Item -->
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Office Hours
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Sunday - Thursday: 9:00 AM - 6:00 PM<br>
                                        Friday - Saturday: 10:00 AM - 4:00 PM
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="mt-12">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-blue-400 hover:bg-blue-500 text-white rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-blue-700 hover:bg-blue-800 text-white rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-pink-600 hover:bg-pink-700 text-white rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Send us a Message</h2>

                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Your Name
                                </label>
                                <input type="text" id="name" v-model="form.name" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your full name">
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <input type="email" id="email" v-model="form.email" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your email address">
                            </div>

                            <!-- Subject Field -->
                            <div>
                                <label for="subject"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Subject
                                </label>
                                <select id="subject" v-model="form.subject" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="course">Course Information</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="billing">Billing & Payment</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Message Field -->
                            <div>
                                <label for="message"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Message
                                </label>
                                <textarea id="message" v-model="form.message" required rows="5"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                                    placeholder="Tell us how we can help you..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" :disabled="isSubmitting"
                                :class="isSubmitting ? 'opacity-50 cursor-not-allowed' : 'hover:from-blue-700 hover:to-purple-700 transform hover:scale-105'"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-lg text-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                                <span v-if="!isSubmitting">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Send Message
                                </span>
                                <span v-else>
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Sending...
                                </span>
                            </button>
                        </form>

                        <!-- Additional Info -->
                        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mt-1"></i>
                                <div>
                                    <p class="text-sm text-blue-800 dark:text-blue-300">
                                        <strong>Quick Response:</strong> We typically respond to all inquiries within 24
                                        hours during business days.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-20 bg-white dark:bg-gray-800">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Find quick answers to common questions
                    </p>
                </div>

                <div class="space-y-4">
                    <!-- FAQ Item -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            How do I enroll in a course?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Simply browse our course catalog, select the course you're interested in, and click "Enroll
                            Now". You'll be guided through the payment process and gain immediate access.
                        </p>
                    </div>

                    <!-- FAQ Item -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Do you offer certificates upon completion?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Yes! All our courses come with certificates of completion that you can add to your LinkedIn
                            profile and resume.
                        </p>
                    </div>

                    <!-- FAQ Item -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            What is your refund policy?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            We offer a 30-day money-back guarantee on all courses. If you're not satisfied, contact us
                            for a full refund.
                        </p>
                    </div>

                    <!-- FAQ Item -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Can I access courses on mobile devices?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Absolutely! Our platform is fully responsive and optimized for learning on any device -
                            desktop, tablet, or mobile.
                        </p>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <p class="text-gray-600 dark:text-gray-300">
                        Still have questions?
                        <a href="#"
                            class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Contact our support team
                        </a>
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold">Barmaja Academy</h3>
                        </div>
                        <p class="text-gray-400 mb-6">
                            Empowering aspiring programmers with comprehensive courses and hands-on projects to build
                            successful careers in technology.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Quick Links</h4>
                        <ul class="space-y-3">
                            <li>
                                <Link href="/" class="text-gray-400 hover:text-white transition-colors">Home</Link>
                            </li>
                            <li>
                                <Link href="/courses" class="text-gray-400 hover:text-white transition-colors">Courses
                                </Link>
                            </li>
                            <li>
                                <Link href="/blog" class="text-gray-400 hover:text-white transition-colors">Blog</Link>
                            </li>
                            <li>
                                <Link href="/about" class="text-gray-400 hover:text-white transition-colors">About Us
                                </Link>
                            </li>
                            <li>
                                <Link href="/contact" class="text-gray-400 hover:text-white transition-colors">Contact
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Categories</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Web Development</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mobile
                                    Development</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Backend
                                    Development</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Frontend
                                    Frameworks</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Database Design</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Support</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Help Center</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of
                                    Service</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Refund Policy</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Student Support</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 mt-12">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm">
                            © 2024 Barmaja Academy. All rights reserved.
                        </p>
                        <div class="flex items-center space-x-6 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookies</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Custom animations for interactive elements */
.transform {
    transition: transform 0.2s ease-in-out;
}
</style>