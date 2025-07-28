@extends('layouts.dashboard', ['title' => $title ?? 'Liste des entreprises'])
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.css') }}">
    <style>
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            min-height: 58px;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            height: 56px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 56px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding-bottom: 10px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e4e4e4;
            border: 1px solid #aaa;
            border-radius: 4px;
            padding: 0 5px;
            margin-top: 5px;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">



     <!-- CSS de Select2 -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Toastr CSS (version spécifique) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet"> --}}
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
                <h5>Erreurs lors de l'importation :</h5>
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
                <div class="card-header">
                    <a href="{{ route('listCheques') }}" class="btn btn-primary">Retour</a>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Information sur le chèque</h5>

                    <form action="{{ route('cheque.store') }}" method="POST" id="add_admin_form"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @php
                            $url1 = urlSite() . 'listeTaxeApi/:id';
                        @endphp
                        <input type="hidden" id="lienUrl" value="{{ $url1 }}">
                        <input type="hidden" id="taxesData" value="">

                        <div class="row g-3">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="entreprise_id">Entreprise <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control select2 @error('entreprise_id') is-invalid @enderror"
                                        id="entreprise_id" name="entreprise_id" required>
                                        <option value="">Sélectionnez une entreprise</option>
                                        @foreach ($entreprises as $entreprise)
                                            <option value="{{ $entreprise->id }}"
                                                {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}>
                                                {{ $entreprise->raison_sociale }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small id="feedback" class="text-danger mt-0"></small>
                                    @error('entreprise_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="taxe_entreprise">Taxe de l'entreprise <span
                                            class="text-danger fw-bold">*</span></label>
                                    <select class="form-control  @error('taxe_entreprise') is-invalid @enderror"
                                        id="taxe_entreprise" name="taxe_entreprise" required>
                                        <option value="">Sélectionnez d'abord une entreprise</option>
                                    </select>
                                    @error('taxe_entreprise')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="montant">Montant <span class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="montant" id="montant"
                                        class="form-control @error('montant') is-invalid @enderror"
                                        value="{{ old('montant', '0.00 FCFA') }}" readonly>
                                    @error('montant')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="NaturePaiement">Nature <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control @error('NaturePaiement') is-invalid @enderror"
                                        id="NaturePaiement" name="NaturePaiement" required>
                                        <option value="">Sélectionnez la nature</option>
                                        <option value="CHEQUE" {{ old('NaturePaiement') == 'CHEQUE' ? 'selected' : '' }}>
                                            Chèque</option>
                                        <option value="VIREMENT"
                                            {{ old('NaturePaiement') == 'VIREMENT' ? 'selected' : '' }}>Virement</option>
                                    </select>
                                    @error('NaturePaiement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="numero_cheque">Numéro du <span class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="numero_cheque" id="numero_cheque"
                                        value="{{ old('numero_cheque') }}"
                                        class="form-control @error('montant') is-invalid @enderror" pattern="[A-Za-z0-9-]+"
                                        title="Caractères alphanumériques et tirets uniquement" placeholder="CHQ-2023-001">
                                    @error('numero_cheque')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="banque">Banque émettrice <span
                                            class="text-danger fw-bold">*</span></label>
                                    <select class="form-control @error('banque') is-invalid @enderror" id="banque-select"
                                        name="banque" required>
                                        <option value="">-- Sélectionnez votre banque --</option>
                                        <option value="BOA" {{ old('banque') == 'BOA' ? 'selected' : '' }}>Bank of
                                            Africa (BOA)</option>
                                        <option value="ECOBANK" {{ old('banque') == 'ECOBANK' ? 'selected' : '' }}>Ecobank
                                        </option>
                                        <option value="UBA" {{ old('banque') == 'UBA' ? 'selected' : '' }}>United Bank
                                            for Africa (UBA)</option>
                                        <option value="NSIA" {{ old('banque') == 'NSIA' ? 'selected' : '' }}>Banque NSIA
                                        </option>
                                        <option value="SGBCI" {{ old('banque') == 'SGBCI' ? 'selected' : '' }}>Société
                                            Générale Côte d'Ivoire (SGBCI)</option>
                                        <option value="BICICI" {{ old('banque') == 'BICICI' ? 'selected' : '' }}>BICICI
                                        </option>
                                        <option value="SIB" {{ old('banque') == 'SIB' ? 'selected' : '' }}>Société
                                            Ivoirienne de Banque (SIB)</option>
                                        <option value="AUTRE" {{ old('banque') == 'AUTRE' ? 'selected' : '' }}>Autre
                                            banque</option>
                                    </select>
                                    @error('banque')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-lg-4 col-md-12" id="autre-banque-container" style="display: none;">
                                <div class="form-group">
                                    <label for="autre-banque">Précisez votre banque <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="autre_banque" id="autre-banque"
                                        value="{{ old('autre_banque') }}"
                                        class="form-control @error('autre_banque') is-invalid @enderror"
                                        placeholder="Nom complet de votre banque">
                                    @error('autre_banque')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="date_emission">Date d'émission <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="date" name="date_emission" id="date_emission"
                                        class="form-control @error('date_emission') is-invalid @enderror" required
                                        max="{{ date('Y-m-d') }}" value="{{ old('date_emission', date('Y-m-d')) }}">
                                    @error('date_emission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="titulaire">Nom du titulaire du compte <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="titulaire" id="titulaire"
                                        class="form-control @error('titulaire') is-invalid @enderror" required
                                        value="{{ old('titulaire') }}"
                                        placeholder="Nom tel qu'il apparaît sur le chèque">
                                    @error('titulaire')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="notes">Notes complémentaires</label>
                                    <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3"
                                        placeholder="Référence client, informations supplémentaires...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="conditions" required>
                                <label class="form-check-label" for="conditions">Je certifie que les informations fournies
                                    sont
                                    exactes et que le chèque sera honoré</label>
                            </div>

                            <div class="mt-3">
                                <p><span class="text-danger fw-bold">*</span> Champs obligatoires.</p>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <a href="{{ route('listCheques') }}" class="btn btn-secondary mx-2">Annuler</a>
                                    <button type="submit" id="add_admin_btn"
                                        class="btn btn-primary mx-2">Enregistrer</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/select2/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const natureSelect = document.getElementById('NaturePaiement');
            const numeroLabel = document.querySelector('label[for="numero_cheque"]');
            const numeroInput = document.getElementById('numero_cheque');
            const formNote = document.querySelector('.form-note');

            natureSelect.addEventListener('change', function() {
                if (this.value === 'CHEQUE') {
                    numeroLabel.textContent = 'Numéro du chèque *';
                    numeroInput.placeholder = 'CHQ-2023-001';
                    formNote.textContent = 'Ex: CHQ-2023-001 ou 2023/CHQ/001';
                    numeroInput.pattern = "[A-Za-z0-9-]+";
                    numeroInput.title = "Caractères alphanumériques et tirets uniquement";
                } else if (this.value === 'VIREMENT') {
                    numeroLabel.textContent = 'Numéro de virement *';
                    numeroInput.placeholder = 'VIR-2023-001';
                    formNote.textContent = 'Ex: VIR-2023-001 ou REF/VIREMENT/2023';
                    numeroInput.pattern = "[A-Za-z0-9-/]+";
                    numeroInput.title = "Caractères alphanumériques, tirets et slashs uniquement";
                } else {
                    numeroLabel.textContent = 'Numéro';
                    numeroInput.placeholder = '';
                    formNote.textContent = '';
                }
            });

            // Déclencher l'événement au chargement si une valeur est déjà sélectionnée
            if (natureSelect.value) {
                natureSelect.dispatchEvent(new Event('change'));
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de l'affichage du champ "autre banque"
            const banqueSelect = document.getElementById('banque-select');
            const autreBanqueContainer = document.getElementById('autre-banque-container');

            banqueSelect.addEventListener('change', function() {
                if (this.value === 'AUTRE') {
                    autreBanqueContainer.style.display = 'block';
                    document.getElementById('autre-banque').required = true;
                } else {
                    autreBanqueContainer.style.display = 'none';
                    document.getElementById('autre-banque').required = false;
                }
            });

            // Validation du formulaire
            const form = document.getElementById('cheque-form');
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validation simple pour l'exemple
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });

            // Animation des champs lorsqu'ils reçoivent le focus
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.01)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('.select2').select2({
            //     placeholder: "Sélectionnez une option",
            //     allowClear: true
            // });

            $('#entreprise_id').on('change', function() {
                const messageInput = document.getElementById("feedback");
                messageInput.innerHTML = '';
                messageInput.style = "font-size: 16px";
                const selectedValue = $(this).val();
                const select = $('#taxe_entreprise');
                select.prop('disabled', true);
                $('#taxe_entreprise').empty().append('<option value="0">⏳ Chargement...</option>');
                if (selectedValue === '') {
                    $('#taxe_entreprise').empty().append(
                        '<option value="0">Sélectionnez d\'abord une entreprise</option>');
                    select.prop('disabled', false);
                    return;
                }
                fetch(`/listeTaxeApi/${selectedValue}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Erreur serveur (${response.status})`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        $('#taxe_entreprise').empty();
                        let taxeSelect = $('#taxe_entreprise');
                        taxeSelect.empty();
                        taxesData = {}; // Réinitialiser les données

                        // Ajouter les options par défaut
                        taxeSelect.append('<option value="0">Sélectionner la taxe</option>');
                        taxeSelect.append('<option value="00">Payer toutes les taxes</option>');
                        console.log(data);
                        if (data.status === 200 && Array.isArray(data.data)) {
                            // $('#taxe_entreprise').append(
                            //     '<option value="0">-- Choisir la taxe à payer --</option>');
                            // data.data.forEach(t => {
                            //     $('#taxe_entreprise').append(
                            //         `<option value="${t.id}">${t.periode} ${parseFloat(t.montant)}</option> `
                            //     );
                            // });

                            let totalMontant = 0;
                            data.data.forEach(function(taxe) {
                                taxesData[taxe.id] = {
                                    periode: taxe.periode,
                                    montant: parseFloat(taxe.montant) || 0
                                };
                                totalMontant += taxesData[taxe.id].montant;
                            });
                            taxesData['00'] = {
                                periode: "Toutes les taxes",
                                montant: totalMontant
                            };

                            $.each(taxesData, function(id, taxe) {
                                if (id !==
                                    '00'
                                ) { // On ajoute pas '00' car déjà ajouté comme option par défaut
                                    taxeSelect.append(new Option(
                                        `${taxe.periode} - ${taxe.montant.toFixed(2)} FCFA`,
                                        id,
                                        false,
                                        false
                                    ));
                                }
                            });

                            // Sélectionner l'ancienne valeur si elle existe
                            let oldTax = @json(old('taxe_entreprise', ''));
                            if (oldTax) {
                                taxeSelect.val(oldTax).trigger('change');
                            } else {
                                // Sélectionner l'option par défaut
                                taxeSelect.val('0').trigger('change');
                            }



                        } else {
                            messageInput.innerHTML =
                                `<strong>${data.message || "Aucune donnée reçue."}</strong>`;
                            $('#taxe_entreprise').empty().append(
                                '<option value="0">Indiquer une entreprise...</option>');
                        }
                    })
                    .catch(error => {
                        messageInput.innerHTML = `<strong>Erreur : ${error.message}</strong>`;
                        $('#taxe_entreprise').empty().append(
                            '<option value="0">-- Erreur de chargement --</option>');
                    })
                    .finally(() => {
                        select.prop('disabled', false);
                    });
            });

            $('#taxe_entreprise').on('change', function() {
                let selectedTaxId = $(this).val();

                if (selectedTaxId === '00' && taxesData['00']) {
                    // Cas "Payer toutes les taxes"
                    $('#montant').val(taxesData['00'].montant.toFixed(2) + ' FCFA');
                } else if (selectedTaxId && taxesData[selectedTaxId]) {
                    // Cas d'une taxe spécifique
                    $('#montant').val(taxesData[selectedTaxId].montant.toFixed(2) + ' FCFA');
                } else {
                    // Cas par défaut
                    $('#montant').val('0.00 FCFA');
                }
            });
        });
    </script>

@endpush
