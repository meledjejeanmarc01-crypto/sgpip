@extends('layouts.app')
@section('title', 'Nouvel utilisateur - SGSPIP')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-person-plus"></i> Nouvel utilisateur</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                @include('users.form', ['user' => null, 'roles' => $roles, 'structures' => $structures])
            </form>
        </div>
    </div>
</div>
@endsection
