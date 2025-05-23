@extends('recruitment::candidate.layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="container mx-auto bg-white rounded-lg shadow-md p-6 dark:bg-slate-900">
            <!-- Main Content -->
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Profile</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-white">Update your profile information to make it easier
                        for employers to find you.</p>
                </div>

                <!-- Tabs -->
                <div class="mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="flex flex-wrap space-x-1 sm:space-x-8" aria-label="Tabs">
                            <button
                                class="tab-button {{ !$sectionCompletion['basic'] ? 'text-red-600 border-red-500' : 'border-indigo-500 text-indigo-600' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                data-tab="basic-details">
                                Basic Details @if(!$sectionCompletion['basic']) <span class="text-red-600">(Required)</span> @endif
                            </button>
                            <button
                                class="tab-button {{ !$sectionCompletion['education'] ? 'text-red-600 border-red-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                data-tab="education">
                                Education @if(!$sectionCompletion['education']) <span class="text-red-600">(Required)</span> @endif
                            </button>
                            <button
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                data-tab="employment">
                                Employment
                            </button>
                            <button
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                data-tab="career-profile">
                                Career Profile
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div class="tab-content" id="basic-details">
                    @include('recruitment::candidate.profile.partials.basic-details')
                </div>
                <div class="tab-content hidden" id="education">
                    @include('recruitment::candidate.profile.partials.education')
                </div>
                <div class="tab-content hidden" id="employment">
                    @include('recruitment::candidate.profile.partials.employment')
                </div>
                <div class="tab-content hidden" id="career-profile">
                    @include('recruitment::candidate.profile.partials.career-profile')
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', () => {
                    // Update tab buttons
                    document.querySelectorAll('.tab-button').forEach(btn => {
                        // Check if this is a required incomplete section
                        let isRequired = btn.innerHTML.includes('(Required)');

                        btn.classList.remove('border-indigo-500', 'text-indigo-600');

                        if (isRequired) {
                            btn.classList.add('border-red-500', 'text-red-600');
                        } else {
                            btn.classList.add('border-transparent', 'text-gray-500');
                        }
                    });

                    // Check if this button is a required incomplete section
                    let isRequired = button.innerHTML.includes('(Required)');

                    button.classList.remove('border-transparent', 'text-gray-500', 'border-red-500',
                        'text-red-600');

                    if (isRequired) {
                        button.classList.add('border-red-500', 'text-red-600');
                    } else {
                        button.classList.add('border-indigo-500', 'text-indigo-600');
                    }

                    // Show corresponding content
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(button.dataset.tab).classList.remove('hidden');
                });
            });

            // Check for incomplete profile sections using sectionCompletion
            let incompleteMessage = '';
            @if(!$sectionCompletion['basic'])
                incompleteMessage += 'Basic Details, ';
            @endif
            @if(!$sectionCompletion['education'])
                incompleteMessage += 'Education, ';
            @endif
            if (incompleteMessage) {
                incompleteMessage = incompleteMessage.slice(0, -2); // Remove trailing comma and space
                toastr.warning('You must complete the following sections: ' + incompleteMessage,
                    'Profile Incomplete', {
                        "timeOut": "10000",
                        "extendedTimeOut": "5000",
                        "closeButton": true,
                        "tapToDismiss": false,
                        "preventDuplicates": true
                    });
            }
        });
    </script>
@endsection
