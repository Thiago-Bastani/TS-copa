@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo-main">TS Copa</div>
            <div class="logo-sub" style="text-align:center;letter-spacing:2px;color:#aaa;font-size:.65rem;margin-top:2px">TIME.SYSTEM</div>
        </div>
        <h1 class="auth-title">Criar conta</h1>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="letras, números, _ e -" autocomplete="username" autofocus class="{{ $errors->has('name') ? 'input-error' : '' }}">
                @error('name')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" placeholder="mínimo 6 caracteres" autocomplete="new-password">
                @error('password')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="password_confirmation" placeholder="repita a senha" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label>Chave PIX</label>
                <input type="text" name="pix_key" value="{{ old('pix_key') }}" placeholder="CPF, e-mail, telefone ou chave aleatória">
                @error('pix_key')<div class="error-msg">{{ $message }}</div>@enderror
                <div class="error-msg" style="color:var(--muted);margin-top:.3rem">Será usada para receber o prêmio se você ganhar.</div>
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="margin-top:.5rem">Cadastrar</button>
        </form>

        <div class="auth-footer">
            Já tem conta? <a href="{{ route('login') }}">Entrar</a>
        </div>
    </div>
</div>
@endsection
