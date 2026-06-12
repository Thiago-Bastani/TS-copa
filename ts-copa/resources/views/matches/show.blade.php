@extends('layouts.app')

@section('content')
<div style="margin-bottom:1rem"><a href="{{ route('matches.index') }}" style="color:var(--primary);text-decoration:none;font-weight:600">← Voltar</a></div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

{{-- Match Header Card --}}
<div class="card" style="text-align:center;margin-bottom:1rem">
    <div style="margin-bottom:.5rem">
        <span class="badge badge-{{ $match->status }}">
            {{ ['apostas'=>'Apostas abertas','em_andamento'=>'Em andamento','finalizado'=>'Finalizado'][$match->status] }}
        </span>
        <span class="match-date" style="margin-left:.75rem">{{ $match->match_date->format('d/m/Y \à\s H:i') }}</span>
        @if($match->bet_value)
            <div style="margin-top:.4rem;font-size:.85rem;font-weight:700;color:var(--primary)">Valor da aposta: R$ {{ number_format($match->bet_value, 2, ',', '.') }}</div>
        @endif
    </div>

    <div class="match-teams" style="margin:.75rem 0">
        <div class="team-side">            <span class="team-name" style="font-size:1rem">{{ $match->homeTeam->name }}</span>
        </div>
        <div class="score-display" style="font-size:2.2rem">
            @if($match->isFinished())
                <span>{{ $match->home_score }}</span>
                <span class="score-sep">×</span>
                <span>{{ $match->away_score }}</span>
            @else
                <span style="color:var(--muted);font-size:1.1rem">VS</span>
            @endif
        </div>
        <div class="team-side">            <span class="team-name" style="font-size:1rem">{{ $match->awayTeam->name }}</span>
        </div>
    </div>
</div>

{{-- Bet form (only when status = apostas) --}}
@if($match->isOpen())
<div class="card" style="margin-bottom:1rem">
    <h2 style="font-size:1rem;font-weight:800;margin-bottom:1rem;text-align:center">
        {{ $myBet ? 'Alterar palpite' : 'Faça seu palpite!' }}
    </h2>
    <p style="text-align:center;font-size:.82rem;color:var(--muted);margin-bottom:1rem">Palpites abertos até o início da partida.</p>
    <form method="POST" action="{{ route('matches.bet', $match) }}">
        @csrf
        <div style="display:flex;align-items:center;justify-content:center;gap:1.5rem;margin-bottom:1.25rem">
            <div style="text-align:center">
                <div style="font-size:.75rem;font-weight:700;color:var(--muted);margin-bottom:.4rem">{{ $match->homeTeam->name }}</div>
                <input type="number" name="home_score" class="score-input {{ $errors->has('home_score') ? 'input-error' : '' }}"
                    min="0" max="99" value="{{ old('home_score', $myBet?->home_score ?? '') }}" placeholder="0" required>
            </div>
            <span style="font-size:1.5rem;font-weight:900;color:var(--muted);padding-top:1.2rem">×</span>
            <div style="text-align:center">
                <div style="font-size:.75rem;font-weight:700;color:var(--muted);margin-bottom:.4rem">{{ $match->awayTeam->name }}</div>
                <input type="number" name="away_score" class="score-input {{ $errors->has('away_score') ? 'input-error' : '' }}"
                    min="0" max="99" value="{{ old('away_score', $myBet?->away_score ?? '') }}" placeholder="0" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">{{ $myBet ? 'Atualizar palpite' : 'Salvar palpite' }}</button>
    </form>
</div>
@elseif($myBet)
<div class="card" style="margin-bottom:1rem;border-color:var(--primary)">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem">
        <span style="font-weight:700;font-size:.9rem">Meu palpite</span>
        <span style="font-size:1.4rem;font-weight:900;color:var(--primary)">{{ $myBet->home_score }} × {{ $myBet->away_score }}</span>
        @if($match->isFinished())
            @if($myBet->home_score == $match->home_score && $myBet->away_score == $match->away_score)
                <span class="badge" style="background:#e8f5e9;color:var(--success)">ACERTOU!</span>
            @else
                <span class="badge" style="background:#fdecea;color:var(--error)">Errou</span>
            @endif
        @endif
    </div>
</div>
@endif

{{-- Bets list --}}
<div class="card">
    <h3 style="font-size:.95rem;font-weight:800;margin-bottom:1rem">
        Palpites
        @php $total = ($myBet ? 1 : 0) + $otherBets->count(); @endphp
        <span style="background:var(--primary);color:#fff;font-size:.7rem;padding:2px 8px;border-radius:20px;margin-left:.4rem">{{ $total }}</span>
    </h3>

    @if($total === 0)
        <p style="color:var(--muted);text-align:center;font-size:.9rem">Nenhum palpite ainda.</p>
    @else
        <div class="bets-list">
            {{-- Own bet first --}}
            @if($myBet)
            <div class="bet-item my-bet">
                <span class="bet-name">{{ auth()->user()->name }} <span style="font-size:.75rem;color:var(--primary)">(você)</span></span>
                <span class="bet-score">{{ $myBet->home_score }} × {{ $myBet->away_score }}</span>
            </div>
            @endif

            {{-- Others --}}
            @foreach($otherBets as $bet)
            <div class="bet-item {{ $match->isFinished() && $bet->home_score == $match->home_score && $bet->away_score == $match->away_score ? 'winner' : '' }}">
                <span class="bet-name">{{ $bet->user->name }}</span>
                @if($match->status === 'apostas')
                    <span class="bet-score blurred" aria-hidden="true">?×?</span>
                @else
                    <span class="bet-score">{{ $bet->home_score }} × {{ $bet->away_score }}</span>
                @endif
            </div>
            @endforeach
        </div>

        @if($match->status === 'apostas')
            <p style="text-align:center;font-size:.78rem;color:var(--muted);margin-top:.75rem">Os palpites serão revelados quando o jogo começar.</p>
        @endif
    @endif
</div>

{{-- Winners section --}}
@if($match->isFinished() && $winners->count() > 0)
<div class="winners-section">
    <div class="winners-title">🏆 Ganhadores — R$ {{ $perWinner }} cada</div>
    @foreach($winners as $winner)
    <div class="winner-card">
        <div>
            <div class="winner-name">{{ $winner->user->name }}</div>
            <div class="winner-pix">Chave PIX: {{ $winner->user->pix_key }}</div>
        </div>
        <div class="winner-amount">R$ {{ $perWinner }}</div>
        @if(isset($qrCodes[$winner->user_id]))
        <div class="qr-wrap">
            {!! $qrCodes[$winner->user_id] !!}
        </div>
        @endif
    </div>
    @endforeach
</div>
@elseif($match->isFinished() && $winners->count() === 0)
<div class="card" style="text-align:center;color:var(--muted);margin-top:1rem">
    Nenhum participante acertou o placar exato.
</div>
@endif
@endsection
