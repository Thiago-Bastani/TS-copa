<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    protected $table = 'game_matches';

    protected $fillable = [
        'home_team_id', 'away_team_id', 'match_date',
        'home_score', 'away_score', 'prize_pool', 'status',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'datetime',
            'home_score' => 'integer',
            'away_score' => 'integer',
            'prize_pool' => 'decimal:2',
        ];
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function bets()
    {
        return $this->hasMany(Bet::class, 'match_id');
    }

    public function isOpen(): bool
    {
        return $this->status === 'apostas';
    }

    public function isFinished(): bool
    {
        return $this->status === 'finalizado';
    }

    public function winners()
    {
        if (!$this->isFinished()) {
            return collect();
        }
        return $this->bets()
            ->with('user')
            ->where('home_score', $this->home_score)
            ->where('away_score', $this->away_score)
            ->get();
    }
}
