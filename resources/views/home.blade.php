@extends('app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Hero Section -->
        @include('partials.hero-section')
        @include('partials.why')

        <!-- Categories Section -->
        @livewire('category-section')

        <!-- Latest Products Section -->
        @include('partials.latest-products')
        @include('partials.map-contact')
    </div>
@endsection