@extends('recruitment::college.layouts.app')
@section('content')

<x-college-bulk-import-import-form :placements="$placements" :placement-id="$placementId"/>

@endsection 