<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $berita = Berita::paginate(5);
        return view('home.index', compact('user', 'berita'));
    }
    public function detail($slug, $id)
    {
        $user = Auth::user();
        $berita = Berita::findOrFail($id);
        return view('home.detail', compact('user', 'berita'));
    }
}
