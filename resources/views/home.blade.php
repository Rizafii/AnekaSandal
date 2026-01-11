@extends('app')

@section('content')
<div class="min-h-screen ">
    <!-- Hero Section -->
    @include('partials.hero-section')
    @include('partials.why')

    <!-- Categories Section -->
    @livewire('category-section')

    <!-- Latest Products Section -->
    @include('partials.latest-products', ['products' => $latestProducts])
    @include('partials.map-contact')
</div>
@endsection