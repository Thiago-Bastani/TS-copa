@extends('layouts.app')

@section('content')
<div class="tabs">
    <a href="{{ route('admin.teams.index') }}" class="tab">Times</a>
    <a href="{{ route('admin.matches.index') }}" class="tab active">Partidas</a>
</div>

<h1 class="page-title">Partidas</h1>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif

<div class="card" style="margin-bottom:1.5rem">
    <h2 style="font-size:1rem;font-weight:700;margin-bottom:1rem">Cadastrar Partida</h2>
    <form method="POST" action="{{ route('admin.matches.store') }}" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end">
        @csrf
        <div class="form-group" style="flex:1;min-width:150px;margin:0">
            <label>Time da Casa</label>
            <select name="home_team_id" required>
                <option value="">Selecione</option>
                @foreach($teams as $t)
                    <option value="{{ $t->id }}" {{ old('home_team_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="flex:1;min-width:150px;margin:0">
            <label>Time Visitante</label>
            <select name="away_team_id" required>
                <option value="">Selecione</option>
                @foreach($teams as $t)
                    <option value="{{ $t->id }}" {{ old('away_team_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="flex:1;min-width:180px;margin:0">
            <label>Data/Hora</label>
            <input type="datetime-local" name="match_date" value="{{ old('match_date') }}" required>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Criar</button>
        </div>
    </form>
</div>

@if($matches->isEmpty())
    <div class="card" style="text-align:center;color:var(--muted)">Nenhuma partida cadastrada.</div>
@else
    @foreach($matches as $match)
    <div class="match-card">
        <div class="match-meta">
            <span class="badge badge-{{ $match->status }}">
                {{ ['apostas'=>'Apostas abertas','em_andamento'=>'Em andamento','finalizado'=>'Finalizado'][$match->status] }}
            </span>
            <span class="match-date">{{ $match->match_date->format('d/m/Y H:i') }}</span>
        </div>

        <div class="match-teams">
            <div class="team-side">                <span class="team-name">{{ $match->homeTeam->name }}</span>
            </div>
            <div class="score-display">
                @if($match->isFinished())
                    <span>{{ $match->home_score }}</span>
                    <span class="score-sep">×</span>
                    <span>{{ $match->away_score }}</span>
                @else
                    <span style="color:var(--muted);font-size:1rem">VS</span>
                @endif
            </div>
            <div class="team-side">                <span class="team-name">{{ $match->awayTeam->name }}</span>
            </div>
        </div>

        <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-top:.75rem">
            @if($match->status === 'apostas')
                <form method="POST" action="{{ route('admin.matches.updateStatus', $match) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="em_andamento">
                    <button class="btn btn-sm btn-warning" type="submit">▶ Iniciar jogo</button>
                </form>
            @endif
            @if($match->status === 'em_andamento')
                <a href="{{ route('admin.matches.result', $match) }}" class="btn btn-sm btn-success">✔ Lançar resultado</a>
            @endif
            <a href="{{ route('matches.show', $match) }}" class="btn btn-sm btn-outline">
                {{ $match->isFinished() ? 'Ver resultado' : 'Ver palpites' }}
            </a>
            <form method="POST" action="{{ route('admin.matches.destroy', $match) }}" onsubmit="return confirm('Remover esta partida?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" type="submit">Remover</button>
            </form>
        </div>
    </div>
    @endforeach
@endif
@endsection
