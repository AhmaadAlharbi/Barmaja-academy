<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseComment>
 */
class CourseCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programmingComments = [
            // Questions and Learning
            'Great explanation! But I\'m still confused about the difference between let and const in JavaScript. Could you provide more examples?',
            'This lesson was amazing! However, I\'m getting an error when I try to run the code. Could you help me debug it?',
            'I love how you explained React hooks! Can you make a follow-up video about useContext and useReducer?',
            'The Python OOP concepts are finally clicking for me. Thank you for the clear examples with the Animal and Dog classes!',
            'I\'m struggling with the CSS Grid layout. Do you have any tips for responsive design with grid?',
            'This SQL JOIN tutorial saved my life! I have an interview tomorrow and this was exactly what I needed.',
            'Could you explain more about the difference between POST and PUT requests in REST APIs?',
            'I\'m having trouble understanding arrow functions. When should I use them vs regular functions?',
            'The Docker tutorial is great, but I\'m getting permission errors when mounting volumes. Any suggestions?',
            'This is my first time learning programming and your course is perfect for beginners. Thank you!',

            // Success Stories
            'Just got hired as a junior developer thanks to this course! The portfolio projects really impressed my interviewer.',
            'I finally understand recursion after watching this lesson 5 times! The factorial example was perfect.',
            'Built my first full-stack app using what I learned here. Deployed it to Heroku and it works perfectly!',
            'This course helped me transition from marketing to web development. Best investment I\'ve ever made!',
            'I can finally read and write JavaScript without feeling lost. Thank you for making it so accessible!',

            // Technical Issues and Bugs
            'There\'s a small typo in the code at 15:30 - you wrote "function" instead of "const". Just wanted to help!',
            'The GitHub repo link in the description seems to be broken. Could you please update it?',
            'I think there might be a version compatibility issue with the React code. I\'m using React 18.',
            'The npm install is failing on my Windows machine. Has anyone else encountered this issue?',
            'Should we be using TypeScript instead of JavaScript for this project? What are your thoughts?',

            // Appreciation and Feedback
            'Your teaching style is incredible! You explain complex concepts in such a simple way.',
            'I\'ve taken many programming courses but yours are by far the best. Keep up the amazing work!',
            'Love the real-world projects in this course. Much better than just theoretical examples.',
            'The way you handle errors and debugging is so helpful. Most instructors skip this part.',
            'Thank you for updating the course content regularly. It really shows you care about your students.',

            // Advanced Questions
            'How would you optimize this algorithm for larger datasets? Is there a more efficient approach?',
            'Could you explain the time complexity of this sorting algorithm? I think it might be O(n²).',
            'What are your thoughts on using this design pattern in a production environment?',
            'How does this approach compare to using a microservices architecture?',
            'Is there a way to implement this feature without adding external dependencies?',

            // Requests and Suggestions
            'Could you make a course about GraphQL? Your teaching style would be perfect for it.',
            'Please add more exercises at the end of each lesson. Practice problems would be really helpful.',
            'Would love to see a mobile app development course using React Native next!',
            'Can you create a course about testing? Unit tests, integration tests, etc.',
            'More DevOps content would be amazing! Docker, Kubernetes, CI/CD pipelines.',

            // Beginner Struggles
            'I\'m completely new to programming. Should I start with this course or learn HTML/CSS first?',
            'How long did it take you to become comfortable with programming? I feel so overwhelmed.',
            'I keep making syntax errors. Any tips for avoiding them?',
            'Should I be taking notes while watching? What\'s the best way to learn programming?',
            'I understand the concepts but struggle with coding from scratch. How do I improve?',

            // Community Help
            'For anyone struggling with async/await, I found this additional resource helpful: [link]',
            'I created a cheat sheet for all the JavaScript methods covered in this course. Happy to share!',
            'If you\'re getting CORS errors, make sure to install the cors middleware in your Express app.',
            'Here\'s a GitHub repo with all the solutions to the coding challenges: [link]',
            'I\'m organizing a study group for this course. Message me if you want to join!',

            // Arabic Comments (for bilingual support)
            'شرح ممتاز! أخيراً فهمت مفهوم البرمجة الكائنية في Python. شكراً لك!',
            'هذه أول مرة أتعلم فيها البرمجة وأسلوبك في التدريس رائع جداً.',
            'هل يمكنك عمل دورة عن React Native؟ أريد تعلم تطوير تطبيقات الجوال.',
            'واجهت مشكلة في تشغيل الكود. هل يمكن أن تساعدني؟',
            'الدورة مفيدة جداً وأسلوب الشرح واضح ومبسط. أنصح بها بشدة!',
        ];

        $replyComments = [
            'Thanks for the help! That fixed my issue.',
            'I had the same problem. This solution worked perfectly.',
            'Great suggestion! I\'ll try that approach.',
            'You\'re absolutely right. Thanks for the correction.',
            'That\'s exactly what I was looking for. Much appreciated!',
            'Interesting perspective. I hadn\'t thought of it that way.',
            'I disagree. I think the original approach is better because...',
            'Can you explain this in more detail? I\'m still not getting it.',
            'This is gold! Thank you so much for sharing.',
            'I tried this but I\'m getting a different error now.',
            '+1 to this suggestion!',
            'Same here! Looking forward to the instructor\'s response.',
            'Thanks for sharing the resource. Very helpful!',
            'I was stuck on this for hours. You\'re a lifesaver!',
            'شكراً لك على المساعدة! حل المشكلة تماماً.',
        ];

        $isReply = $this->faker->boolean(30); // 30% chance of being a reply
        $content = $isReply
            ? $this->faker->randomElement($replyComments)
            : $this->faker->randomElement($programmingComments);

        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'content' => $content,
        ];
    }

    /**
     * Indicate that the comment belongs to a specific user.
     */
    public function fromUser(int $userId): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $userId,
        ]);
    }

    /**
     * Indicate that the comment belongs to a specific course.
     */
    public function forCourse(int $courseId): static
    {
        return $this->state(fn(array $attributes) => [
            'course_id' => $courseId,
        ]);
    }

    /**
     * Indicate that this is a reply to another comment.
     */
    public function replyTo(int $parentCommentId): static
    {
        $replyComments = [
            'Thanks for the help! That fixed my issue.',
            'I had the same problem. This solution worked perfectly.',
            'Great suggestion! I\'ll try that approach.',
            'You\'re absolutely right. Thanks for the correction.',
            'That\'s exactly what I was looking for. Much appreciated!',
            'Interesting perspective. I hadn\'t thought of it that way.',
            'Can you explain this in more detail? I\'m still not getting it.',
            'This is gold! Thank you so much for sharing.',
            'I tried this but I\'m getting a different error now.',
            '+1 to this suggestion!',
            'Same here! Looking forward to the instructor\'s response.',
            'Thanks for sharing the resource. Very helpful!',
            'I was stuck on this for hours. You\'re a lifesaver!',
            'شكراً لك على المساعدة! حل المشكلة تماماً.',
            'مفيد جداً! شكراً لك على الإضافة.',
        ];

        return $this->state(fn(array $attributes) => [
            'content' => $this->faker->randomElement($replyComments),
        ]);
    }

    /**
     * Create a top-level comment (not a reply).
     */
    public function topLevel(): static
    {
        $topLevelComments = [
            'Great explanation! But I\'m still confused about the difference between let and const in JavaScript.',
            'This lesson was amazing! However, I\'m getting an error when I try to run the code.',
            'I love how you explained React hooks! Can you make a follow-up video about useContext?',
            'The Python OOP concepts are finally clicking for me. Thank you for the clear examples!',
            'Just got hired as a junior developer thanks to this course! Thank you so much!',
            'Could you explain more about the difference between POST and PUT requests in REST APIs?',
            'Your teaching style is incredible! You explain complex concepts in such a simple way.',
            'شرح ممتاز! أخيراً فهمت مفهوم البرمجة الكائنية في Python.',
            'هذه أول مرة أتعلم فيها البرمجة وأسلوبك في التدريس رائع جداً.',
        ];

        return $this->state(fn(array $attributes) => [
            'content' => $this->faker->randomElement($topLevelComments),
        ]);
    }

    /**
     * Create a question comment.
     */
    public function question(): static
    {
        $questionComments = [
            'I\'m confused about this concept. Could you explain it differently?',
            'What\'s the difference between these two approaches?',
            'How would you implement this in a real-world project?',
            'Should I be using this pattern in production code?',
            'What are the performance implications of this approach?',
            'Could you provide more examples of when to use this?',
            'I\'m getting an error when I try this. What am I doing wrong?',
            'How does this compare to the previous method you showed?',
            'Is there a more efficient way to write this code?',
            'ما الفرق بين هذين المفهومين؟ لم أفهم بوضوح.',
        ];

        return $this->state(fn(array $attributes) => [
            'content' => $this->faker->randomElement($questionComments),
        ]);
    }

    /**
     * Create an appreciation comment.
     */
    public function appreciation(): static
    {
        $appreciationComments = [
            'Thank you so much for this amazing course! It changed my career.',
            'Your teaching style is the best I\'ve ever seen. Keep it up!',
            'I finally understand programming thanks to your clear explanations.',
            'This course is worth every penny. Highly recommended!',
            'You make complex topics so easy to understand. Amazing work!',
            'Best programming instructor on the internet. No doubt about it.',
            'I\'ve learned more from this course than from my entire CS degree.',
            'شكراً لك على هذه الدورة الرائعة! غيرت مساري المهني تماماً.',
            'أسلوبك في التدريس مميز جداً. استمر في العطاء!',
        ];

        return $this->state(fn(array $attributes) => [
            'content' => $this->faker->randomElement($appreciationComments),
        ]);
    }

    /**
     * Create a bug report comment.
     */
    public function bugReport(): static
    {
        $bugReportComments = [
            'There\'s a small typo in the code at 15:30. Just wanted to help!',
            'The GitHub repo link seems to be broken. Could you update it?',
            'I think there might be a version compatibility issue with the React code.',
            'The npm install is failing on my machine. Anyone else having this issue?',
            'Found a bug in the final project code. The login function isn\'t working.',
            'The database connection string in the example has a syntax error.',
            'Missing semicolon on line 23 of the JavaScript file.',
            'The CSS styles aren\'t being applied correctly in Chrome.',
        ];

        return $this->state(fn(array $attributes) => [
            'content' => $this->faker->randomElement($bugReportComments),
        ]);
    }
}
