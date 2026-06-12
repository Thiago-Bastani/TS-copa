@extends('layouts.app')

@section('content')
<div style="margin-bottom:1rem"><a href="{{ route('admin.matches.index') }}" style="color:var(--primary);text-decoration:none;font-weight:600">← Voltar</a></div>

<h1 class="page-title">Lançar Resultado</h1>

@if($errors->any())<div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif

<div class="card" style="max-width:480px">
    <div class="match-teams" style="margin-bottom:1.25rem">
        <div class="team-side">            <span class="team-name">{{ $match->homeTeam->name }}</span>
        </div>
        <span style="font-size:1.1rem;color:var(--muted);font-weight:700">VS</span>
        <div class="team-side">            <span class="team-name">{{ $match->awayTeam->name }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.matches.storeResult', $match) }}">
        @csrf
        <div class="form-group">
            <label>Placar Final</label>
            <div class="score-inputs">
                <input type="number" name="home_score" class="score-input" min="0" max="99" value="{{ old('home_score', 0) }}" required>
                <span style="font-size:1.4rem;font-weight:900;color:var(--muted)">×</span>
                <input type="number" name="away_score" class="score-input" min="0" max="99" value="{{ old('away_score', 0) }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Valor do Prêmio (R$)</label>
            <input type="number" name="prize_pool" min="0" step="0.01" value="{{ old('prize_pool', '0.00') }}" required>
            <div class="error-msg" style="color:var(--muted);margin-top:.3rem">Dividido entre os ganhadores com palpite exato.</div>
        </div>
        <button type="submit" class="btn btn-success btn-block">Confirmar Resultado</button>
    </form>
</div>
@endsection
