<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $matches = GameMatch::with(['homeTeam', 'awayTeam'])->orderByDesc('match_date')->get();
        $teams   = Team::orderBy('name')->get();
        return view('admin.matches.index', compact('matches', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'home_team_id' => ['required', 'exists:teams,id'],
            'away_team_id' => ['required', 'exists:teams,id', 'different:home_team_id'],
            'match_date'   => ['required', 'date'],
            'bet_value'    => ['nullable', 'numeric', 'min:0'],
        ]);

        GameMatch::create([
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'match_date'   => $request->match_date,
            'bet_value'    => $request->bet_value ?: null,
            'status'       => 'apostas',
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Partida cadastrada!');
    }

    public function destroy(GameMatch $match)
    {
        Bet::where('match_id', $match->id)->delete();
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Partida removida.');
    }

    public function editForm(GameMatch $match)
    {
        $teams = Team::orderBy('name')->get();
        return view('admin.matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, GameMatch $match)
    {
        $request->validate([
            'home_team_id' => ['required', 'exists:teams,id'],
            'away_team_id' => ['required', 'exists:teams,id', 'different:home_team_id'],
            'match_date'   => ['required', 'date'],
            'bet_value'    => ['nullable', 'numeric', 'min:0'],
        ]);

        $match->update([
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'match_date'   => $request->match_date,
            'bet_value'    => $request->bet_value ?: null,
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Partida atualizada!');
    }

    public function resultForm(GameMatch $match)
    {
        return view('admin.matches.result', compact('match'));
    }

    public function storeResult(Request $request, GameMatch $match)
    {
        $request->validate([
            'home_score' => ['required', 'integer', 'min:0'],
            'away_score' => ['required', 'integer', 'min:0'],
            'prize_pool' => ['required', 'numeric', 'min:0'],
        ]);

        $match->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'prize_pool' => $request->prize_pool,
            'status'     => 'finalizado',
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Resultado lançado!');
    }

    public function updateStatus(Request $request, GameMatch $match)
    {
        $allowed = ['apostas', 'em_andamento', 'finalizado'];
        $request->validate([
            'status' => ['required', 'in:' . implode(',', $allowed)],
        ]);

        if ($request->status === 'finalizado') {
            return redirect()->route('admin.matches.result', $match);
        }

        $match->update(['status' => $request->status]);

        return redirect()->route('admin.matches.index')->with('success', 'Status atualizado!');
    }
}
