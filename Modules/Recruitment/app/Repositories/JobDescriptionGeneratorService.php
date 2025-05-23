<?php

namespace Modules\Recruitment\Services;

// use GeminiAPI\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class JobDescriptionGeneratorService
{
    /**
     * Generate job description based on input parameters
     *
     * @param array $params
     * @return string
     */
    public function generateDescription(array $params)
    {
        $this->validateParams($params);

        // Create a working copy of params
        $workingParams = $params;

        // Convert skills array to string only when building the prompt
        if (isset($workingParams['skills']) && is_array($workingParams['skills'])) {
            $workingParams['skills'] = implode(', ', $workingParams['skills']);
        }

        $prompt = $this->buildPrompt($workingParams);
        $apiKey = Config::get('gemini.api_key');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                throw new \Exception('API request failed: ' . $response->body());
            }

            $responseData = $response->json();

            if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                throw new \Exception('Invalid API response structure');
            }

            $result = $responseData['candidates'][0]['content']['parts'][0]['text'];
            return $this->refineDescription(trim($result));
        } catch (\Exception $e) {
            Log::error('Job Description Generation Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate job description: ' . $e->getMessage());
        }
    }

    /**
     * Validate input parameters
     *
     * @param array $params
     * @throws \InvalidArgumentException
     */
    protected function validateParams(array $params)
    {
        // Define required parameters and their types
        $requirements = [
            'title' => 'string',
            'client' => 'string',
            'skills' => 'array',
            'experience' => 'string',
            'education_level' => 'string',
            'degree' => 'string'
        ];

        foreach ($requirements as $key => $type) {
            // Check if parameter exists
            if (!isset($params[$key])) {
                throw new \InvalidArgumentException("Missing required parameter: {$key}");
            }

            // Check type
            if ($type === 'array') {
                if (!is_array($params[$key])) {
                    throw new \InvalidArgumentException("{$key} must be an array");
                }
                if (empty($params[$key])) {
                    throw new \InvalidArgumentException("{$key} array cannot be empty");
                }
            } else {
                if (!is_string($params[$key])) {
                    throw new \InvalidArgumentException("{$key} must be a string");
                }
                if (trim($params[$key]) === '') {
                    throw new \InvalidArgumentException("{$key} cannot be empty");
                }
            }
        }
    }

    /**
     * Build a comprehensive prompt for job description generation
     *
     * @param array $params
     * @return string
     */
    protected function buildPrompt(array $params)
    {
        // Format experience range for the prompt
        $experienceRange = $params['experience'];
        if (strpos($experienceRange, '-') !== false) {
            list($min, $max) = explode('-', $experienceRange);
            $experienceText = "{$min} to {$max} years";
        } else {
            $experienceText = "{$experienceRange} years";
        }

        return <<<EOT
            Create a professional and engaging job description for the following position. The description should be comprehensive, well-structured, and highlight the key aspects of the role.

            Position Details:
            - Job Title: {$params['title']}
            - Company: {$params['client']}
            - Experience Required: {$experienceText}
            - Required Skills: {$params['skills']}
            - Education: {$params['education_level']} in {$params['degree']}

            Please structure the description with the following sections:

            1. Job Overview
            - Start with a compelling introduction that captures the essence of the role
            - Highlight the impact and importance of the position within the organization
            - Mention the key responsibilities and expectations

            2. Key Responsibilities
            - List 5-7 specific responsibilities
            - Focus on measurable outcomes and impact
            - Use action verbs and clear, concise language
            - Include both technical and soft skill requirements

            3. Required Qualifications
            - List the essential qualifications and experience
            - Include both technical and educational requirements
            - Specify any certifications or specialized knowledge needed
            - Mention any specific industry experience required

            4. Preferred Qualifications (if applicable)
            - List additional skills or experience that would be beneficial
            - Include any nice-to-have certifications or knowledge

            5. About the Role
            - Describe the work environment and culture
            - Mention any unique aspects of the position
            - Include information about growth opportunities
            - Highlight any benefits or perks specific to this role

            The description should:
            - Be professional and engaging
            - Use clear, concise language
            - Avoid jargon unless necessary
            - Be inclusive and welcoming
            - Focus on the value the candidate will bring
            - Highlight growth and development opportunities
            - Be between 500-800 words
            - Use proper formatting with clear section headers
            - Be free of any placeholders or template text
            EOT;
    }

    /**
     * Refine generated description
     *
     * @param string $rawDescription
     * @return string
     */
    protected function refineDescription(string $rawDescription)
    {
        // Remove the specific introductory line
        $description = preg_replace('/^Here\'s a comprehensive job description for .*? at .*?:/i', '', $rawDescription);

        // Remove any asterisks
        $description = str_replace('*', '', $description);

        // Remove any potential parameter echoing patterns
        $description = preg_replace('/Job Title:.*?(?=\n|$)/i', '', $description);
        $description = preg_replace('/Company Name:.*?(?=\n|$)/i', '', $description);
        $description = preg_replace('/Experience Level:.*?(?=\n|$)/i', '', $description);
        $description = preg_replace('/Skills Required:.*?(?=\n|$)/i', '', $description);
        $description = preg_replace('/Education Level:.*?(?=\n|$)/i', '', $description);

        // Clean up multiple newlines
        $description = preg_replace('/\n{3,}/', "\n\n", $description);

        // Trim any excess whitespace
        return trim($description);
    }
}
