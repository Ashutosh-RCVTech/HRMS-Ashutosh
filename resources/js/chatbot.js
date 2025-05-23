// Recruitment Chatbot configuration with enhanced response handling
const chatbotConfig = {
    welcomeMessage: "Hello! I'm your RCV Recruitment Assistant. How can I help you connect with opportunities today?",
    
    // Track conversation state
    conversationState: {
        currentContext: null, // 'candidate', 'college', 'organization', 'help'
        currentTopic: null,   // specific topic within context
        followUpExpected: false
    },
    
    responses: {
        // Candidate specific responses
        "candidate": {
            "hello": "Hi there! I can help you with:\n- Finding jobs (on-campus/off-campus)\n- Resume building\n- Interview preparation\n- Career guidance\nWhat would you like to know more about?",
            "jobs": {
                main: "I can help you find:\n1. On-campus placements\n2. Off-campus opportunities\n3. Internships\n4. Part-time jobs\nWhich type of opportunity are you looking for?",
                "on-campus": "For on-campus placements, I can help you with:\n- Upcoming placement drives in your college\n- Eligibility criteria for different companies\n- Required documents and preparation\n- Application process and deadlines\nWhat specific information do you need?",
                "off-campus": "For off-campus opportunities, I can help you with:\n- Job portals specialized for your field\n- Application strategies for off-campus jobs\n- Networking tips to find hidden opportunities\n- Creating effective job alerts\nWhat would you like guidance on?",
                "internships": "For internships, I can help you with:\n- Finding paid vs. unpaid internships\n- Summer internship opportunities\n- Remote internship options\n- Converting internships to full-time offers\nWhat type of internship are you looking for?",
                "part-time": "For part-time jobs, I can help you with:\n- On-campus work-study options\n- Remote part-time opportunities\n- Balancing work and studies\n- Industry-specific part-time roles\nWhat kind of part-time work interests you?"
            },
            "resume": {
                main: "For resume building, I can help you with:\n- Formatting guidelines\n- Content suggestions\n- Keywords optimization\n- ATS-friendly templates\nWould you like to know more about any of these?",
                "formatting": "For resume formatting, here are key guidelines:\n- Keep it to 1-2 pages maximum\n- Use consistent fonts (Arial, Calibri, or Times New Roman)\n- Maintain margins between 0.5-1 inch\n- Use bullet points for readability\n- Include clear section headings\nWould you like a template recommendation?",
                "content": "For effective resume content:\n- Start with a compelling summary statement\n- Quantify achievements with metrics when possible\n- Use action verbs (Achieved, Implemented, Developed)\n- Tailor content to each job application\n- Include relevant skills and certifications\nWould you like help with any specific section?",
                "keywords": "For optimizing keywords:\n- Review the job description for key terms\n- Include industry-specific terminology\n- Add relevant technical skills and tools\n- Match keywords to the company's values\n- Use both spelled-out terms and acronyms (e.g., AI and Artificial Intelligence)\nNeed help finding the right keywords for your field?"
            },
            "interview": {
                main: "For interview preparation, I can help you with:\n- Common interview questions\n- Technical interview tips\n- HR interview guidance\n- Mock interview scheduling\nWhat would you like to prepare for?",
                "common": "Common interview questions include:\n- Tell me about yourself\n- Why are you interested in this position?\n- What are your strengths and weaknesses?\n- Where do you see yourself in 5 years?\n- Why should we hire you?\nWould you like example answers for any of these?",
                "technical": "For technical interviews:\n- Practice coding problems on platforms like LeetCode\n- Review fundamental concepts in your field\n- Prepare to explain your previous projects\n- Be ready to solve problems on a whiteboard\n- Research company-specific technical questions\nWhat technical field are you interviewing for?",
                "hr": "For HR interviews:\n- Research the company culture and values\n- Prepare questions about the work environment\n- Practice discussing salary expectations\n- Be ready to explain career gaps or changes\n- Prepare examples of conflict resolution\nWould you like more specific HR interview guidance?"
            },
            "career": {
                main: "For career guidance, I can help you with:\n- Career path suggestions\n- Skill development\n- Industry trends\n- Salary expectations\nWhat aspect would you like to explore?",
                "path": "For career path guidance:\n- Let's analyze your interests and strengths\n- Consider short-term vs long-term goals\n- Explore lateral vs vertical movement options\n- Research emerging roles in your field\n- Connect with mentors in target positions\nWhat industry or role are you most interested in?",
                "skills": "For skill development:\n- Identify core skills needed for your target role\n- Explore certification options in your field\n- Find relevant online courses and workshops\n- Practice with real-world projects\n- Join communities for peer learning\nWhat specific skills are you looking to develop?",
                "trends": "For industry trends:\n- I can provide insights on growing sectors\n- Discuss technology disruptions in your field\n- Share hiring outlook for different roles\n- Highlight emerging job titles\n- Discuss geographical hotspots for your industry\nWhich industry would you like trend information for?"
            }
        },
        
        // College specific responses (enhanced with sub-topics)
        "college": {
            "hello": "Hello! I can help you with:\n- Campus recruitment management\n- Student placement tracking\n- Company partnerships\n- Placement statistics\nWhat would you like assistance with?",
            "recruitment": {
                main: "For campus recruitment, I can help you with:\n- Scheduling placement drives\n- Managing company requirements\n- Student eligibility criteria\n- Placement process coordination\nWhich aspect would you like to know more about?",
                "scheduling": "For scheduling placement drives:\n- Create an annual recruitment calendar\n- Coordinate dates with participating companies\n- Plan pre-placement talks and workshops\n- Manage infrastructure requirements\n- Schedule student batches for interviews\nWhat's your timeframe for upcoming drives?",
                "requirements": "For managing company requirements:\n- Document job descriptions and packages\n- Track eligibility criteria per company\n- Prepare student data as per formats\n- Manage assessment test arrangements\n- Handle offer letter processes\nWhich specific requirement do you need help with?"
            },
            "tracking": {
                main: "For student placement tracking, I can help you with:\n- Student performance metrics\n- Placement status updates\n- Interview feedback\n- Offer letter management\nWhat would you like to track?",
                "metrics": "For student performance metrics:\n- Track interview selection ratios\n- Monitor assessment test scores\n- Analyze resume shortlisting patterns\n- Compare department-wise placement rates\n- Generate performance trend reports\nWhich metrics are most important for you?",
                "status": "For placement status updates:\n- Create real-time dashboards for students\n- Set up automated status notifications\n- Manage bulk status updates\n- Track offer acceptance rates\n- Monitor joining status post-graduation\nHow would you like to communicate status updates?"
            }
        },
        
        // Organization specific responses (enhanced with sub-topics)
        "organization": {
            "hello": "Hi! I can help you with:\n- Campus recruitment\n- Job posting\n- Candidate screening\n- Interview scheduling\nWhat would you like assistance with?",
            "campus": {
                main: "For campus recruitment, I can help you with:\n- College selection\n- Drive scheduling\n- Student eligibility\n- Selection process\nWhich aspect would you like to know more about?",
                "selection": "For college selection:\n- Filter by course offerings and specializations\n- Compare historical placement statistics\n- Evaluate academic rankings and accreditations\n- Consider geographical preferences\n- Review previous recruitment success rates\nWhat criteria are most important for your organization?",
                "process": "For selection process design:\n- Create custom assessment frameworks\n- Design technical evaluation criteria\n- Set up multi-stage interview processes\n- Plan group discussions and case studies\n- Establish offer approval workflows\nWhat roles are you recruiting for?"
            },
            "posting": {
                main: "For job postings, I can help you with:\n- Job description creation\n- Requirements specification\n- Salary benchmarking\n- Application management\nWhat would you like to post?",
                "description": "For job description creation:\n- Craft compelling role summaries\n- List key responsibilities clearly\n- Define must-have vs nice-to-have skills\n- Include company culture information\n- Add growth and development opportunities\nFor which position do you need a description?",
                "requirements": "For requirements specification:\n- Define minimum educational qualifications\n- List required technical skills with proficiency levels\n- Specify experience thresholds\n- Include soft skills and competencies\n- Add certification or clearance requirements\nWhat are the key requirements for your position?"
            }
        },
        
        // Help responses (enhanced with sub-topics)
        "help": {
            "general": "I can help you with:\n1. Finding the right opportunities\n2. Connecting with colleges/companies\n3. Managing recruitment processes\n4. Tracking applications and status\nWhat specific help do you need?",
            "opportunities": {
                main: "For finding the right opportunities, I can help with:\n- Job matching based on skills and preferences\n- Discovering companies hiring in your field\n- Exploring roles suited to your experience level\n- Finding opportunities that match your salary expectations\nWhat type of opportunity are you looking for?",
                "matching": "For job matching based on your profile:\n- I can analyze your skills and experience\n- Suggest roles that match your qualifications\n- Recommend industries with high demand for your skills\n- Provide insights on required skill upgrades\nWhat are your top skills and experience level?",
                "discovering": "To discover companies hiring in your field:\n- I can provide lists of active recruiters\n- Filter by industry, size, or location\n- Highlight companies with values matching yours\n- Show companies with strong growth potential\nWhat industry are you interested in?"
            },
            "connecting": {
                main: "For connecting with colleges/companies, I can help with:\n- Introduction requests and referrals\n- Scheduling meetings with recruiters\n- College placement office contacts\n- Industry networking events\nWhat type of connection are you looking to make?",
                "referrals": "For introduction requests and referrals:\n- I can help draft personalized outreach messages\n- Suggest mutual connections that could introduce you\n- Provide templates for cold outreach\n- Offer advice on following up professionally\nWho would you like to connect with?"
            },
            "managing": {
                main: "For managing recruitment processes, I can help with:\n- Streamlining application workflows\n- Candidate communication templates\n- Interview scheduling automation\n- Offer management processes\nWhich part of the recruitment process needs improvement?",
                "workflows": "For streamlining application workflows:\n- Set up automated application screening\n- Create candidate evaluation forms\n- Establish clear stage transitions\n- Design feedback collection systems\n- Implement status notification automation\nWhich workflow stage needs the most improvement?"
            },
            "tracking": {
                main: "For tracking applications and status, I can help with:\n- Application status dashboards\n- Interview progress tracking\n- Feedback and decision monitoring\n- Offer status management\nWhat type of tracking would be most helpful?",
                "status": "For application status dashboards:\n- Track applications across multiple companies\n- Monitor milestone achievements\n- Set reminders for follow-ups\n- Analyze response rates and times\n- Compare your progress against benchmarks\nAre you tracking for personal use or organizational use?"
            }
        }
    },
    defaultResponse: "I'm not sure I understand. Could you please rephrase your question? I can help you with recruitment processes, job opportunities, and connecting with the right stakeholders."
};

