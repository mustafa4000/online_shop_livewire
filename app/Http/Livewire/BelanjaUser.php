<?php

namespace App\Http\Livewire;

use App\Models\Belanja;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BelanjaUser extends Component
{
    public $belanja = [];

    public function mount()
    {
        // autentifikasi
        if (!Auth::user()) {
            return redirect()->route('login');
        }
    }

    public function destroy($pesanan_id) {
        $pesanan = Belanja::find($pesanan_id);
        $pesanan->delete();
    }

    public function render()
    {
        if (Auth::user()) {
            $this->belanja = Belanja::where('user_id', Auth::user()->id)->get();
        }

        return view('livewire.belanja-user')->extends('layouts.app')->section('content');
    }
}
