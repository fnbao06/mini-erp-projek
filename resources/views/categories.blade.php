@extends('layouts.app')
@section('title', 'Daftar Kategori - ')
@section('header', 'List Kategori')

@section('content')
    @forelse ($category as $cat)
        
    @empty
        
    @endforelse
@endsection