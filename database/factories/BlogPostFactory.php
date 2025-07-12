<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programmingBlogPosts = [
            [
                'title_en' => 'The Future of JavaScript: What to Expect in 2025',
                'title_ar' => 'مستقبل JavaScript: ما نتوقعه في عام 2025',
                'content_en' => 'JavaScript continues to evolve at a rapid pace, and 2025 promises to bring exciting new features and improvements to the language. In this comprehensive guide, we\'ll explore the upcoming ECMAScript proposals, new browser APIs, and emerging frameworks that will shape web development in the coming year. From improved async handling with top-level await in modules to enhanced type checking capabilities, JavaScript is becoming more powerful and developer-friendly. We\'ll also discuss the growing importance of WebAssembly integration, the rise of micro-frontends architecture, and how AI-assisted coding is changing the way we write JavaScript. Additionally, we\'ll cover performance optimizations, security enhancements, and best practices for modern JavaScript development. Whether you\'re a seasoned developer or just starting your coding journey, understanding these trends will help you stay ahead in the rapidly evolving world of web development.',
                'content_ar' => 'تستمر JavaScript في التطور بوتيرة سريعة، ويعد عام 2025 بإحضار ميزات وتحسينات جديدة ومثيرة للغة. في هذا الدليل الشامل، سنستكشف مقترحات ECMAScript القادمة وواجهات برمجة التطبيقات الجديدة للمتصفحات والأطر الناشئة التي ستشكل تطوير الويب في العام القادم. من تحسين التعامل مع العمليات غير المتزامنة مع top-level await في الوحدات إلى قدرات فحص النوع المحسنة، تصبح JavaScript أكثر قوة وودية للمطورين. سنناقش أيضاً الأهمية المتزايدة لتكامل WebAssembly وصعود معمارية micro-frontends وكيف تغير البرمجة بمساعدة الذكاء الاصطناعي الطريقة التي نكتب بها JavaScript. بالإضافة إلى ذلك، سنغطي تحسينات الأداء والتعزيزات الأمنية وأفضل الممارسات لتطوير JavaScript الحديث.',
            ],
            [
                'title_en' => 'Building Scalable React Applications: Architecture Best Practices',
                'title_ar' => 'بناء تطبيقات React قابلة للتوسع: أفضل الممارسات المعمارية',
                'content_en' => 'As React applications grow in complexity, maintaining a clean and scalable architecture becomes crucial for long-term success. This article explores proven strategies for structuring large React projects, from folder organization to component design patterns. We\'ll dive deep into state management solutions like Redux Toolkit and Zustand, discuss when to use Context vs external state libraries, and explore advanced patterns like compound components and render props. Performance optimization techniques including code splitting, lazy loading, and memoization will be covered extensively. We\'ll also examine testing strategies for complex React applications, including unit tests, integration tests, and end-to-end testing with tools like Jest, React Testing Library, and Cypress. Error boundaries, logging, and monitoring in production environments are essential topics we\'ll address. Finally, we\'ll discuss deployment strategies, CI/CD pipelines, and how to structure your codebase for multiple environments.',
                'content_ar' => 'مع نمو تطبيقات React في التعقيد، يصبح الحفاظ على معمارية نظيفة وقابلة للتوسع أمراً بالغ الأهمية للنجاح طويل المدى. يستكشف هذا المقال الاستراتيجيات المجربة لهيكلة مشاريع React الكبيرة، من تنظيم المجلدات إلى أنماط تصميم المكونات. سنغوص عميقاً في حلول إدارة الحالة مثل Redux Toolkit و Zustand، ونناقش متى نستخدم Context مقابل مكتبات الحالة الخارجية، ونستكشف الأنماط المتقدمة مثل compound components و render props. ستتم تغطية تقنيات تحسين الأداء بشكل مكثف بما في ذلك تقسيم الكود والتحميل البطيء والذاكرة المؤقتة. سنفحص أيضاً استراتيجيات الاختبار لتطبيقات React المعقدة، بما في ذلك اختبارات الوحدة واختبارات التكامل والاختبار من النهاية إلى النهاية باستخدام أدوات مثل Jest و React Testing Library و Cypress.',
            ],
            [
                'title_en' => 'Python for Data Science: From Pandas to Machine Learning',
                'title_ar' => 'Python لعلم البيانات: من Pandas إلى التعلم الآلي',
                'content_en' => 'Python has become the go-to language for data science, offering powerful libraries and tools that make data analysis accessible to developers of all skill levels. This comprehensive guide takes you through the entire data science workflow using Python, starting with data manipulation using Pandas and NumPy. We\'ll explore data visualization techniques with Matplotlib and Seaborn, learn how to clean and preprocess data, and handle missing values effectively. The article covers statistical analysis, hypothesis testing, and correlation analysis using SciPy. Moving into machine learning, we\'ll implement various algorithms using Scikit-learn, including linear regression, decision trees, random forests, and clustering techniques. Deep learning concepts will be introduced using TensorFlow and Keras, covering neural networks, CNNs, and RNNs. We\'ll also discuss model evaluation metrics, cross-validation, and hyperparameter tuning. Real-world case studies and project examples will demonstrate practical applications of these concepts.',
                'content_ar' => 'أصبحت Python اللغة المفضلة لعلم البيانات، حيث تقدم مكتبات وأدوات قوية تجعل تحليل البيانات في متناول المطورين من جميع مستويات المهارة. يأخذك هذا الدليل الشامل عبر سير عمل علم البيانات بالكامل باستخدام Python، بدءاً من معالجة البيانات باستخدام Pandas و NumPy. سنستكشف تقنيات تصور البيانات مع Matplotlib و Seaborn، ونتعلم كيفية تنظيف ومعالجة البيانات مسبقاً، والتعامل مع القيم المفقودة بفعالية. يغطي المقال التحليل الإحصائي واختبار الفرضيات وتحليل الارتباط باستخدام SciPy. بالانتقال إلى التعلم الآلي، سننفذ خوارزميات مختلفة باستخدام Scikit-learn، بما في ذلك الانحدار الخطي وأشجار القرار والغابات العشوائية وتقنيات التجميع. سيتم تقديم مفاهيم التعلم العميق باستخدام TensorFlow و Keras، مع تغطية الشبكات العصبية و CNNs و RNNs.',
            ],
            [
                'title_en' => 'Modern CSS: Grid, Flexbox, and Beyond',
                'title_ar' => 'CSS الحديث: Grid و Flexbox وما بعدها',
                'content_en' => 'CSS has evolved dramatically in recent years, introducing powerful layout systems and modern features that have revolutionized web design. This article provides an in-depth exploration of modern CSS techniques, starting with CSS Grid and Flexbox - the two most important layout methods in contemporary web development. We\'ll cover when to use Grid versus Flexbox, how to create responsive layouts without media queries using intrinsic web design principles, and advanced Grid techniques like subgrid and container queries. The article also explores CSS custom properties (variables), the cascade and specificity in detail, and new pseudo-classes like :has() and :where(). We\'ll discuss CSS architecture methodologies including BEM, SMACSS, and CSS-in-JS approaches. Modern CSS features like CSS Houdini, scroll-driven animations, and the upcoming CSS container queries will be demonstrated with practical examples. Performance considerations, including critical CSS and CSS optimization techniques, round out this comprehensive guide to modern CSS development.',
                'content_ar' => 'تطورت CSS بشكل كبير في السنوات الأخيرة، مقدمة أنظمة تخطيط قوية وميزات حديثة أحدثت ثورة في تصميم الويب. يقدم هذا المقال استكشافاً متعمقاً لتقنيات CSS الحديثة، بدءاً من CSS Grid و Flexbox - أهم طريقتين للتخطيط في تطوير الويب المعاصر. سنغطي متى نستخدم Grid مقابل Flexbox، وكيفية إنشاء تخطيطات استجابة بدون استعلامات الوسائط باستخدام مبادئ التصميم الجوهري للويب، وتقنيات Grid المتقدمة مثل subgrid واستعلامات الحاوية. يستكشف المقال أيضاً خصائص CSS المخصصة (المتغيرات) والتسلسل والخصوصية بالتفصيل، والفئات الزائفة الجديدة مثل :has() و :where(). سنناقش منهجيات معمارية CSS بما في ذلك BEM و SMACSS ونهج CSS-in-JS. ستتم مناقشة ميزات CSS الحديثة مثل CSS Houdini والرسوم المتحركة المدفوعة بالتمرير واستعلامات حاوية CSS القادمة مع أمثلة عملية.',
            ],
            [
                'title_en' => 'DevOps Fundamentals: Docker, Kubernetes, and CI/CD',
                'title_ar' => 'أساسيات DevOps: Docker و Kubernetes و CI/CD',
                'content_en' => 'DevOps practices have become essential for modern software development, enabling teams to deliver applications faster and more reliably. This comprehensive guide covers the fundamental tools and practices that form the backbone of DevOps workflows. We\'ll start with containerization using Docker, learning how to create efficient container images, manage multi-container applications with Docker Compose, and implement best practices for container security. The article then progresses to Kubernetes, covering cluster architecture, pods, services, deployments, and ingress controllers. We\'ll explore how to deploy applications to Kubernetes, manage configurations and secrets, and implement horizontal pod autoscaling. Continuous Integration and Continuous Deployment (CI/CD) pipelines are covered extensively, with examples using GitHub Actions, GitLab CI, and Jenkins. Infrastructure as Code (IaC) concepts using Terraform and AWS CloudFormation are discussed, along with monitoring and logging strategies using tools like Prometheus, Grafana, and ELK stack. Security considerations throughout the DevOps pipeline are emphasized.',
                'content_ar' => 'أصبحت ممارسات DevOps ضرورية لتطوير البرمجيات الحديث، مما يمكن الفرق من تسليم التطبيقات بشكل أسرع وأكثر موثوقية. يغطي هذا الدليل الشامل الأدوات والممارسات الأساسية التي تشكل العمود الفقري لسير عمل DevOps. سنبدأ بالحاويات باستخدام Docker، ونتعلم كيفية إنشاء صور حاويات فعالة وإدارة التطبيقات متعددة الحاويات مع Docker Compose وتنفيذ أفضل الممارسات لأمان الحاويات. ينتقل المقال بعد ذلك إلى Kubernetes، مغطياً معمارية الكتلة والـ pods والخدمات والنشر ووحدات تحكم الدخول. سنستكشف كيفية نشر التطبيقات إلى Kubernetes وإدارة التكوينات والأسرار وتنفيذ التوسع التلقائي الأفقي للـ pods. يتم تغطية خطوط التكامل المستمر والنشر المستمر (CI/CD) بشكل مكثف، مع أمثلة باستخدام GitHub Actions و GitLab CI و Jenkins.',
            ],
            [
                'title_en' => 'Node.js Performance Optimization: Tips and Techniques',
                'title_ar' => 'تحسين أداء Node.js: نصائح وتقنيات',
                'content_en' => 'Node.js performance optimization is crucial for building scalable server-side applications that can handle high traffic loads efficiently. This article explores various techniques and best practices for optimizing Node.js applications, from basic code optimizations to advanced architectural patterns. We\'ll cover the event loop in detail, understanding how it works and how to avoid blocking operations that can degrade performance. Memory management techniques, including garbage collection optimization and memory leak detection, are discussed with practical examples. The article covers profiling tools like clinic.js, Node.js built-in profiler, and Chrome DevTools for identifying performance bottlenecks. Database optimization strategies, including connection pooling, query optimization, and caching strategies using Redis, are explored. We\'ll also discuss clustering and load balancing techniques, worker threads for CPU-intensive tasks, and streaming for handling large datasets. Security considerations for high-performance applications and monitoring strategies for production environments are included.',
                'content_ar' => 'تحسين أداء Node.js أمر بالغ الأهمية لبناء تطبيقات من جانب الخادم قابلة للتوسع يمكنها التعامل مع أحمال حركة المرور العالية بكفاءة. يستكشف هذا المقال تقنيات وأفضل الممارسات المختلفة لتحسين تطبيقات Node.js، من تحسينات الكود الأساسية إلى الأنماط المعمارية المتقدمة. سنغطي حلقة الأحداث بالتفصيل، ونفهم كيف تعمل وكيفية تجنب العمليات المحجوبة التي يمكن أن تضر بالأداء. يتم مناقشة تقنيات إدارة الذاكرة، بما في ذلك تحسين جمع القمامة واكتشاف تسريبات الذاكرة، مع أمثلة عملية. يغطي المقال أدوات التنميط مثل clinic.js ومنمق Node.js المدمج و Chrome DevTools لتحديد عقد الأداء. يتم استكشاف استراتيجيات تحسين قاعدة البيانات، بما في ذلك تجميع الاتصالات وتحسين الاستعلامات واستراتيجيات التخزين المؤقت باستخدام Redis.',
            ],
            [
                'title_en' => 'Vue.js 3 Composition API: A Complete Guide',
                'title_ar' => 'Vue.js 3 Composition API: دليل شامل',
                'content_en' => 'Vue.js 3 introduced the Composition API, a new way to organize and reuse component logic that offers more flexibility and better TypeScript support than the Options API. This comprehensive guide explores the Composition API in depth, starting with the fundamental concepts of reactive references, computed properties, and watchers. We\'ll learn how to structure components using the setup function, manage state with ref() and reactive(), and create reusable composables for sharing logic between components. The article covers advanced patterns like dependency injection with provide/inject, custom directives, and teleport for rendering components outside their normal DOM hierarchy. We\'ll also explore how the Composition API improves TypeScript integration, making Vue.js applications more type-safe and maintainable. Performance benefits of the Composition API, including better tree-shaking and smaller bundle sizes, are discussed. Migration strategies from Vue 2 and the Options API are covered, along with best practices for organizing large-scale Vue.js applications using the Composition API.',
                'content_ar' => 'قدمت Vue.js 3 Composition API، وهي طريقة جديدة لتنظيم وإعادة استخدام منطق المكونات التي تقدم مرونة أكبر ودعماً أفضل لـ TypeScript من Options API. يستكشف هذا الدليل الشامل Composition API بعمق، بدءاً من المفاهيم الأساسية للمراجع التفاعلية والخصائص المحسوبة والمراقبين. سنتعلم كيفية هيكلة المكونات باستخدام دالة setup وإدارة الحالة مع ref() و reactive() وإنشاء composables قابلة لإعادة الاستخدام لمشاركة المنطق بين المكونات. يغطي المقال الأنماط المتقدمة مثل حقن التبعية مع provide/inject والتوجيهات المخصصة و teleport لعرض المكونات خارج تسلسل DOM العادي. سنستكشف أيضاً كيف تحسن Composition API تكامل TypeScript، مما يجعل تطبيقات Vue.js أكثر أماناً في النوع وقابلة للصيانة.',
            ],
            [
                'title_en' => 'Microservices Architecture: Design Patterns and Best Practices',
                'title_ar' => 'معمارية الخدمات المصغرة: أنماط التصميم وأفضل الممارسات',
                'content_en' => 'Microservices architecture has revolutionized how we build and deploy modern applications, offering scalability, flexibility, and technology diversity. This article provides a comprehensive guide to designing and implementing microservices, covering essential patterns and best practices. We\'ll explore service decomposition strategies, bounded contexts from Domain-Driven Design (DDD), and how to identify service boundaries effectively. Communication patterns between services, including synchronous REST APIs, asynchronous messaging with tools like RabbitMQ and Apache Kafka, and event-driven architectures are discussed in detail. The article covers data management in microservices, including the database-per-service pattern, distributed transactions, and eventual consistency. Service discovery mechanisms, API gateways, and cross-cutting concerns like logging, monitoring, and distributed tracing are explored. We\'ll also address challenges like service versioning, backward compatibility, testing strategies for distributed systems, and deployment patterns including blue-green deployments and canary releases. Security considerations and fault tolerance patterns complete this comprehensive guide.',
                'content_ar' => 'أحدثت معمارية الخدمات المصغرة ثورة في كيفية بناء ونشر التطبيقات الحديثة، مقدمة قابلية التوسع والمرونة وتنوع التكنولوجيا. يقدم هذا المقال دليلاً شاملاً لتصميم وتنفيذ الخدمات المصغرة، مغطياً الأنماط الأساسية وأفضل الممارسات. سنستكشف استراتيجيات تفكيك الخدمات والسياقات المحدودة من التصميم المدفوع بالمجال (DDD) وكيفية تحديد حدود الخدمة بفعالية. يتم مناقشة أنماط التواصل بين الخدمات بالتفصيل، بما في ذلك REST APIs المتزامنة والرسائل غير المتزامنة بأدوات مثل RabbitMQ و Apache Kafka والمعماريات المدفوعة بالأحداث. يغطي المقال إدارة البيانات في الخدمات المصغرة، بما في ذلك نمط قاعدة البيانات لكل خدمة والمعاملات الموزعة والاتساق النهائي. يتم استكشاف آليات اكتشاف الخدمة وبوابات API والاهتمامات الشاملة مثل التسجيل والمراقبة والتتبع الموزع.',
            ],
        ];

        $blogPost = $this->faker->randomElement($programmingBlogPosts);
        $slug = Str::slug($blogPost['title_en']) . '-' . $this->faker->unique()->numberBetween(1, 1000);

        $isPublished = $this->faker->boolean(70); // 70% chance of being published
        $publishedAt = $isPublished ? $this->faker->dateTimeBetween('-6 months', 'now') : null;

        return [
            'author_id' => User::factory(),
            'title_ar' => $blogPost['title_ar'],
            'title_en' => $blogPost['title_en'],
            'slug' => $slug,
            'content_ar' => $blogPost['content_ar'],
            'content_en' => $blogPost['content_en'],
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
        ];
    }

    /**
     * Indicate that the blog post is published.
     */
    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the blog post is unpublished (draft).
     */
    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the blog post belongs to a specific author.
     */
    public function byAuthor(int $authorId): static
    {
        return $this->state(fn(array $attributes) => [
            'author_id' => $authorId,
        ]);
    }

    /**
     * Create a recent blog post (published within last month).
     */
    public function recent(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create an old blog post (published more than 6 months ago).
     */
    public function old(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-2 years', '-6 months'),
        ]);
    }

    /**
     * Create a blog post scheduled for future publication.
     */
    public function scheduled(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
            'published_at' => $this->faker->dateTimeBetween('now', '+1 month'),
        ]);
    }
}
