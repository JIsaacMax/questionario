@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3 form-check">
                        <input type="checkbox" id="remember" name="remember" class="form-check-input">
                        <label class="form-check-label" for="remember">Lembrar-me</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
