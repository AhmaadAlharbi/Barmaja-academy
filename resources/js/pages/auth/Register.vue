<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { computed, ref, onMounted } from 'vue';

const page = usePage();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

// Get current locale from global props
const currentLocale = computed(() => page.props.locale?.current || 'en');
const isRTL = computed(() => currentLocale.value === 'ar');
const supportedLocales = computed(() => page.props.locale?.supported || []);

// Get translations from props with fallbacks
const translations = computed(() => page.props.translations?.auth || {});

// Comprehensive fallback translations
const fallbackTranslations = {
    register: {
        title: isRTL.value ? 'إنشاء حسابك' : 'Create your account',
        description: isRTL.value ? 'أدخل بياناتك أدناه لإنشاء حسابك' : 'Enter your details below to create your account',
        welcome: isRTL.value ? 'مرحباً بك في أكاديمية برمجة' : 'Welcome to Barmaja Academy',
        subtitle: isRTL.value ? 'ابدأ رحلة البرمجة اليوم' : 'Start your programming journey today',
        name: isRTL.value ? 'الاسم الكامل' : 'Full name',
        email: isRTL.value ? 'عنوان البريد الإلكتروني' : 'Email address',
        password: isRTL.value ? 'كلمة المرور' : 'Password',
        password_confirmation: isRTL.value ? 'تأكيد كلمة المرور' : 'Confirm password',
        register_button: isRTL.value ? 'إنشاء حساب' : 'Create account',
        have_account: isRTL.value ? 'لديك حساب بالفعل؟' : 'Already have an account?',
        sign_in: isRTL.value ? 'تسجيل الدخول' : 'Sign in',
        or_continue: isRTL.value ? 'أو تابع مع' : 'Or continue with',
        terms_agreement: isRTL.value ? 'بإنشاء حساب، فإنك توافق على' : 'By creating an account, you agree to our',
        terms_of_service: isRTL.value ? 'شروط الخدمة' : 'Terms of Service',
        and: isRTL.value ? 'و' : 'and',
        privacy_policy: isRTL.value ? 'سياسة الخصوصية' : 'Privacy Policy',
        placeholders: {
            name: isRTL.value ? 'اسمك الكامل' : 'Your full name',
            email: isRTL.value ? 'البريد@مثال.com' : 'email@example.com',
            password: isRTL.value ? 'كلمة المرور' : 'Password',
            password_confirmation: isRTL.value ? 'تأكيد كلمة المرور' : 'Confirm your password'
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

// Animation states
const formVisible = ref(false);

onMounted(() => {
    setTimeout(() => formVisible.value = true, 100);
});

// Language toggle function for mcamara/laravel-localization
const toggleLanguage = () => {
    const targetLocale = currentLocale.value === 'ar' ? 'en' : 'ar';

    // Find the target locale URL from supported locales
    const targetLocaleData = supportedLocales.value.find(locale => locale.code === targetLocale);

    if (targetLocaleData && targetLocaleData.url) {
        window.location.href = targetLocaleData.url;
    }
};

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head :title="getTranslation('register.title')">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <meta name="description" :content="getTranslation('register.description')" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 transition-all duration-500"
        :dir="isRTL ? 'rtl' : 'ltr'" :class="{ 'font-tajawal': isRTL }">

        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 w-80 h-80 bg-blue-500/10 dark:bg-blue-400/5 rounded-full blur-3xl"
                :class="isRTL ? '-left-40' : '-right-40'"></div>
            <div class="absolute -bottom-40 w-80 h-80 bg-purple-500/10 dark:bg-purple-400/5 rounded-full blur-3xl"
                :class="isRTL ? '-right-40' : '-left-40'"></div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-blue-500/5 to-purple-500/5 rounded-full blur-3xl">
            </div>
        </div>

        <!-- Language Toggle -->
        <div class="absolute top-6 z-10" :class="isRTL ? 'left-6' : 'right-6'">
            <button @click="toggleLanguage"
                class="flex items-center space-x-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-full px-4 py-2 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 dark:border-gray-700/20"
                :class="{ 'space-x-reverse': isRTL }">
                <i class="fas fa-globe text-blue-600 dark:text-blue-400"></i>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ isRTL ? 'English' : 'العربية' }}
                </span>
            </button>
        </div>

        <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-md w-full">
                <Transition appear enter-active-class="transition duration-1000 ease-out"
                    enter-from-class="transform translate-y-8 opacity-0"
                    enter-to-class="transform translate-y-0 opacity-100">
                    <div v-if="formVisible"
                        class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/20 overflow-hidden">

                        <!-- Header -->
                        <div
                            class="relative bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 px-8 py-12 text-center">
                            <div class="absolute inset-0 bg-black/10"></div>
                            <div class="relative">
                                <!-- Logo -->
                                <div
                                    class="w-20 h-20 mx-auto mb-6 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center shadow-xl">
                                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                                </div>

                                <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                                    {{ getTranslation('register.welcome') }}
                                </h1>
                                <p class="text-blue-100 text-lg leading-relaxed">
                                    {{ getTranslation('register.subtitle') }}
                                </p>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="px-8 py-12">
                            <form @submit.prevent="submit" class="space-y-6">
                                <!-- Name Field -->
                                <div class="space-y-3">
                                    <Label for="name" class="text-gray-700 dark:text-gray-300 font-semibold"
                                        :class="{ 'text-right block': isRTL }">
                                        {{ getTranslation('register.name') }}
                                    </Label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 flex items-center pointer-events-none"
                                            :class="isRTL ? 'right-0 pr-4' : 'left-0 pl-4'">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <Input id="name" type="text" required autofocus :tabindex="1"
                                            autocomplete="name" v-model="form.name"
                                            :placeholder="getTranslation('register.placeholders.name')"
                                            class="h-14 rounded-2xl border-gray-200 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 bg-gray-50 dark:bg-gray-900/50 transition-all duration-300"
                                            :class="isRTL ? 'pr-12 text-right' : 'pl-12'" />
                                    </div>
                                    <InputError :message="form.errors.name" />
                                </div>

                                <!-- Email Field -->
                                <div class="space-y-3">
                                    <Label for="email" class="text-gray-700 dark:text-gray-300 font-semibold"
                                        :class="{ 'text-right block': isRTL }">
                                        {{ getTranslation('register.email') }}
                                    </Label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 flex items-center pointer-events-none"
                                            :class="isRTL ? 'right-0 pr-4' : 'left-0 pl-4'">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <Input id="email" type="email" required :tabindex="2" autocomplete="email"
                                            v-model="form.email"
                                            :placeholder="getTranslation('register.placeholders.email')"
                                            class="h-14 rounded-2xl border-gray-200 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 bg-gray-50 dark:bg-gray-900/50 transition-all duration-300"
                                            :class="isRTL ? 'pr-12 text-right' : 'pl-12'" />
                                    </div>
                                    <InputError :message="form.errors.email" />
                                </div>

                                <!-- Password Field -->
                                <div class="space-y-3">
                                    <Label for="password" class="text-gray-700 dark:text-gray-300 font-semibold"
                                        :class="{ 'text-right block': isRTL }">
                                        {{ getTranslation('register.password') }}
                                    </Label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 flex items-center pointer-events-none"
                                            :class="isRTL ? 'right-0 pr-4' : 'left-0 pl-4'">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <Input id="password" type="password" required :tabindex="3"
                                            autocomplete="new-password" v-model="form.password"
                                            :placeholder="getTranslation('register.placeholders.password')"
                                            class="h-14 rounded-2xl border-gray-200 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 bg-gray-50 dark:bg-gray-900/50 transition-all duration-300"
                                            :class="isRTL ? 'pr-12 text-right' : 'pl-12'" />
                                    </div>
                                    <InputError :message="form.errors.password" />
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="space-y-3">
                                    <Label for="password_confirmation"
                                        class="text-gray-700 dark:text-gray-300 font-semibold"
                                        :class="{ 'text-right block': isRTL }">
                                        {{ getTranslation('register.password_confirmation') }}
                                    </Label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 flex items-center pointer-events-none"
                                            :class="isRTL ? 'right-0 pr-4' : 'left-0 pl-4'">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <Input id="password_confirmation" type="password" required :tabindex="4"
                                            autocomplete="new-password" v-model="form.password_confirmation"
                                            :placeholder="getTranslation('register.placeholders.password_confirmation')"
                                            class="h-14 rounded-2xl border-gray-200 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 bg-gray-50 dark:bg-gray-900/50 transition-all duration-300"
                                            :class="isRTL ? 'pr-12 text-right' : 'pl-12'" />
                                    </div>
                                    <InputError :message="form.errors.password_confirmation" />
                                </div>



                                <!-- Submit Button -->
                                <Button type="submit"
                                    class="w-full h-14 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-2xl text-lg font-semibold shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                    :tabindex="5" :disabled="form.processing">
                                    <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin"
                                        :class="isRTL ? 'ml-3' : 'mr-3'" />
                                    <i v-else class="fas fa-user-plus" :class="isRTL ? 'ml-3' : 'mr-3'"></i>
                                    {{ getTranslation('register.register_button') }}
                                </Button>

                                <!-- Divider -->
                                <div class="relative my-8">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span
                                            class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-medium">
                                            {{ getTranslation('register.or_continue') }}
                                        </span>
                                    </div>
                                </div>


                            </form>

                            <!-- Sign In Link -->
                            <div class="mt-8 text-center">
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ getTranslation('register.have_account') }}
                                    <TextLink :href="route('login')"
                                        class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                        :tabindex="6">
                                        {{ getTranslation('register.sign_in') }}
                                    </TextLink>
                                </p>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>

        <!-- Background Decorative Elements -->
        <div
            class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-blue-50/50 to-transparent dark:from-gray-900/50 pointer-events-none">
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap');

.font-tajawal {
    font-family: 'Tajawal', sans-serif;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
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

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Enhanced focus styles */
.focus\:ring-blue-500:focus {
    --tw-ring-opacity: 1;
    --tw-ring-color: rgb(59 130 246 / var(--tw-ring-opacity));
}

/* RTL specific styles */
[dir="rtl"] input::placeholder {
    text-align: right;
}

/* Custom backdrop blur for better browser support */
.backdrop-blur-xl {
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
}

.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
</style>