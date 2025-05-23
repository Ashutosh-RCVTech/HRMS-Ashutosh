<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FAQController extends Controller
{
    /**
     * Display the FAQ page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // FAQs data without using database
        $faqs = [
            [
                'category' => 'Getting Started',
                'questions' => [
                    [
                        'question' => 'How do I create an account?',
                        'answer' => 'You can create an account by clicking the "Sign Up" button on our homepage. Fill in your personal information, verify your email address, and you\'re ready to go.'
                    ],
                    [
                        'question' => 'Is registration free?',
                        'answer' => 'Yes, creating a candidate account is completely free. You can browse jobs and submit applications without any charges.'
                    ],
                    [
                        'question' => 'What information do I need to provide when registering?',
                        'answer' => 'You\'ll need to provide your name, email address, and create a password. You can add more details to your profile later.'
                    ],
                    [
                        'question' => 'Can I use my social media accounts to register?',
                        'answer' => 'Yes, we support registration and login via Google, and Github accounts for your convenience.'
                    ],
                    [
                        'question' => 'How do I register as a college student?',
                        'answer' => 'Select "College Sign In" and use your college email address to register. You\'ll need to verify your student status through your college email.'
                    ]
                ]
            ],
            [
                'category' => 'Job Applications',
                'questions' => [
                    [
                        'question' => 'How do I apply for a job?',
                        'answer' => 'Browse the job listings, click on a job that interests you, and click the "Apply Now" button. You\'ll need to complete the application form and submit your resume.'
                    ],
                    [
                        'question' => 'Can I apply for multiple jobs?',
                        'answer' => 'Yes, you can apply for as many jobs as you wish. Each application is tracked separately in your dashboard.'
                    ],
                    [
                        'question' => 'How can I check the status of my application?',
                        'answer' => 'You can view the status of all your applications on your candidate dashboard under the "My Applications" section.'
                    ],
                    [
                        'question' => 'Can I edit my application after submission?',
                        'answer' => 'Once submitted, you cannot edit your application. Please ensure all information is accurate before submitting.'
                    ],
                    [
                        'question' => 'How will I be notified about updates to my application?',
                        'answer' => 'You will receive email notifications about any changes to your application status. You can also check your dashboard for real-time updates.'
                    ],
                    [
                        'question' => 'How do I apply for campus placements?',
                        'answer' => 'Log in with your college email, browse available placement opportunities, and apply through the campus placement portal. Make sure to meet all eligibility criteria.'
                    ]
                ]
            ],
            [
                'category' => 'Profile Management',
                'questions' => [
                    [
                        'question' => 'How do I update my profile information?',
                        'answer' => 'Go to your dashboard and click on "Edit Profile". You can update your personal information, work experience, education, skills, and upload a new resume.'
                    ],
                    [
                        'question' => 'Can I have multiple resumes on my profile?',
                        'answer' => 'Yes, you can upload multiple resumes to your profile. This allows you to use different resumes for different types of job applications.'
                    ],
                    [
                        'question' => 'Is my profile information visible to all employers?',
                        'answer' => 'Your profile is only visible to employers when you apply for their job positions.'
                    ],
                    [
                        'question' => 'How do I add work experience to my profile?',
                        'answer' => 'In your profile section, click on "Add Work Experience" and fill in the details about your previous employment, including company name, position, and dates.'
                    ],
                    [
                        'question' => 'How do I add my academic details?',
                        'answer' => 'In your profile section, click on "Add Education" and fill in your academic information, including degree, institution, year of passing, and CGPA/percentage.'
                    ]
                ]
            ],
            [
                'category' => 'College Placement',
                'questions' => [
                    [
                        'question' => 'What is the campus placement process?',
                        'answer' => 'The campus placement process includes registration, profile completion, eligibility verification, application submission, and participation in placement drives.'
                    ],
                    [
                        'question' => 'How do I know if I\'m eligible for a placement drive?',
                        'answer' => 'Eligibility criteria are clearly listed for each placement opportunity. Check your academic performance, attendance, and other requirements before applying.'
                    ],
                    [
                        'question' => 'What documents do I need for placement verification?',
                        'answer' => 'You\'ll need your college ID, academic transcripts, resume, and any other documents specified by the placement cell or recruiting company.'
                    ],
                    [
                        'question' => 'How are placement interviews conducted?',
                        'answer' => 'Placement interviews may be conducted online or on-campus, depending on the company\'s requirements. You\'ll receive detailed instructions about the interview process.'
                    ],
                    [
                        'question' => 'Can I participate in off-campus placements?',
                        'answer' => 'Yes, you can participate in both on-campus and off-campus placements. Make sure to check with your college placement cell for any specific guidelines.'
                    ],
                    [
                        'question' => 'How do I track my placement application status?',
                        'answer' => 'You can track your placement application status in the "Placements" section of your dashboard. You\'ll also receive email notifications about updates.'
                    ]
                ]
            ],
            [
                'category' => 'Technical Issues',
                'questions' => [
                    // [
                    //     'question' => 'I forgot my password. How do I reset it?',
                    //     'answer' => 'Click on "Forgot Password" on the login page. Enter your email address, and we\'ll send you a link to reset your password.'
                    // ],
                    [
                        'question' => 'Why am I unable to upload my resume?',
                        'answer' => 'Make sure your resume is in PDF, DOC, or DOCX format and does not exceed 5MB in size. If you\'re still having issues, try a different browser or contact support.'
                    ],
                    [
                        'question' => 'The website is not displaying correctly. What should I do?',
                        'answer' => 'Try clearing your browser cache, updating your browser to the latest version, or using a different browser. If problems persist, please contact our support team.'
                    ],
                    [
                        'question' => 'I\'m not receiving email notifications. What\'s wrong?',
                        'answer' => 'Check your spam or junk folder first. If you still don\'t see our emails, add our domain to your safe senders list or contact support for assistance.'
                    ],
                    [
                        'question' => 'How do I reset my password?',
                        'answer' => 'Click on "Forgot Password" on the login page, enter your email address, and follow the instructions sent to your email to reset your password.'
                    ]
                ]
            ]
        ];


        return view('recruitment::candidate.faq', compact('faqs'));
    }
}
