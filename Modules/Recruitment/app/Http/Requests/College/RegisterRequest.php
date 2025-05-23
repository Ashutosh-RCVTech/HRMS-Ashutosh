<?php

namespace Modules\Recruitment\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\.\']+$/', // Only allows letters, numbers, spaces, hyphens, dots, and apostrophes
                function ($attribute, $value, $fail) {
                    if (preg_match('/<[^>]*>/', $value)) {
                        $fail('The ' . $attribute . ' field contains invalid characters.');
                    }
                }
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns', // Strict email validation including DNS check
                'max:255',
                'unique:colleges',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/' // Requires at least one uppercase, lowercase, number and special character
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^(\+91|0)?[6-9]\d{9}$/' // Indian mobile number format
            ],
            // 'website' => [
            //     'nullable',
            //     'url',
            //     'max:255',
            //     'regex:/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/'
            // ],

            'website' => [
                'nullable',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/',
                function ($attribute, $value, $fail) {
                    // Skip verification if no website provided
                    if (empty($value)) return;

                    // Domain verification
                    $emailDomain = explode('@', $this->input('email'))[1] ?? '';
                    $websiteDomain = parse_url($value, PHP_URL_HOST);

                    // Normalize domains
                    $emailDomain = strtolower(str_replace('www.', '', $emailDomain));
                    $websiteDomain = strtolower(str_replace('www.', '', $websiteDomain));

                    // Check domain match
                    if ($emailDomain && $websiteDomain) {
                        if (str_ends_with($websiteDomain, $emailDomain)) {
                            return; // Domain matches, validation passes
                        }
                    }

                    // Content verification
                    try {
                        $client = new \GuzzleHttp\Client(['timeout' => 10]);
                        $response = $client->get($value, [
                            'headers' => ['User-Agent' => 'CollegeVerificationBot/1.0'],
                            'verify' => config('app.env') === 'production',
                        ]);

                        $content = mb_convert_encoding($response->getBody()->getContents(), 'UTF-8');
                        $collegeName = $this->input('name');

                        // Check for college name in page content
                        if (!preg_match("/\b" . preg_quote($collegeName, '/') . "\b/i", $content)) {
                            $fail('The college name was not found on the provided website.');
                        }

                        // Additional check for educational institution markers
                        $educationKeywords = ['college', 'university', 'institute', 'academy', 'school', 'education'];
                        $foundKeywords = array_filter($educationKeywords, fn($word) => stripos($content, $word) !== false);

                        if (count($foundKeywords) < 2) {
                            $fail('The website does not appear to be an educational institution.');
                        }
                    } catch (\Exception $e) {
                        logger()->error('Website verification failed: ' . $e->getMessage());
                        $fail('Unable to verify website. Please ensure it is accessible and contains your college name.');
                    }
                },
            ],
            'description' => [
                'required',
                'string',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if (preg_match('/<[^>]*>/', $value)) {
                        $fail('The ' . $attribute . ' field contains invalid characters.');
                    }
                }
            ],
            'address' => [
                'required',
                'string',
                'max:500',
                function ($attribute, $value, $fail) {
                    if (preg_match('/<[^>]*>/', $value)) {
                        $fail('The ' . $attribute . ' field contains invalid characters.');
                    }
                }
            ],
            'city' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\-\.]+$/' // Only allows letters, spaces, hyphens, and dots
            ],
            'state' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\-\.]+$/' // Only allows letters, spaces, hyphens, and dots
            ],
            'country' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\-\.]+$/' // Only allows letters, spaces, hyphens, and dots
            ],
            'pincode' => [
                'required',
                'string',
                'max:20',
                'regex:/^[1-9][0-9]{5}$/' // Indian PIN code format
            ],
            'contact_person_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\.\']+$/', // Only allows letters, spaces, hyphens, dots, and apostrophes
                function ($attribute, $value, $fail) {
                    if (preg_match('/<[^>]*>/', $value)) {
                        $fail('The ' . $attribute . ' field contains invalid characters.');
                    }
                }
            ],
            'contact_person_email' => [
                'required',
                'email:rfc,dns', // Strict email validation including DNS check
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'contact_person_phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^(\+91|0)?[6-9]\d{9}$/' // Indian mobile number format
            ],
            'contact_person_designation' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\.\']+$/', // Only allows letters, spaces, hyphens, dots, and apostrophes
                function ($attribute, $value, $fail) {
                    if (preg_match('/<[^>]*>/', $value)) {
                        $fail('The ' . $attribute . ' field contains invalid characters.');
                    }
                }
            ],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'The college name can only contain letters, numbers, spaces, hyphens, dots, and apostrophes.',
            'email.regex' => 'Please enter a valid email address.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'phone.regex' => 'Please enter a valid Indian mobile number.',
            'website.regex' => 'Please enter a valid website URL.',
            'city.regex' => 'The city name can only contain letters, spaces, hyphens, and dots.',
            'state.regex' => 'The state name can only contain letters, spaces, hyphens, and dots.',
            'country.regex' => 'The country name can only contain letters, spaces, hyphens, and dots.',
            'pincode.regex' => 'Please enter a valid Indian PIN code.',
            'contact_person_name.regex' => 'The contact person name can only contain letters, spaces, hyphens, dots, and apostrophes.',
            'contact_person_email.regex' => 'Please enter a valid email address.',
            'contact_person_phone.regex' => 'Please enter a valid Indian mobile number.',
            'contact_person_designation.regex' => 'The designation can only contain letters, spaces, hyphens, dots, and apostrophes.',
        ];
    }
}
