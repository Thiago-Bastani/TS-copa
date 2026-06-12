<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\GameMatch;
use App\Services\PixPayload;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BetController extends Controller
{
    public function index()
    {
        $matches = GameMatch::with(['homeTeam', 'awayTeam'])
            ->orderByDesc('match_date')
            ->get()
            ->map(function ($match) {
                $match->my_bet = $match->bets()->where('user_id', auth()->id())->first();
                return $match;
            });

        return view('matches.index', compact('matches'));
    }

    public function show(GameMatch $match)
    {
        $match->load(['homeTeam', 'awayTeam']);
        $myBet = $match->bets()->where('user_id', auth()->id())->first();

        if ($match->status === 'apostas') {
            // Outros palpites sem scores
            $otherBets = $match->bets()
                ->with('user:id,name')
                ->where('user_id', '!=', auth()->id())
                ->select('id', 'user_id', 'match_id', 'created_at')
                ->get();
        } else {
            $otherBets = $match->bets()
                ->with('user:id,name')
                ->where('user_id', '!=', auth()->id())
                ->get();
        }

        $winners  = collect();
        $qrCodes  = [];
        $perWinner = null;

        if ($match->isFinished()) {
            $winners = $match->winners();
            $count   = $winners->count();
            if ($count > 0 && $match->prize_pool > 0) {
                $perWinner = number_format($match->prize_pool / $count, 2, ',', '.');
                foreach ($winners as $winner) {
                    $amount = round($match->prize_pool / $count, 2);
                    $payload = PixPayload::static($winner->user->pix_key, $amount, 'TS Copa');
                    $qrCodes[$winner->user_id] = (string) QrCode::size(180)->generate($payload);
                }
            }
        }

        return view('matches.show', compact('match', 'myBet', 'otherBets', 'winners', 'qrCodes', 'perWinner'));
    }

    public function store(Request $request, GameMatch $match)
    {
        if (!$match->isOpen()) {
            return back()->with('error', 'Palpites encerrados para esta partida.');
        }

        $request->validate([
            'home_score' => ['required', 'integer', 'min:0', 'max:99'],
            'away_score' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        Bet::updateOrCreate(
            ['user_id' => auth()->id(), 'match_id' => $match->id],
            ['home_score' => $request->home_score, 'away_score' => $request->away_score]
        );

        return back()->with('success', 'Palpite salvo!');
    }
}
