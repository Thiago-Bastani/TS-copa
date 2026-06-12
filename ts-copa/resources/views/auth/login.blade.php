@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo-main">TS Copa</div>
            <div class="logo-sub" style="text-align:center;letter-spacing:2px;color:#aaa;font-size:.65rem;margin-top:2px">TIME.SYSTEM</div>
        </div>
        <h1 class="auth-title">Entrar no bolão</h1>

        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="seu_usuario" autocomplete="username" autofocus class="{{ $errors->has('name') ? 'input-error' : '' }}">
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" placeholder="••••••" autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="margin-top:.5rem">Entrar</button>
        </form>

        <div class="auth-footer">
            Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
        </div>
    </div>
</div>
@endsection
