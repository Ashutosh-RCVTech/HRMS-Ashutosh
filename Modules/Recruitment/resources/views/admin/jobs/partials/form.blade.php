<div class="col-span-6 sm:col-span-3">
    <label for="experience_required" class="block text-sm font-medium text-gray-700 dark:text-white">Experience Required</label>
    <select name="experience_required" id="experience_required" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-slate-800 dark:text-white dark:border-gray-700">
        <option value="">Select Experience Range</option>
        @foreach($experienceRanges as $value => $label)
            <option value="{{ $value }}" {{ old('experience_required', $jobOpening->experience_required ?? '') == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('experience_required')
        <p class="mt-2 text-sm text-red-600">Please select experience range</p>
    @enderror
</div> 