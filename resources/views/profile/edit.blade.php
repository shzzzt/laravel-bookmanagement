@extends('layouts.app')

@section('title', 'Profile - PageTurner')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Profile Settings</h1>
        <p class="text-gray-600 mt-1">Manage your account details and security settings.</p>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
