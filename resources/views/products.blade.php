@extends('app')

@section('content')
@livewire('products-page', ['categoryFilter' => $categoryId ?? null])
@endsection