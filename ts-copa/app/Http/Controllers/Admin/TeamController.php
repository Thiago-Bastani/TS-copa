<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // ISO 3166-1 alpha-2 codes (lowercase) => country name
    public static array $flags = [
        'br' => 'Brasil',
        'ar' => 'Argentina',
        'fr' => 'França',
        'de' => 'Alemanha',
        'es' => 'Espanha',
        'pt' => 'Portugal',
        'gb-eng' => 'Inglaterra',
        'it' => 'Itália',
        'nl' => 'Holanda',
        'be' => 'Bélgica',
        'uy' => 'Uruguai',
        'co' => 'Colômbia',
        'cl' => 'Chile',
        'mx' => 'México',
        'us' => 'Estados Unidos',
        'jp' => 'Japão',
        'kr' => 'Coreia do Sul',
        'au' => 'Austrália',
        'sa' => 'Arábia Saudita',
        'ma' => 'Marrocos',
        'sn' => 'Senegal',
        'gh' => 'Gana',
        'ng' => 'Nigéria',
        'ca' => 'Canadá',
        'ec' => 'Equador',
        'pa' => 'Panamá',
        'cr' => 'Costa Rica',
        'pl' => 'Polônia',
        'ch' => 'Suíça',
        'dk' => 'Dinamarca',
        'se' => 'Suécia',
        'tn' => 'Tunísia',
        'hr' => 'Croácia',
        'rs' => 'Sérvia',
        'cm' => 'Camarões',
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
            'flag' => ['required', 'string'],
        ]);

        Team::create($request->only('name', 'flag'));

        return redirect()->route('admin.teams.index')->with('success', 'Time cadastrado com sucesso!');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Time removido.');
    }
}
