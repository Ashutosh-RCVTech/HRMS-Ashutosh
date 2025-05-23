@extends('organization.layout')

@section('title', 'Create New Job Opening')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('jobs.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Job Details -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Job Title</label>
                    <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" x-data @ckeditor="description"></textarea>
                </div>

                <!-- Skills Selector -->
                <div x-data="{ skills: {{ json_encode(old('skills', [])) }}, newSkill: '' }">
                    <label class="block text-sm font-medium text-gray-700">Required Skills</label>
                    <div class="mt-1 flex flex-wrap gap-2">
                        <template x-for="skill in skills">
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 rounded-full text-sm">
                                <span x-text="skill"></span>
                                <button type="button" @click="skills = skills.filter(s => s !== skill)" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                            </span>
                        </template>
                    </div>
                    <div class="mt-2 flex">
                        <input x-model="newSkill" type="text" class="flex-1 rounded-l-md border-gray-300 shadow-sm">
                        <button type="button" @click="if(newSkill.trim()) { skills.push(newSkill.trim()); newSkill = '' }" class="px-4 bg-gray-200 rounded-r-md hover:bg-gray-300">
                            Add
                        </button>
                    </div>
                    <input type="hidden" name="required_skills" :value="JSON.stringify(skills)">
                </div>
            </div>

            <!-- Job Metadata -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Client</label>
                    <select name="client" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Min Salary</label>
                        <input type="number" name="min_salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max Salary</label>
                        <input type="number" name="max_salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Application Deadline</label>
                    <input type="date" name="application_deadline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="draft">Draft</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create Job Opening
            </button>
        </div>
    </form>
</div>
@endsection
