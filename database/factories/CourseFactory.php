<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programmingCourses = [
            [
                'title_en' => 'Complete Web Development Bootcamp',
                'title_ar' => 'دورة تطوير الويب الشاملة',
                'description_en' => 'Learn HTML, CSS, JavaScript, React, Node.js, and MongoDB. Build 10+ real-world projects and become a full-stack developer.',
                'description_ar' => 'تعلم HTML و CSS و JavaScript و React و Node.js و MongoDB. ابني أكثر من 10 مشاريع حقيقية وكن مطور ويب متكامل.',
            ],
            [
                'title_en' => 'Python Programming Masterclass',
                'title_ar' => 'دورة احترافية في برمجة بايثون',
                'description_en' => 'Master Python programming from basics to advanced concepts. Learn data structures, algorithms, web scraping, and machine learning.',
                'description_ar' => 'احترف برمجة بايثون من الأساسيات إلى المفاهيم المتقدمة. تعلم هياكل البيانات والخوارزميات واستخراج البيانات والتعلم الآلي.',
            ],
            [
                'title_en' => 'React Native Mobile App Development',
                'title_ar' => 'تطوير تطبيقات الجوال باستخدام React Native',
                'description_en' => 'Build cross-platform mobile apps for iOS and Android using React Native. Learn navigation, state management, and API integration.',
                'description_ar' => 'ابني تطبيقات جوال متعددة المنصات لنظامي iOS و Android باستخدام React Native. تعلم التنقل وإدارة الحالة وتكامل APIs.',
            ],
            [
                'title_en' => 'Laravel PHP Framework Course',
                'title_ar' => 'دورة إطار عمل Laravel PHP',
                'description_en' => 'Learn Laravel from scratch. Master MVC architecture, Eloquent ORM, authentication, testing, and deployment.',
                'description_ar' => 'تعلم Laravel من الصفر. احترف معمارية MVC و Eloquent ORM والمصادقة والاختبار والنشر.',
            ],
            [
                'title_en' => 'Data Science with Python',
                'title_ar' => 'علم البيانات باستخدام بايثون',
                'description_en' => 'Learn data analysis, visualization, and machine learning with Python. Master pandas, NumPy, matplotlib, and scikit-learn.',
                'description_ar' => 'تعلم تحليل البيانات والتصور والتعلم الآلي باستخدام بايثون. احترف pandas و NumPy و matplotlib و scikit-learn.',
            ],
            [
                'title_en' => 'JavaScript ES6+ Modern Development',
                'title_ar' => 'تطوير JavaScript الحديث ES6+',
                'description_en' => 'Master modern JavaScript features including arrow functions, promises, async/await, modules, and advanced DOM manipulation.',
                'description_ar' => 'احترف ميزات JavaScript الحديثة بما في ذلك arrow functions و promises و async/await والوحدات ومعالجة DOM المتقدمة.',
            ],
            [
                'title_en' => 'Docker and Kubernetes DevOps',
                'title_ar' => 'Docker و Kubernetes للـ DevOps',
                'description_en' => 'Learn containerization with Docker and orchestration with Kubernetes. Master CI/CD pipelines and cloud deployment.',
                'description_ar' => 'تعلم الحاويات باستخدام Docker والتنسيق باستخدام Kubernetes. احترف خطوط CI/CD والنشر السحابي.',
            ],
            [
                'title_en' => 'Vue.js Complete Guide',
                'title_ar' => 'الدليل الشامل لـ Vue.js',
                'description_en' => 'Build modern web applications with Vue.js. Learn components, Vuex state management, Vue Router, and testing.',
                'description_ar' => 'ابني تطبيقات ويب حديثة باستخدام Vue.js. تعلم المكونات وإدارة الحالة Vuex و Vue Router والاختبار.',
            ],
            [
                'title_en' => 'Flutter Mobile Development',
                'title_ar' => 'تطوير تطبيقات الجوال باستخدام Flutter',
                'description_en' => 'Create beautiful mobile apps for iOS and Android using Flutter and Dart. Learn widgets, state management, and Firebase integration.',
                'description_ar' => 'أنشئ تطبيقات جوال جميلة لنظامي iOS و Android باستخدام Flutter و Dart. تعلم الويدجت وإدارة الحالة وتكامل Firebase.',
            ],
            [
                'title_en' => 'Node.js Backend Development',
                'title_ar' => 'تطوير الخادم باستخدام Node.js',
                'description_en' => 'Build scalable backend applications with Node.js, Express.js, and MongoDB. Learn REST APIs, authentication, and microservices.',
                'description_ar' => 'ابني تطبيقات خادم قابلة للتوسع باستخدام Node.js و Express.js و MongoDB. تعلم REST APIs والمصادقة والخدمات المصغرة.',
            ],
            [
                'title_en' => 'Angular Complete Course',
                'title_ar' => 'الدورة الشاملة لـ Angular',
                'description_en' => 'Master Angular framework for building enterprise-level applications. Learn TypeScript, RxJS, and advanced Angular concepts.',
                'description_ar' => 'احترف إطار عمل Angular لبناء تطبيقات على مستوى المؤسسات. تعلم TypeScript و RxJS ومفاهيم Angular المتقدمة.',
            ],
            [
                'title_en' => 'Machine Learning with TensorFlow',
                'title_ar' => 'التعلم الآلي باستخدام TensorFlow',
                'description_en' => 'Learn deep learning and neural networks with TensorFlow. Build image recognition, NLP, and recommendation systems.',
                'description_ar' => 'تعلم التعلم العميق والشبكات العصبية باستخدام TensorFlow. ابني أنظمة التعرف على الصور ومعالجة اللغات الطبيعية والتوصيات.',
            ],
        ];

        $course = $this->faker->randomElement($programmingCourses);
        $slug = Str::slug($course['title_en']) . '-' . $this->faker->unique()->numberBetween(1, 1000);

        $videoUrls = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://vimeo.com/123456789',
            'https://www.youtube.com/watch?v=ScMzIvxBSi4',
            'https://vimeo.com/987654321',
            'https://www.youtube.com/watch?v=jNQXAC9IVRw',
        ];

        return [
            'title_ar' => $course['title_ar'],
            'title_en' => $course['title_en'],
            'slug' => $slug,
            'description_ar' => $course['description_ar'],
            'description_en' => $course['description_en'],
            'price' => $this->faker->randomFloat(2, 29.99, 299.99),
            'preview_video_url' => $this->faker->optional(0.8)->randomElement($videoUrls),
            'is_published' => $this->faker->boolean(70), // 70% chance of being published
        ];
    }

    /**
     * Indicate that the course is published.
     */
    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the course is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
        ]);
    }

    /**
     * Indicate that the course is free.
     */
    public function free(): static
    {
        return $this->state(fn(array $attributes) => [
            'price' => 0.00,
        ]);
    }

    /**
     * Indicate that the course is premium (high price).
     */
    public function premium(): static
    {
        return $this->state(fn(array $attributes) => [
            'price' => $this->faker->randomFloat(2, 199.99, 499.99),
        ]);
    }
}
