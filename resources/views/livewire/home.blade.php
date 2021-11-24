<div class="container">
    @if (Auth::user())
        @if (Auth::user()->level == 1)
        <div class="col-md-3">
            <a href="{{ url('TambahProduk') }}" class="btn btn-success btn">Tambah Produk</a>
        </div>
        @endif
    @endif

    <br>
    {{-- mempuat  input search  --}}
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" wire:model="search" type="text" class="form control" placeholder="Search ..." aria-label="Search" arial-describedby="basic-addon1">
            </div>

            <div class="input-group mb-3">
                <input type="text" wire:model="min" type="text" class="form control" placeholder="Harga min ..." aria-label="harga_min" arial-describedby="basic-addon1">
            </div>

            <div class="input-group mb-3">
                <input type="text" wire:model="max" type="text" class="form control" placeholder="Harga max ..." aria-label="harga_max" arial-describedby="basic-addon1">
            </div>

        </div>
    </div>


    {{-- untuk menampilkan data mobil sedan --}}
    <section class="products mb-5">
        <div class="row mt-4">
            @foreach ($products as $product)
                <div class="col-md-3 md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ asset('storage/photos/'.$product->gambar) }}" width="200px" height="220px" alt="">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h5><strong>{{ $product->nama }}</strong></h5>
                                    <h6><strong>Rp. {{ number_format($product->harga) }}</strong></h6>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button class="btn btn-success btn-block" wire:click="beli({{ $product->id }})"> Beli </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
