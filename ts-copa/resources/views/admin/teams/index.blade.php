@extends('layouts.app')

@section('content')
<div class="tabs">
    <a href="{{ route('admin.teams.index') }}" class="tab active">Times</a>
    <a href="{{ route('admin.matches.index') }}" class="tab">Partidas</a>
</div>

<h1 class="page-title">Times</h1>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif

<div class="card" style="margin-bottom:1.5rem">
    <h2 style="font-size:1rem;font-weight:700;margin-bottom:1rem">Cadastrar Time</h2>
    <form method="POST" action="{{ route('admin.teams.store') }}" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end">
        @csrf
        <div class="form-group" style="flex:1;min-width:160px;margin:0">
            <label>Nome do time</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex.: Brasil" required>
        </div>
        <div class="form-group" style="flex:1;min-width:180px;margin:0">
            <label>Bandeira</label>
            <select name="flag" required>
                <option value="">Selecione</option>
                @foreach(\App\Http\Controllers\Admin\TeamController::$flags as $code => $country)
                    <option value="{{ $code }}" {{ old('flag') === $code ? 'selected' : '' }}>{{ $country }}</option>
                @endforeach
            </select>
        </div>
        <div style="padding-bottom:.05rem">
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </div>
    </form>
</div>

<div class="card" style="padding:0;overflow:hidden">
    @if($teams->isEmpty())
        <p style="padding:1.5rem;color:var(--muted);text-align:center">Nenhum time cadastrado ainda.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Bandeira</th>
                    <th>Nome</th>
                    <th style="text-align:right">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td style="font-size:1.6rem">{{ $team->flag }}</td>
                    <td style="font-weight:600">{{ $team->name }}</td>
                    <td style="text-align:right">
                        <form method="POST" action="{{ route('admin.teams.destroy', $team) }}" onsubmit="return confirm('Remover {{ $team->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
