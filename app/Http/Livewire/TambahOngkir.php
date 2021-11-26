<?php

namespace App\Http\Livewire;

use App\Models\Belanja;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
// PHP Native
use Kavist\RajaOngkir\RajaOngkir;

class TambahOngkir extends Component
{
    private $apikey = 'bd6e9149081764575ea0ec7591b6cb73';
    public $belanja;
    public $provinsi_id, $kota_id, $jasa, $daftarProvinsi, $daftarKota , $nama_jasa;
    public $result = [];
    public function mount($id)
    {
        if (!Auth::user()) {
            return redirect()->route('login'); 
        }
        $this->belanja = Belanja::find($id);

        // if ($this->belanja->user_id != Auth::user()) {
        //     return redirect()->to('');
        // }
    }

    public function getOngkir()
    {
        // validasi
        if (!$this->provinsi_id || !$this->kota_id || !$this->jasa) {
            return;
        }

        // mengambil data produk
        $produk = Produk::find($this->belanja->produk_id);
        
        // mengambil biaya ongkir
        $rajaOngkir = new RajaOngkir($this->apikey);
        $cost       = $rajaOngkir->ongkosKirim([            
            'origin' 		=> 489, // id tuban
            'destination' 	=> $this->kota_id, // id kota tujuan
            'weight' 		=> $produk->berat, // berat satuan gram
            'courier' 		=> $this->jasa, // kode kurir pengantar ( jne / tiki / pos )
        ])->get();

        // pengecekan
        // dd($cost);

        // nama jasa
        // $this->nama_jasa = $cost[0]['name'];
        // dd($this->nama_jasa);
        // foreach ($cost[0]['costs'] as $row) 
        // {
        //     $this->result[] = array(
        //         'description'   => $row['description'],
        //         'biaya'         => $row['cost'][0]['value'],
        //         'etd'           => $row['cost'][0]['etd']
        //     );
        // }
    }

    public function save_ongkir($biaya_pengiriman)
    {
        $this->belanja->total_harga += $biaya_pengiriman;
        $this->belanja->status = 1;
        $this->belanja->update();

        // redirect ke belanja 
        return redirect()->to('BelanjaUser');
    }

    public function render()
    {
        // $rajaOngkir = new RajaOngkir($this->apikey);
        // $biaya = $rajaOngkir->ongkosKirim([
        //     'origin'        => 155,     // ID kota/kabupaten asal
        //     'destination'   => 80,      // ID kota/kabupaten tujuan
        //     'weight'        => 1300,    // berat barang dalam gram
        //     'courier'       => 'jne'    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        // ]);
        // dd($biaya);

        // $rajaOngkir = new RajaOngkir($this->apikey);
        // $daftarProvinsi = $rajaOngkir->provinsi()->all();
        // dd($daftarProvinsi);
        
        // $daftarProvinsi = RajaOngkir::provinsi()->all();
        // dd($daftarProvinsi);

        $rajaOngkir = new RajaOngkir($this->apikey);
        $this->daftarProvinsi = $rajaOngkir->provinsi()->all();
        // dd($this->daftarProvinsi);
        
        // $this->provinsi_id = 3;

        if ($this->provinsi_id) {
            $this->daftarKota = $rajaOngkir->kota()->dariProvinsi($this->provinsi_id)->get();
            // dd($this->daftarKota);
        }

        return view('livewire.tambah-ongkir')->extends('layouts.app')->section('content');
    }
}
