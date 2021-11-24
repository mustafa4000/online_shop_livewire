<?php

namespace App\Http\Livewire;

use App\Models\Belanja;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public $products = [];
    
    // kita bikin atributnya filteringnya
    public $search,$min,$max;
    
    public function beli($id)
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        // mencari produk / mengambil data produk
        $produk = Produk::find($id);

        Belanja::create(
            [
                'user_id'        => Auth::user()->id,
                'total_harga'   => $produk->harga,
                'produk_id'     => $produk->id,
                'status'        => 0
            ]
        );

        return redirect()->to('BelanjaUser');
    }

    // untuk di home.blade
    public function render()
    {
        // filter harga max
        if ($this->max) {
            $harga_max = $this->max;
        } else {
            $harga_max = 5000000;
        }

        // filter harga minimal
        if ($this->min) {
            $harga_min = $this->min;
        } else {
            $harga_min = 0;
        }

        // kita buat kondisi if  search
        if ($this->search) {
            $this->products = Produk::where('nama','like','%'.$this->search.'%')->where('harga','>=',$harga_min)->where('harga','<=',$harga_max)->get();
        } else {
            $this->products = Produk::where('harga','>=',$harga_min)->where('harga','<=',$harga_max)->get();
        }

        return view('livewire.home')->extends('layouts.app')->section('content');
    }
}
