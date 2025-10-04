@extends('layouts.app')

@section('title', 'Verification Successful')

@section('content')
<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h2>Verification Successful!</h2>
        <p>Your account has been successfully verified.</p>
        <a href="{{ route('welcome') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
    </div>
</div>
@endsection