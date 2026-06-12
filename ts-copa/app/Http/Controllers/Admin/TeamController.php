<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public static array $flags = [
        '🇧🇷' => 'Brasil',
        '🇦🇷' => 'Argentina',
        '🇫🇷' => 'França',
        '🇩🇪' => 'Alemanha',
        '🇪🇸' => 'Espanha',
        '🇵🇹' => 'Portugal',
        '🏴󠁧󠁢󠁥󠁮󠁧󠁿' => 'Inglaterra',
        '🇮🇹' => 'Itália',
        '🇳🇱' => 'Holanda',
        '🇧🇪' => 'Bélgica',
        '🇺🇾' => 'Uruguai',
        '🇨🇴' => 'Colômbia',
        '🇨🇱' => 'Chile',
        '🇲🇽' => 'México',
        '🇺🇸' => 'Estados Unidos',
        '🇨🇦' => 'Canadá',
        '🇯🇵' => 'Japão',
        '🇰🇷' => 'Coreia do Sul',
        '🇦🇺' => 'Austrália',
        '🇸🇦' => 'Arábia Saudita',
        '🇲🇦' => 'Marrocos',
        '🇸🇳' => 'Senegal',
        '🇬🇭' => 'Gana',
        '🇳🇬' => 'Nigéria',
        '🇪🇨' => 'Equador',
        '🇵🇱' => 'Polônia',
        '🇨🇭' => 'Suíça',
        '🇩🇰' => 'Dinamarca',
        '🇸🇪' => 'Suécia',
        '🇭🇷' => 'Croácia',
        '🇷🇸' => 'Sérvia',
        '🇹🇳' => 'Tunísia',
        '🇨🇲' => 'Camarões',
    ];

    public function index()
    {
        $teams = Team::orderBy('name')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:80'],
        ]);

        Team::create(['name' => $request->name]);

        return redirect()->route('admin.teams.index')->with('success', 'Time cadastrado!');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Time removido.');
    }
}
