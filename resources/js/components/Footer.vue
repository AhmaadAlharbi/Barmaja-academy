<template>
    <div>
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

<script setup lang="ts">

</script>

<style lang="scss" scoped></style>