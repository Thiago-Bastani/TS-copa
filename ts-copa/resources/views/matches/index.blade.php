@extends('layouts.app')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.5rem">
    <h1 class="page-title" style="margin:0">Partidas</h1>
    <span style="font-size:.85rem;color:var(--muted)">Olá, <strong>{{ auth()->user()->name }}</strong></span>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

@if($matches->isEmpty())
    <div class="card" style="text-align:center;color:var(--muted);padding:2rem">Nenhuma partida disponível ainda.</div>
@else
    @foreach($matches as $match)
    <a href="{{ route('matches.show', $match) }}" style="text-decoration:none;color:inherit">
        <div class="match-card">
            <div class="match-meta">
                <span class="badge badge-{{ $match->status }}">
                    {{ ['apostas'=>'Apostas abertas','em_andamento'=>'Em andamento','finalizado'=>'Finalizado'][$match->status] }}
                </span>
                <span class="match-date">{{ $match->match_date->format('d/m/Y H:i') }}</span>
            </div>

            <div class="match-teams">
                <div class="team-side">
                    <span class="team-flag">{{ $match->homeTeam->flag }}</span>
                    <span class="team-name">{{ $match->homeTeam->name }}</span>
                </div>
                <div class="score-display">
                    @if($match->isFinished())
                        <span>{{ $match->home_score }}</span>
                        <span class="score-sep">×</span>
                        <span>{{ $match->away_score }}</span>
                    @elseif($match->my_bet)
                        <span style="font-size:.9rem;color:var(--primary);font-weight:700">{{ $match->my_bet->home_score }}×{{ $match->my_bet->away_score }}</span>
                    @else
                        <span style="color:var(--muted);font-size:1rem">VS</span>
                    @endif
                </div>
                <div class="team-side">
                    <span class="team-flag">{{ $match->awayTeam->flag }}</span>
                    <span class="team-name">{{ $match->awayTeam->name }}</span>
                </div>
            </div>

            @if($match->my_bet && !$match->isFinished())
                <div style="text-align:center;font-size:.8rem;color:var(--success);font-weight:600;margin-top:.25rem">✔ Palpite enviado</div>
            @elseif(!$match->my_bet && $match->isOpen())
                <div style="text-align:center;font-size:.8rem;color:var(--primary);font-weight:600;margin-top:.25rem">Clique para apostar</div>
            @endif
        </div>
    </a>
    @endforeach
@endif
@endsection