document.addEventListener('DOMContentLoaded', () => {
    const chatButton = document.getElementById('chatButton');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');
    
    // Get specific buttons by ID
    const btnCandidate = document.getElementById('btn-candidate');
    const btnCollege = document.getElementById('btn-college');
    const btnOrganization = document.getElementById('btn-organization');
    const btnHelp = document.getElementById('btn-help');

    // Add welcome message
    addMessage(chatbotConfig.welcomeMessage, false);

    // Toggle chat window
    chatButton.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        chatWindow.classList.toggle('block');
    });

    // Close chat window
    closeChat.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
        chatWindow.classList.remove('block');
    });

    // Handle each button individually
    btnCandidate.addEventListener('click', () => {
        const userMessage = "I'm interested in options for candidates";
        
        // Update conversation state
        chatbotConfig.conversationState.currentContext = 'candidate';
        chatbotConfig.conversationState.currentTopic = null;
        chatbotConfig.conversationState.followUpExpected = true;
        
        const botResponse = chatbotConfig.responses.candidate.hello;
        
        addMessage(userMessage, true);
        setTimeout(() => {
            addMessage(botResponse, false);
        }, 500);
    });
    
    btnCollege.addEventListener('click', () => {
        const userMessage = "I'm interested in options for colleges";
        
        // Update conversation state
        chatbotConfig.conversationState.currentContext = 'college';
        chatbotConfig.conversationState.currentTopic = null;
        chatbotConfig.conversationState.followUpExpected = true;
        
        const botResponse = chatbotConfig.responses.college.hello;
        
        addMessage(userMessage, true);
        setTimeout(() => {
            addMessage(botResponse, false);
        }, 500);
    });
    
    btnOrganization.addEventListener('click', () => {
        const userMessage = "I'm interested in options for organizations";
        
        // Update conversation state
        chatbotConfig.conversationState.currentContext = 'organization';
        chatbotConfig.conversationState.currentTopic = null;
        chatbotConfig.conversationState.followUpExpected = true;
        
        const botResponse = chatbotConfig.responses.organization.hello;
        
        addMessage(userMessage, true);
        setTimeout(() => {
            addMessage(botResponse, false);
        }, 500);
    });
    
    btnHelp.addEventListener('click', () => {
        const userMessage = "I need help";
        
        // Update conversation state
        chatbotConfig.conversationState.currentContext = 'help';
        chatbotConfig.conversationState.currentTopic = null;
        chatbotConfig.conversationState.followUpExpected = true;
        
        const botResponse = chatbotConfig.responses.help.general;
        
        addMessage(userMessage, true);
        setTimeout(() => {
            addMessage(botResponse, false);
        }, 500);
    });

    // Handle form submission
    chatForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            addMessage(message, true);
            messageInput.value = '';
            
            // Simulate typing delay
            setTimeout(() => {
                const response = getBotResponse(message);
                addMessage(response, false);
            }, 1000);
        }
    });

    // Add message to chat
    function addMessage(text, isUser) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex ${isUser ? 'justify-end' : 'justify-start'} mb-4`;
        
        const messageContent = document.createElement('div');
        messageContent.className = `rounded-lg p-3 max-w-xs ${
            isUser 
                ? 'bg-primary-600 text-white' 
                : 'bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200'
        }`;
        
        // Replace newlines with <br> for proper formatting
        messageContent.innerHTML = text.replace(/\n/g, '<br>');
        
        messageDiv.appendChild(messageContent);
        chatMessages.appendChild(messageDiv);
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Improved bot response function with context tracking
    function getBotResponse(message) {
        const lowerMessage = message.toLowerCase();
        const state = chatbotConfig.conversationState;
        
        // Check if we're expecting a follow-up to a specific context
        if (state.followUpExpected && state.currentContext) {
            // Handle follow-up message based on current context
            const context = state.currentContext;
            
            // Process candidate context follow-ups
            if (context === 'candidate') {
                if (state.currentTopic) {
                    // Handle follow-up to specific topic
                    const responses = chatbotConfig.responses.candidate[state.currentTopic];
                    if (typeof responses === 'object') {
                        // Check for sub-topics
                        for (const [subKey, response] of Object.entries(responses)) {
                            if (subKey !== 'main' && lowerMessage.includes(subKey)) {
                                return response;
                            }
                        }
                    }
                } else {
                    // Check for main topics in candidate context
                    for (const [key, value] of Object.entries(chatbotConfig.responses.candidate)) {
                        if (key !== 'hello' && lowerMessage.includes(key)) {
                            state.currentTopic = key;
                            if (typeof value === 'object') {
                                return value.main;
                            }
                            return value;
                        }
                    }
                }
            }
            
            // Process help context follow-ups - this is the specific case you mentioned
            if (context === 'help') {
                if (state.currentTopic) {
                    // Handle follow-up to specific help topic
                    const responses = chatbotConfig.responses.help[state.currentTopic];
                    if (typeof responses === 'object') {
                        // Check for sub-topics
                        for (const [subKey, response] of Object.entries(responses)) {
                            if (subKey !== 'main' && lowerMessage.includes(subKey)) {
                                return response;
                            }
                        }
                    }
                } else {
                    // Check for main topics in help context
                    for (const [key, value] of Object.entries(chatbotConfig.responses.help)) {
                        // Special case for "opportunities" which is what the user mentioned having issues with
                        if ((key === 'opportunities' && lowerMessage.includes('finding') && lowerMessage.includes('opportunities')) ||
                            (key !== 'general' && lowerMessage.includes(key))) {
                            state.currentTopic = key;
                            if (typeof value === 'object') {
                                return value.main;
                            }
                            return value;
                        }
                    }
                }
            }
            
            // Similarly handle college and organization contexts
            // (Code structure similar to the candidate section)
            if (context === 'college') {
                if (state.currentTopic) {
                    const responses = chatbotConfig.responses.college[state.currentTopic];
                    if (typeof responses === 'object') {
                        for (const [subKey, response] of Object.entries(responses)) {
                            if (subKey !== 'main' && lowerMessage.includes(subKey)) {
                                return response;
                            }
                        }
                    }
                } else {
                    for (const [key, value] of Object.entries(chatbotConfig.responses.college)) {
                        if (key !== 'hello' && lowerMessage.includes(key)) {
                            state.currentTopic = key;
                            if (typeof value === 'object') {
                                return value.main;
                            }
                            return value;
                        }
                    }
                }
            }
            
            if (context === 'organization') {
                if (state.currentTopic) {
                    const responses = chatbotConfig.responses.organization[state.currentTopic];
                    if (typeof responses === 'object') {
                        for (const [subKey, response] of Object.entries(responses)) {
                            if (subKey !== 'main' && lowerMessage.includes(subKey)) {
                                return response;
                            }
                        }
                    }
                } else {
                    for (const [key, value] of Object.entries(chatbotConfig.responses.organization)) {
                        if (key !== 'hello' && lowerMessage.includes(key)) {
                            state.currentTopic = key;
                            if (typeof value === 'object') {
                                return value.main;
                            }
                            return value;
                        }
                    }
                }
            }
        }
        
        // If no follow-up match or not in follow-up mode, check for new context
        
        // Check for context identifiers first
        if (lowerMessage.includes('candidate') || lowerMessage.includes('student') || lowerMessage.includes('applicant')) {
            state.currentContext = 'candidate';
            state.currentTopic = null;
            state.followUpExpected = true;
            return chatbotConfig.responses.candidate.hello;
        }
        
        if (lowerMessage.includes('college') || lowerMessage.includes('university') || lowerMessage.includes('institution')) {
            state.currentContext = 'college';
            state.currentTopic = null;
            state.followUpExpected = true;
            return chatbotConfig.responses.college.hello;
        }
        
        if (lowerMessage.includes('organization') || lowerMessage.includes('company') || lowerMessage.includes('employer')) {
            state.currentContext = 'organization';
            state.currentTopic = null;
            state.followUpExpected = true;
            return chatbotConfig.responses.organization.hello;
        }
        
        if (lowerMessage.includes('help') || lowerMessage.includes('assist') || lowerMessage.includes('support')) {
            state.currentContext = 'help';
            state.currentTopic = null;
            state.followUpExpected = true;
            return chatbotConfig.responses.help.general;
        }
        
        // Check for direct topics regardless of context
        // Check candidate topics
        for (const [key, value] of Object.entries(chatbotConfig.responses.candidate)) {
            if (key !== 'hello' && lowerMessage.includes(key)) {
                state.currentContext = 'candidate';
                state.currentTopic = key;
                state.followUpExpected = true;
                if (typeof value === 'object') {
                    return value.main;
                }
                return value;
            }
        }
        
        // Check college topics
        for (const [key, value] of Object.entries(chatbotConfig.responses.college)) {
            if (key !== 'hello' && lowerMessage.includes(key)) {
                state.currentContext = 'college';
                state.currentTopic = key;
                state.followUpExpected = true;
                if (typeof value === 'object') {
                    return value.main;
                }
                return value;
            }
        }
        
        // Check organization topics
        for (const [key, value] of Object.entries(chatbotConfig.responses.organization)) {
            if (key !== 'hello' && lowerMessage.includes(key)) {
                state.currentContext = 'organization';
                state.currentTopic = key;
                state.followUpExpected = true;
                if (typeof value === 'object') {
                    return value.main;
                }
                return value;
            }
        }
        
        // Check help topics
        for (const [key, value] of Object.entries(chatbotConfig.responses.help)) {
            if (key !== 'general' && lowerMessage.includes(key)) {
                state.currentContext = 'help';
                state.currentTopic = key;
                state.followUpExpected = true;
                if (typeof value === 'object') {
                    return value.main;
                }
                return value;
            }
        }
        
        // If nothing matches, check for partial matches or intent
        if (lowerMessage.includes('job') || lowerMessage.includes('work') || lowerMessage.includes('career')) {
            state.currentContext = 'candidate';
            state.currentTopic = 'jobs';
            state.followUpExpected = true;
            return chatbotConfig.responses.candidate.jobs.main;
        }
        
        if (lowerMessage.includes('interview') || lowerMessage.includes('prepare')) {
            state.currentContext = 'candidate';
            state.currentTopic = 'interview';
            state.followUpExpected = true;
            return chatbotConfig.responses.candidate.interview.main;
        }
        
        if (lowerMessage.includes('resume') || lowerMessage.includes('cv')) {
            state.currentContext = 'candidate';
            state.currentTopic = 'resume';
            state.followUpExpected = true;
            return chatbotConfig.responses.candidate.resume.main;
        }
        
        if (lowerMessage.includes('opportunities') || lowerMessage.includes('finding') || lowerMessage.includes('searching')) {
            state.currentContext = 'help';
            state.currentTopic = 'opportunities';
            state.followUpExpected = true;
            return chatbotConfig.responses.help.opportunities.main;
        }
        
        // If still no match, return default
        // Reset conversation state since we're starting over
        state.currentContext = null;
        state.currentTopic = null;
        state.followUpExpected = false;
        
        return chatbotConfig.defaultResponse;
    }
});