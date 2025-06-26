@extends('layouts.dashboard', ['title' => $title ?? 'Liste des entreprises'])
@push('css')
    <!-- Application vendor css url -->
    <link rel="stylesheet" href="{{ asset('assets/cssbundle/dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/bundles/select2.min.css') }}">
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
        <div class="dropdown morphing scale-left">

            <a href="{{ route('listCheques') }}" class="btn btn-primary d-inline">Retour</a>
        </div>

        <div class="card-body" id="add_administrator">
            <h6 class="fw-bold">Information sur le cheque </h6>
            <form action="#" method="POST" id="add_admin_form" enctype="multipart/form-data" class="needs-validation"
                novalidate>
                @csrf
                <div class="row g-3">
                    <div class="col-lg-3 col-md-12">
                        <div class="form-floating">
                            <select class="form-select form-control select2 @error('entreprise_id') is-invalid @enderror"
                                id="entreprise_id" name="entreprise_id" autocomplete="entreprise_id" autofocus require>
                                <option value="">Sélectionnez une entreprise </option>
                                @foreach ($entreprises as $entreprise)
                                    <option value="{{ $entreprise->id }}">{{ $entreprise->raison_sociale }}</option>
                                @endforeach
                            </select>
                            @error('entreprise_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="floatingSelect">Entreprise<span class="text-danger fw-bold">*</span></label>
                        </div>
                    </div>


                </div>
                <div class="mt-3">
                    <p><span class="text-danger fw-bold">*</span>Champs obligatoires.</p>
                </div>
                <div class="row g-3 ">
                    <div class="mx-auto d-flex justify-content-center">

                        <button type="reset" class="btn btn-secondary w-25 mx-2">Annuler</button>
                        <button type="submit" id="add_admin_btn" class="btn btn-primary w-25 mx-2">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>



    <!-- Plugin Js -->
    <script src="assets/bundles/select2.bundle.js"></script>

    <!-- Jquery Page Js -->
    <script>
        $('.select2').select2();
    </script>
@endpush
