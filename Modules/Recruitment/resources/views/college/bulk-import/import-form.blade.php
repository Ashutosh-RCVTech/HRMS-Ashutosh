@props(['quizzes'])
{{-- {{dd($placements,$placementId)}} --}}
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Import Candidates For {{ $placements->name }}</h1>
        <p class="mt-2 text-sm text-gray-600">Upload an Excel file containing candidate information to assign them to a
            quiz.</p>
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form id="importForm" action="{{ route('college.import.submit') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            <input type="hidden" name="placement_id" value="{{ $placementId }}" />
            <!-- Custom Quiz Selection -->
            {{-- <div class="relative">
                <label for="quiz_search" class="block text-sm font-medium text-gray-700">Select Quiz</label>
                <div class="mt-1 relative">
                    <input type="text" 
                           id="quiz_search" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Search for a quiz..."
                           autocomplete="off">
                    <input type="hidden" name="quiz_id" id="quiz_id">
                    
                    <!-- Dropdown Arrow -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div id="quiz_dropdown" class="hidden absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md max-h-60 overflow-auto">
                        <div class="py-1">
                            <div id="quiz_list" class="divide-y divide-gray-100">
                            </div>
                            <div id="loading_more" class="hidden px-4 py-2 text-center text-gray-500">
                                Loading more...
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- File Upload -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700">Excel File</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="file"
                                class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span id="uploadLabel">Upload a file</span>
                                <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls"
                                    required>
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>

                        <p class="text-xs text-gray-500">Excel files only (.xlsx, .xls)</p>
                    </div>
                </div>
            </div>
            <a href="{{ asset('build/assets/candidate_placement.xlsx') }}" download="candidate_placement.xlsx"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                <!-- Heroicon: download -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>

                Download Sample
            </a>


            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Import Candidates
                </button>
            </div>
        </form>
    </div>

    <!-- Results Section (Initially Hidden) -->
    <div id="resultsSection" class="hidden bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Import Results</h2>

        <!-- Progress Bar -->
        <div class="mb-4 hidden">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-700">Processing</span>
                <span class="text-sm font-medium text-gray-700" id="progressText">0%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div id="progressBar" class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="grid grid-cols-3 gap-4 mb-6 hidden">
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm text-green-600">Successfully Processed</p>
                <p class="text-2xl font-bold text-green-700" id="successCount">0</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
                <p class="text-sm text-red-600">Failed</p>
                <p class="text-2xl font-bold text-red-700" id="errorCount">0</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-blue-600">Total Records</p>
                <p class="text-2xl font-bold text-blue-700" id="totalCount">0</p>
            </div>
        </div>

        <!-- Error Details -->
        <div id="errorDetails" class="hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Error Details</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Row</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Error</th>
                        </tr>
                    </thead>
                    <tbody id="errorTableBody" class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {


        const form = document.getElementById('importForm');
        const resultsSection = document.getElementById('resultsSection');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const successCount = document.getElementById('successCount');
        const errorCount = document.getElementById('errorCount');
        const totalCount = document.getElementById('totalCount');
        const errorDetails = document.getElementById('errorDetails');
        const errorTableBody = document.getElementById('errorTableBody');
        const importButton = form.querySelector('button[type="submit"]');
        let eventSource = null;

        const fileInput = document.getElementById('file');
        const uploadLabel = document.getElementById('uploadLabel');

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                // Update the label text with the selected file name
                uploadLabel.textContent = fileInput.files[0].name;
            } else {
                // Reset to default text if no file is selected
                uploadLabel.textContent = 'Upload a file';
            }
        });


        form.addEventListener('submit', function(e) {
            e.preventDefault();


            importButton.disabled = true;
            importButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;

            const formData = new FormData(form);

            // Show results section
            resultsSection.classList.remove('hidden');

            // Reset progress
            progressBar.style.width = '0%';
            progressText.textContent = '0%';
            successCount.textContent = '0';
            errorCount.textContent = '0';
            totalCount.textContent = '0';
            errorTableBody.innerHTML = '';
            errorDetails.classList.add('hidden');



            // Start the import process
            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {

                    if (!data.success && data.errors) {
                        console.log('Error processing import:', data.errors);
                        // Populate error table
                        errorTableBody.innerHTML = ''; // Clear previous errors
                        data.errors.forEach(err => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                        <td class="px-6 py-3 text-sm bg-red-500 text-white">${err.row}</td>
                        <td class="px-6 py-3 text-sm bg-red-500 text-white">${err.error}</td>
                    `;
                            errorTableBody.appendChild(tr);
                        });
                        errorDetails.classList.remove('hidden');
                    } else {
                        // Show a toaster success message using toastr
                        toastr.success(`${data.message} Total records: ${data.total}`, "Success");
                    }
                    // Re-enable the button and reset the text
                    importButton.disabled = false;
                    importButton.innerHTML = `Import Candidates`;
                })
                .catch(error => {
                    console.error('Error processing import:', error);
                    toastr.error('An error occurred during import. Please try again.', "Error");
                    importButton.disabled = false;
                    importButton.innerHTML = `Import Candidates`;
                });

            // Add timeout handling
            setTimeout(() => {
                if (eventSource && eventSource.readyState !== EventSource.CLOSED) {
                    eventSource.close();
                    importButton.disabled = false;
                    importButton.innerHTML = 'Import Candidates';
                    alert('Import process timed out. Please try again.');
                    resultsSection.classList.add('hidden');
                }
            }, 300000); // 5 minutes timeout
        });
    });
</script>
