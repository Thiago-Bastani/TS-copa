@extends('layouts.app')

@section('content')
<div style="margin-bottom:1rem"><a href="{{ route('admin.matches.index') }}" style="color:var(--primary);text-decoration:none;font-weight:600">← Voltar</a></div>

<h1 class="page-title">Editar Partida</h1>

@if($errors->any())<div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif

<div class="card" style="max-width:560px">
    <form method="POST" action="{{ route('admin.matches.update', $match) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Time da Casa</label>
            <select name="home_team_id" required>
                <option value="">Selecione</option>
                @foreach($teams as $t)
                    <option value="{{ $t->id }}" {{ $match->home_team_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Time Visitante</label>
            <select name="away_team_id" required>
                <option value="">Selecione</option>
                @foreach($teams as $t)
                    <option value="{{ $t->id }}" {{ $match->away_team_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Data/Hora</label>
            <input type="datetime-local" name="match_date" value="{{ $match->match_date->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="form-group">
            <label>Valor da Aposta (R$)</label>
            <input type="number" name="bet_value" min="0" step="0.01" value="{{ $match->bet_value }}">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Salvar alterações</button>
    </form>
</div>
@endsection
