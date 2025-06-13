@extends('layouts.dashboard', ['title' => 'Accueil - TABLEAU DE BORD'])

@section('content')
    <div class="row ">

        {{-- <div class="col">
            <div class="card lift">
                <div class="card-body py-xl-4 py-3">
                    <span class="text-muted">Total Montant </span>
                    <div><span class="fs-3 me-2"> {{ number_format($paiImpay, 0, ',', ' ') }}</span> F CFA</span></div>

                </div>
            </div>
        </div> --}}
        <div class="col-4">
            <div class="card lift">
                <div class="card-body py-xl-4 py-3">
                    <span class="text-muted">Total Montant Payer</span>
                    <div><span class="fs-3 me-2"> {{ number_format($paiValid, 0, ',', ' ') }}</span> F CFA</span></div>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card lift">
                <div class="card-body py-xl-4 py-3">
                    <span class="text-muted"> Nombre d'Entreprise</span>
                    <div><span class="fs-3 me-2"> {{ ($nbreEntre ?? "0") }}</span> </span></div>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card lift">
                <div class="card-body py-xl-4 py-3">
                    <span class="text-muted">Cheque ou virement en Attente</span>
                    <div><span class="fs-3 me-2"> {{ ($virement ?? "0") }}</span> </span></div>

                </div>
            </div>
        </div>
    </div> <!-- .row end -->
@endsection
