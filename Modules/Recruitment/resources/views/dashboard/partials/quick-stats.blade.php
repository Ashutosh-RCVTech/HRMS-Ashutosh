<div class="bg-white rounded-xl p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-4">Quick Stats</h3>
    <div class="grid grid-cols-2 gap-4">
        @foreach($metrics as $metric)
        {{--
        <x-dashboard.partials.metric-card :metric="$metric" /> --}}
        @endforeach
    </div>
</div>