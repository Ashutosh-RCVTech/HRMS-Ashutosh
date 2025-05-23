@extends('layouts.admin')

@section('title', 'Client Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Client Details</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Client
                            </a>
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center mb-4">
                                @if ($client->client_logo_path)
                                    <img src="{{ asset($client->client_logo_path) }}" alt="{{ $client->name }}"
                                        class="img-fluid rounded" style="max-height: 150px;">
                                @else
                                    <div class="bg-light rounded p-4">
                                        <i class="fas fa-building fa-4x text-muted"></i>
                                        <p class="mt-2 text-muted">No logo available</p>
                                    </div>
                                @endif

                                @if ($client->banner_image_path)
                                    <div class="mt-3">
                                        <img src="{{ asset($client->banner_image_path) }}" alt="{{ $client->name }} Banner"
                                            class="img-fluid rounded">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="border-bottom pb-2">Basic Information</h4>
                                        <table class="table table-sm">
                                            <tr>
                                                <th style="width: 30%">Company Name:</th>
                                                <td>{{ $client->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Company Type:</th>
                                                <td>{{ ucfirst($client->company_type) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Industry:</th>
                                                <td>{{ $client->industry }}</td>
                                            </tr>
                                            <tr>
                                                <th>Website:</th>
                                                <td>
                                                    @if ($client->website_url)
                                                        <a href="{{ $client->website_url }}"
                                                            target="_blank">{{ $client->website_url }}</a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Description:</th>
                                                <td>{{ $client->description ?: 'No description provided' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <h4 class="border-bottom pb-2">Contact Information</h4>
                                        <table class="table table-sm">
                                            <tr>
                                                <th style="width: 30%">Contact Person:</th>
                                                <td>
                                                    @if ($client->contact_person_name)
                                                        {{ $client->contact_person_name }}
                                                        @if ($client->contact_person_position)
                                                            <br><small
                                                                class="text-muted">{{ $client->contact_person_position }}</small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td>
                                                    @if ($client->contact_email)
                                                        <a
                                                            href="mailto:{{ $client->contact_email }}">{{ $client->contact_email }}</a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Phone:</th>
                                                <td>
                                                    @if ($client->contact_phone)
                                                        <a
                                                            href="tel:{{ $client->contact_phone }}">{{ $client->contact_phone }}</a>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Address:</th>
                                                <td>{{ $client->address ?: 'Not provided' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h4 class="border-bottom pb-2">Subscription Information</h4>
                                        <table class="table table-sm">
                                            <tr>
                                                <th style="width: 30%">Subscription Tier:</th>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $client->subscription_tier == 3 ? 'success' : ($client->subscription_tier == 2 ? 'info' : 'secondary') }}">
                                                        {{ $client->subscription_tier == 1 ? 'Basic' : ($client->subscription_tier == 2 ? 'Premium' : 'Enterprise') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Expiry Date:</th>
                                                <td>
                                                    @if ($client->subscription_expiry)
                                                        {{ \Carbon\Carbon::parse($client->subscription_expiry)->format('M d, Y') }}
                                                    @else
                                                        <span class="text-muted">Not set</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <h4 class="border-bottom pb-2">Status</h4>
                                        <table class="table table-sm">
                                            <tr>
                                                <th style="width: 30%">Active:</th>
                                                <td>
                                                    @if ($client->is_active)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Featured:</th>
                                                <td>
                                                    @if ($client->is_featured)
                                                        <span class="badge badge-warning">Featured</span>
                                                    @else
                                                        <span class="badge badge-secondary">Not Featured</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created:</th>
                                                <td>{{ $client->created_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Last Updated:</th>
                                                <td>{{ $client->updated_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
