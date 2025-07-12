<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseContent>
 */
class CourseContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programmingLessons = [
            // Web Development Lessons
            [
                'title_en' => 'Introduction to HTML5 Structure',
                'title_ar' => 'مقدمة في هيكل HTML5',
                'content_en' => 'HTML5 is the latest version of HyperText Markup Language, the standard markup language for creating web pages. In this lesson, we\'ll explore the basic structure of an HTML5 document, including the DOCTYPE declaration, html, head, and body elements. You\'ll learn about semantic elements like header, nav, main, section, article, aside, and footer that provide meaning to your content structure. We\'ll also cover the importance of proper document structure for accessibility and SEO. By the end of this lesson, you\'ll be able to create a well-structured HTML5 page with proper semantic markup.',
                'content_ar' => 'HTML5 هو أحدث إصدار من لغة ترميز النص التشعبي، وهي اللغة المعيارية لإنشاء صفحات الويب. في هذا الدرس، سنستكشف الهيكل الأساسي لوثيقة HTML5، بما في ذلك إعلان DOCTYPE وعناصر html و head و body. ستتعلم عن العناصر الدلالية مثل header و nav و main و section و article و aside و footer التي تضفي معنى على هيكل المحتوى الخاص بك. سنغطي أيضاً أهمية الهيكل المناسب للوثيقة لسهولة الوصول وتحسين محركات البحث. بنهاية هذا الدرس، ستكون قادراً على إنشاء صفحة HTML5 جيدة التنظيم مع ترميز دلالي مناسب.',
            ],
            [
                'title_en' => 'CSS Grid Layout Fundamentals',
                'title_ar' => 'أساسيات تخطيط CSS Grid',
                'content_en' => 'CSS Grid Layout is a two-dimensional layout system that allows you to create complex responsive designs with ease. This lesson covers the fundamental concepts of Grid, including grid containers, grid items, grid lines, and grid tracks. You\'ll learn how to define a grid using display: grid, set up columns and rows with grid-template-columns and grid-template-rows, and position items using grid-area. We\'ll explore practical examples like creating a magazine-style layout, a dashboard interface, and responsive card grids. You\'ll also understand the difference between Grid and Flexbox and when to use each layout method.',
                'content_ar' => 'تخطيط CSS Grid هو نظام تخطيط ثنائي الأبعاد يتيح لك إنشاء تصاميم استجابة معقدة بسهولة. يغطي هذا الدرس المفاهيم الأساسية للـ Grid، بما في ذلك حاويات الشبكة وعناصر الشبكة وخطوط الشبكة ومسارات الشبكة. ستتعلم كيفية تعريف شبكة باستخدام display: grid، وإعداد الأعمدة والصفوف مع grid-template-columns و grid-template-rows، وتموضع العناصر باستخدام grid-area. سنستكشف أمثلة عملية مثل إنشاء تخطيط بنمط المجلة وواجهة لوحة تحكم وشبكات البطاقات الاستجابة. ستفهم أيضاً الفرق بين Grid و Flexbox ومتى تستخدم كل طريقة تخطيط.',
            ],
            [
                'title_en' => 'JavaScript ES6 Arrow Functions',
                'title_ar' => 'دوال السهم في JavaScript ES6',
                'content_en' => 'Arrow functions are a concise way to write function expressions in JavaScript ES6. This lesson will teach you the syntax and behavior of arrow functions, including implicit returns, lexical this binding, and when to use them versus regular functions. You\'ll learn about single-parameter arrows, multi-parameter arrows, and how they handle the "this" context differently from traditional functions. We\'ll cover practical use cases like array methods (map, filter, reduce), event handlers, and callback functions. You\'ll also understand the limitations of arrow functions, such as not having their own "this", "arguments", or "super", and when not to use them.',
                'content_ar' => 'دوال السهم هي طريقة موجزة لكتابة تعبيرات الدوال في JavaScript ES6. سيعلمك هذا الدرس صيغة وسلوك دوال السهم، بما في ذلك الإرجاع الضمني وربط this المعجمي ومتى تستخدمها مقابل الدوال العادية. ستتعلم عن أسهم المعاملة الواحدة وأسهم المعاملات المتعددة وكيف تتعامل مع سياق "this" بشكل مختلف عن الدوال التقليدية. سنغطي حالات الاستخدام العملية مثل طرق المصفوفات (map، filter، reduce) ومعالجات الأحداث ودوال الاستدعاء. ستفهم أيضاً قيود دوال السهم، مثل عدم امتلاكها لـ "this" أو "arguments" أو "super" الخاصة بها، ومتى لا تستخدمها.',
            ],
            // Python Lessons
            [
                'title_en' => 'Python Data Types and Variables',
                'title_ar' => 'أنواع البيانات والمتغيرات في Python',
                'content_en' => 'Understanding data types is fundamental to programming in Python. This lesson covers Python\'s built-in data types including integers, floats, strings, booleans, lists, tuples, dictionaries, and sets. You\'ll learn about variable assignment, naming conventions, and type checking using the type() function. We\'ll explore mutable vs immutable types, understand when and why to use each data type, and practice type conversion between different types. The lesson includes practical exercises on string manipulation, list operations, dictionary methods, and set operations. You\'ll also learn about Python\'s dynamic typing system and how it differs from statically typed languages.',
                'content_ar' => 'فهم أنواع البيانات أساسي للبرمجة في Python. يغطي هذا الدرس أنواع البيانات المدمجة في Python بما في ذلك الأعداد الصحيحة والعشرية والنصوص والقيم المنطقية والقوائم والمجموعات المرتبة والقواميس والمجموعات. ستتعلم عن تعيين المتغيرات واتفاقيات التسمية وفحص النوع باستخدام دالة type(). سنستكشف الأنواع القابلة للتغيير مقابل غير القابلة للتغيير، ونفهم متى ولماذا نستخدم كل نوع بيانات، ونمارس تحويل النوع بين الأنواع المختلفة. يتضمن الدرس تمارين عملية على معالجة النصوص وعمليات القوائم وطرق القواميس وعمليات المجموعات. ستتعلم أيضاً عن نظام الطباعة الديناميكية في Python وكيف يختلف عن اللغات ذات الطباعة الثابتة.',
            ],
            [
                'title_en' => 'Object-Oriented Programming in Python',
                'title_ar' => 'البرمجة الكائنية في Python',
                'content_en' => 'Object-Oriented Programming (OOP) is a programming paradigm that organizes code into classes and objects. This lesson introduces OOP concepts in Python, including classes, objects, attributes, and methods. You\'ll learn how to define classes using the class keyword, create object instances, and understand the __init__ method for object initialization. We\'ll cover the four pillars of OOP: encapsulation, inheritance, polymorphism, and abstraction. You\'ll practice creating real-world examples like a Person class, a BankAccount class, and explore inheritance with Animal and Dog classes. The lesson also covers special methods (dunder methods), property decorators, and class vs instance variables.',
                'content_ar' => 'البرمجة الكائنية (OOP) هي نموذج برمجة ينظم الكود في فئات وكائنات. يقدم هذا الدرس مفاهيم OOP في Python، بما في ذلك الفئات والكائنات والخصائص والطرق. ستتعلم كيفية تعريف الفئات باستخدام الكلمة المفتاحية class وإنشاء مثيلات الكائنات وفهم طريقة __init__ لتهيئة الكائنات. سنغطي الأركان الأربعة لـ OOP: التغليف والوراثة وتعدد الأشكال والتجريد. ستمارس إنشاء أمثلة واقعية مثل فئة Person وفئة BankAccount واستكشاف الوراثة مع فئات Animal و Dog. يغطي الدرس أيضاً الطرق الخاصة (طرق dunder) ومزخرفات الخصائص ومتغيرات الفئة مقابل متغيرات المثيل.',
            ],
            // React Lessons
            [
                'title_en' => 'React Hooks: useState and useEffect',
                'title_ar' => 'خطافات React: useState و useEffect',
                'content_en' => 'React Hooks revolutionized how we write React components by allowing us to use state and lifecycle features in functional components. This lesson focuses on two essential hooks: useState for managing component state and useEffect for handling side effects. You\'ll learn how useState replaces this.state in class components, understand state updates and re-rendering, and practice with examples like counters, form inputs, and toggles. For useEffect, we\'ll cover mounting, updating, and unmounting phases, dependency arrays, and cleanup functions. You\'ll build practical examples including data fetching, event listeners, and timers. The lesson emphasizes best practices and common pitfalls to avoid.',
                'content_ar' => 'خطافات React أحدثت ثورة في كيفية كتابة مكونات React من خلال السماح لنا باستخدام الحالة وميزات دورة الحياة في المكونات الوظيفية. يركز هذا الدرس على خطافين أساسيين: useState لإدارة حالة المكون و useEffect للتعامل مع التأثيرات الجانبية. ستتعلم كيف يستبدل useState this.state في مكونات الفئة، وتفهم تحديثات الحالة وإعادة الرندر، وتتمرن مع أمثلة مثل العدادات ومدخلات النماذج والمفاتيح. بالنسبة لـ useEffect، سنغطي مراحل التركيب والتحديث وإلغاء التركيب ومصفوفات التبعية ودوال التنظيف. ستبني أمثلة عملية تشمل جلب البيانات ومستمعي الأحداث والمؤقتات. يؤكد الدرس على أفضل الممارسات والأخطاء الشائعة التي يجب تجنبها.',
            ],
            [
                'title_en' => 'React Router for Single Page Applications',
                'title_ar' => 'React Router لتطبيقات الصفحة الواحدة',
                'content_en' => 'React Router is the standard routing library for React applications, enabling navigation in single-page applications (SPAs). This lesson covers React Router v6 features including BrowserRouter, Routes, Route, Link, and NavLink components. You\'ll learn how to set up routing in your React app, create nested routes, handle route parameters, and implement programmatic navigation using useNavigate. We\'ll cover protected routes, route guards, and lazy loading with React.lazy and Suspense. You\'ll build a multi-page application with navigation, including a homepage, about page, user profiles, and a 404 not found page. The lesson also covers best practices for organizing routes in larger applications.',
                'content_ar' => 'React Router هي مكتبة التوجيه المعيارية لتطبيقات React، مما يتيح التنقل في تطبيقات الصفحة الواحدة (SPAs). يغطي هذا الدرس ميزات React Router v6 بما في ذلك مكونات BrowserRouter و Routes و Route و Link و NavLink. ستتعلم كيفية إعداد التوجيه في تطبيق React الخاص بك وإنشاء مسارات متداخلة والتعامل مع معاملات المسار وتنفيذ التنقل البرمجي باستخدام useNavigate. سنغطي المسارات المحمية وحراس المسار والتحميل البطيء مع React.lazy و Suspense. ستبني تطبيقاً متعدد الصفحات مع التنقل، بما في ذلك الصفحة الرئيسية وصفحة "عنا" وملفات تعريف المستخدمين وصفحة 404 غير موجودة. يغطي الدرس أيضاً أفضل الممارسات لتنظيم المسارات في التطبيقات الأكبر.',
            ],
            // Database Lessons
            [
                'title_en' => 'SQL JOIN Operations and Relationships',
                'title_ar' => 'عمليات SQL JOIN والعلاقات',
                'content_en' => 'JOIN operations are fundamental to working with relational databases, allowing you to combine data from multiple tables. This lesson covers all types of JOINs: INNER JOIN, LEFT JOIN, RIGHT JOIN, and FULL OUTER JOIN. You\'ll understand how foreign keys establish relationships between tables and learn to write complex queries that retrieve data from multiple related tables. We\'ll practice with realistic examples using customer, order, and product tables. You\'ll learn about table aliases, join conditions, and how to optimize JOIN queries for better performance. The lesson includes exercises on many-to-many relationships using junction tables and advanced scenarios like self-joins.',
                'content_ar' => 'عمليات JOIN أساسية للعمل مع قواعد البيانات العلائقية، مما يتيح لك دمج البيانات من جداول متعددة. يغطي هذا الدرس جميع أنواع JOINs: INNER JOIN و LEFT JOIN و RIGHT JOIN و FULL OUTER JOIN. ستفهم كيف تنشئ المفاتيح الخارجية علاقات بين الجداول وتتعلم كتابة استعلامات معقدة تسترد البيانات من جداول متعددة ذات صلة. سنتمرن مع أمثلة واقعية باستخدام جداول العملاء والطلبات والمنتجات. ستتعلم عن أسماء مستعارة للجداول وشروط الربط وكيفية تحسين استعلامات JOIN لأداء أفضل. يتضمن الدرس تمارين على العلاقات من نوع كثير إلى كثير باستخدام جداول الوصل والسيناريوهات المتقدمة مثل self-joins.',
            ],
            // API Development
            [
                'title_en' => 'RESTful API Design Principles',
                'title_ar' => 'مبادئ تصميم REST API',
                'content_en' => 'REST (Representational State Transfer) is an architectural style for designing web APIs that are scalable, maintainable, and easy to understand. This lesson covers the fundamental principles of RESTful API design including statelessness, uniform interface, and resource-based URLs. You\'ll learn about HTTP methods (GET, POST, PUT, PATCH, DELETE) and their proper usage, status codes, and request/response formats. We\'ll explore best practices for API versioning, pagination, filtering, and error handling. You\'ll understand how to structure endpoints, use proper naming conventions, and implement HATEOAS (Hypermedia as the Engine of Application State). The lesson includes practical examples of designing APIs for different domains like e-commerce and social media.',
                'content_ar' => 'REST (نقل الحالة التمثيلية) هو نمط معماري لتصميم واجهات برمجة تطبيقات الويب التي تكون قابلة للتوسع وقابلة للصيانة وسهلة الفهم. يغطي هذا الدرس المبادئ الأساسية لتصميم REST API بما في ذلك عدم الحفاظ على الحالة والواجهة الموحدة وعناوين URL المبنية على الموارد. ستتعلم عن طرق HTTP (GET، POST، PUT، PATCH، DELETE) واستخدامها الصحيح ورموز الحالة وتنسيقات الطلب/الاستجابة. سنستكشف أفضل الممارسات لإصدارات API والتصفح والتصفية ومعالجة الأخطاء. ستفهم كيفية هيكلة نقاط النهاية واستخدام اتفاقيات التسمية المناسبة وتنفيذ HATEOAS. يتضمن الدرس أمثلة عملية لتصميم APIs لمجالات مختلفة مثل التجارة الإلكترونية ووسائل التواصل الاجتماعي.',
            ],
            // DevOps Lessons
            [
                'title_en' => 'Docker Containerization Basics',
                'title_ar' => 'أساسيات الحاويات Docker',
                'content_en' => 'Docker is a platform that uses containerization technology to package applications and their dependencies into lightweight, portable containers. This lesson introduces Docker fundamentals including images, containers, and the Docker architecture. You\'ll learn how to install Docker, understand the difference between containers and virtual machines, and explore the benefits of containerization. We\'ll cover writing Dockerfiles, building custom images, and running containers with various options. You\'ll practice with real examples like containerizing a Node.js web application, a Python Flask app, and a static website. The lesson also covers Docker Hub, image versioning, and basic container management commands.',
                'content_ar' => 'Docker هو منصة تستخدم تقنية الحاويات لتعبئة التطبيقات وتبعياتها في حاويات خفيفة الوزن ومحمولة. يقدم هذا الدرس أساسيات Docker بما في ذلك الصور والحاويات ومعمارية Docker. ستتعلم كيفية تثبيت Docker وفهم الفرق بين الحاويات والآلات الافتراضية واستكشاف فوائد الحاويات. سنغطي كتابة Dockerfiles وبناء صور مخصصة وتشغيل الحاويات مع خيارات متنوعة. ستتمرن مع أمثلة حقيقية مثل وضع تطبيق ويب Node.js وتطبيق Python Flask وموقع ويب ثابت في حاويات. يغطي الدرس أيضاً Docker Hub وإصدارات الصور وأوامر إدارة الحاويات الأساسية.',
            ],
        ];

        $lesson = $this->faker->randomElement($programmingLessons);

        $videoUrls = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://vimeo.com/123456789',
            'https://www.youtube.com/watch?v=ScMzIvxBSi4',
            'https://vimeo.com/987654321',
            'https://www.youtube.com/watch?v=jNQXAC9IVRw',
            'https://www.youtube.com/watch?v=oavMtUWDBTM',
            'https://vimeo.com/456789123',
            'https://www.youtube.com/watch?v=fJ9rUzIMcZQ',
        ];

        return [
            'course_id' => Course::factory(),
            'title_ar' => $lesson['title_ar'],
            'title_en' => $lesson['title_en'],
            'content_ar' => $lesson['content_ar'],
            'content_en' => $lesson['content_en'],
            'video_url' => $this->faker->optional(0.7)->randomElement($videoUrls),
            'sort_order' => $this->faker->numberBetween(1, 100),
            'is_active' => $this->faker->boolean(85), // 85% chance of being active
        ];
    }

    /**
     * Indicate that the lesson belongs to a specific course.
     */
    public function forCourse(int $courseId): static
    {
        return $this->state(fn(array $attributes) => [
            'course_id' => $courseId,
        ]);
    }

    /**
     * Indicate that the lesson is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the lesson is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create ordered lessons for a course with proper sort order.
     */
    public function ordered(int $order = null): static
    {
        return $this->state(fn(array $attributes) => [
            'sort_order' => $order ?? $this->faker->unique()->numberBetween(1, 100),
        ]);
    }

    /**
     * Indicate that the lesson has a video.
     */
    public function withVideo(): static
    {
        $videoUrls = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://vimeo.com/123456789',
            'https://www.youtube.com/watch?v=ScMzIvxBSi4',
            'https://vimeo.com/987654321',
        ];

        return $this->state(fn(array $attributes) => [
            'video_url' => $this->faker->randomElement($videoUrls),
        ]);
    }

    /**
     * Indicate that the lesson has no video.
     */
    public function withoutVideo(): static
    {
        return $this->state(fn(array $attributes) => [
            'video_url' => null,
        ]);
    }
}
