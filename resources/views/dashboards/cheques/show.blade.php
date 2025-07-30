@extends('layouts.dashboard', ['title' => 'Détails du chèque'])
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/cssbundle/dataTables.min.css') }}">
@endpush

@section('content')
    <div class="row g-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <h5>Erreurs lors de la validation :</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title m-0">
                        Détails @if ($cheque->NaturePaiement == 'ESPECE')
                            de
                        @else
                            du
                        @endif
                        <span class="text-lowercase">
                            {{ $cheque->NaturePaiement ?? 'xxxxxxx' }}
                        </span>
                    </h6>
                    <span
                        class="badge bg-{{ $cheque->status == 1 ? 'success' : ($cheque->status == 2 ? 'warning' : 'danger') }}">
                        {{ $cheque->status == 1 ? 'Validé' : ($cheque->status == 2 ? 'En attente' : 'Rejeté') }}
                    </span>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Aggrandi"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{ route('listCheques') }}" class="btn btn-primary d-inline">Retour</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Informations sur le chèque -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 text-uppercase">Informations @if ($cheque->NaturePaiement == 'ESPECE')
                                            de
                                        @else
                                            du
                                        @endif
                                        {{ $cheque->NaturePaiement ?? 'xxxxxxx' }}</h5>
                                </div>
                                <div class="card-body">
                                    @if (!empty($cheque->taxe_entreprise_id))
                                        <div class="mb-3">
                                            <h6>Libelle</h6>
                                            <p class="fs-5">
                                                {{ $cheque->taxeEntreprise->periode ?? 'Non renseigné' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6>Localisation</h6>
                                            <p class="fs-5">{{ $cheque->taxeEntreprise->localisation ?? 'Non renseigné' }}
                                            </p>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <h6>
                                            @if ($cheque->NaturePaiement == 'ESPECE')
                                                Réference
                                            @else
                                                Numéro
                                            @endif
                                            de <span
                                                class="text-lowercase">{{ $cheque->NaturePaiement ?? 'xxxxxxx' }}</span>
                                        </h6>
                                        <p class="fs-5">{{ $cheque->numero_cheque ?? 'Non renseigné' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6>Montant</h6>
                                        <p class="fs-5 text-primary fw-bold">
                                            {{ number_format($cheque->montant, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                    @if (!empty($cheque->banque))
                                        <div class="mb-3">
                                            <h6>Banque</h6>
                                            <p class="fs-5">{{ $cheque->banque ?? 'Non renseigné' }}</p>
                                        </div>
                                    @endif
                                    @if (!empty($cheque->titulaire))
                                        <div class="mb-3">
                                            <h6>Titulaire</h6>
                                            <p class="fs-5">{{ $cheque->titulaire ?? 'Non renseigné' }}</p>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <h6>Date d'émission</h6>
                                        <p class="fs-5">
                                            {{ \Carbon\Carbon::parse($cheque->date_emission)->format('d/m/Y') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6>Notes</h6>
                                        <p class="fs-5">{{ $cheque->notes ?? 'Aucune note' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations sur l'entreprise -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 text-uppercase">Informations de l'entreprise</h5>
                                </div>
                                <div class="card-body">
                                    @if ($cheque->entreprise)
                                        <div class="mb-3">
                                            <h6>Raison sociale</h6>
                                            <p class="fs-5">{{ $cheque->entreprise->raison_sociale }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <h6>Téléphone</h6>
                                            <p class="fs-5">
                                                <a href="tel:{{ $cheque->entreprise->telephone }}" class="text-primary">
                                                    {{ $cheque->entreprise->telephone }} @if (!empty($cheque->entreprise->telephone2))
                                                        /{{ $cheque->entreprise->telephone2 }}
                                                    @endif
                                                </a>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <h6>INSPECTION DE : </h6>
                                            <p class="fs-5">
                                                <a class="text-primary">
                                                    {{ $cheque->entreprise->inspection ?? 'Non renseigné' }}
                                                </a>
                                            </p>
                                        </div>
                                        @if ($cheque->status == 3)
                                            <div class="mb-3">
                                                <h6>MOTIF DE REJET : </h6>
                                                <p class="fs-5">
                                                    <a class="text-danger">
                                                        {{ $cheque->motif_rejet ?? 'Non renseigné' }}
                                                    </a>
                                                </p>
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-danger">Aucune information entreprise disponible</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions de validation -->
                            @if ($cheque->status == 2)
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <button id="btn_rejeter" class="btn btn-danger">
                                                <i class="fa fa-times me-2"></i> Rejeter
                                            </button>

                                            <button id="btn_valider" class="btn btn-success">
                                                <i class="fa fa-check me-2"></i> Valider
                                            </button>
                                        </div>

                                        <!-- Formulaire de rejet (caché par défaut) -->
                                        <div id="rejet_form" class="mt-4" style="display: none;">
                                            <form action="{{ route('refusCheque', $cheque->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="motif_rejet" class="form-label">Motif du rejet</label>
                                                    <textarea name="motif_rejet" id="motif_rejet" class="form-control" rows="3" required></textarea>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="btn_annuler_rejet"
                                                        class="btn btn-secondary me-2">
                                                        Annuler
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        Confirmer le rejet
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($cheque->status == 1)
                                <div class="card" style="display: none">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <button id="btn_annuler_paiement" class="btn btn-danger">
                                                <i class="fa fa-times me-2"></i> Annuler le Paiement
                                            </button>
                                        </div>

                                        <div id="rejet_form_anulepaiement" class="mt-4" style="display: none;">
                                            <form action="{{ route('cheque.annuleAfterValide', $cheque->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="motif_anulation" class="form-label">Motif de l'annulation</label>
                                                    <textarea name="motif_anulation" id="motif_anulation" class="form-control" rows="3" required></textarea>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="btn_annuler_rejet_anulpaiement"
                                                        class="btn btn-secondary me-2">
                                                        Annuler
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        Confirmer l'annulation
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de validation -->
    <div class="modal fade" id="validationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation de validation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <p>Êtes-vous sûr de vouloir valider ce {{ $cheque->NaturePaiement ?? 'xxxxxx' }} ?</p>
                    <p class="fw-bold">
                        @if ($cheque->NaturePaiement == 'ESPECE')
                            Réference
                        @else
                            Numéro
                            @endif de @if ($cheque->NaturePaiement == 'ESPECE')
                                l'
                            @endif <span
                                class="text-lowercase">{{ $cheque->NaturePaiement ?? 'xxxxxxx' }}</span> :
                            {{ $cheque->numero_cheque ?? 'xxxxxxxxx' }}
                    </p>
                    <p class="fw-bold text-danger">Montant: {{ number_format($cheque->montant, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('validcheque', $cheque->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Confirmer la validation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Afficher le formulaire de rejet
            $('#btn_annuler_paiement').click(function() {
                $('#rejet_form_anulepaiement').slideDown();
            });

            // Cacher le formulaire de rejet
            $('#btn_annuler_rejet_anulpaiement').click(function() {
                $('#rejet_form_anulepaiement').slideUp();
            });

            // Afficher le formulaire de rejet
            $('#btn_rejeter').click(function() {
                $('#rejet_form').slideDown();
            });

            // Cacher le formulaire de rejet
            $('#btn_annuler_rejet').click(function() {
                $('#rejet_form').slideUp();
            });

            // Afficher la modal de validation
            $('#btn_valider').click(function() {
                $('#validationModal').modal('show');
            });

            // Validation du formulaire de rejet
            $('form').submit(function(e) {
                if ($(this).find('#motif_rejet').length && $(this).find('#motif_rejet').val().trim() ===
                    '') {
                    e.preventDefault();
                    alert('Veuillez saisir un motif de rejet');
                }
            });
            // Validation du formulaire de rejet
            $('form').submit(function(e) {
                if ($(this).find('#motif_anulation').length && $(this).find('#motif_anulation').val().trim() ===
                    '') {
                    e.preventDefault();
                    alert('Veuillez saisir un motif d annulation pour ce paiement');
                }
            });
        });
    </script>
@endpush
