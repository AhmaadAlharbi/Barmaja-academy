<?php
// resources/lang/en/enroll.php
return [
    'page_title' => 'Payment - :course - Barmaja Academy',
    'hero' => [
        'badge' => 'Complete Your Enrollment',
        'title' => 'Secure Your Spot in',
        'subtitle' => 'Join thousands of students and start your learning journey today'
    ],
    'course' => [
        'rating' => ':rating/5 from :count reviews',
        'enrolled' => ':count enrolled',
        'features_title' => 'What\'s Included',
        'video_hours' => ':count+ Hours Video',
        'video_description' => 'High-definition content',
        'lifetime_access' => 'Lifetime access to course content',
        'track_progress' => 'Track your learning progress',
        'certificates' => 'Get completion certificates',
        'community' => 'Join our learning community'
    ],
    'pricing' => [
        'special_price' => 'Special Launch Price',
        'save_percentage' => 'Save :percentage%',
        'original_price' => 'Original Price'
    ],
    'form' => [
        'email' => 'Email Address',
        'email_placeholder' => 'your@email.com',
        'cardholder_name' => 'Cardholder Name',
        'cardholder_placeholder' => 'Full name on card',
        'card_details' => 'Card Details',
        'complete_payment' => 'Complete Payment :amount',
        'processing' => 'Processing...',
        'security_text' => 'Secured by Stripe • SSL Encrypted',
        'guarantee_title' => '30-Day Money Back Guarantee',
        'guarantee_text' => 'Not satisfied? Get a full refund within 30 days, no questions asked.'
    ],
    'success' => [
        'title' => 'Payment Successful!',
        'message' => 'You have successfully enrolled in :course',
        'go_to_dashboard' => 'Go to Dashboard'
    ],
    'enrolled' => [
        'title' => 'You\'re Already Enrolled!',
        'message' => 'You have access to this course. Continue your learning journey.',
        'go_to_course' => 'Go to Course'
    ],
    'auth_required' => [
        'title' => 'Access Required',
        'description' => 'To enroll in :course and access premium learning content, please sign in to your account or create a new one.',
        'benefits' => [
            'lifetime_access' => 'Lifetime access to course content',
            'track_progress' => 'Track your learning progress',
            'certificates' => 'Get completion certificates',
            'community' => 'Join our learning community'
        ],
        'sign_in' => 'Sign In',
        'create_account' => 'Create Account',
        'trust_text' => 'Free to join • No hidden fees • Cancel anytime',
        'students' => 'Students',
        'hours' => 'Hours'
    ],
    'errors' => [
        'payment_failed' => 'Payment processing failed. Please try again.',
        'system_error' => 'Payment system not initialized',
        'cardholder_required' => 'Please enter cardholder name',
        'unexpected_error' => 'An unexpected error occurred. Please try again.'
    ]
];