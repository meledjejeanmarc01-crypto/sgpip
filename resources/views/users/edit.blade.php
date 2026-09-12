@extends('layouts.app')
@section('title', 'Modifier utilisateur - SGSPIP')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-person-gear"></i> Modifier : {{ $user->name }}</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')
                @include('users.form', ['user' => $user, 'roles' => $roles, 'structures' => $structures])
            </form>
        </div>
    </div>
</div>
@endsection
