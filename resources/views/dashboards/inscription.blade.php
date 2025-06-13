@extends('layouts.dashboard', ['title' => 'Inscription - TABLEAU DE BORD'])
@section('content')
 <div class="row g-3">

          <div class="col-xxl-8 col-lg-8 col-md-8">
            <div id="list-item-1" class="card fieldset border border-muted mt-0">
              <!-- form: profile details -->
              <span class="fieldset-tile text-muted bg-body">Details de l'installation:</span>
              <div class="card">
                <div class="card-body">
                  <form>
                    <div class="row mb-3">

                      <div class="row mb-3">
                      <label class="col-md-3 col-sm-4 col-form-label">libelle<span style="color:red">*</span></label>
                      <div class="col-md-9 col-sm-8">
                        <input type="text" placeholder="libelle de votre installation" class="form-control form-control-lg" >
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label class="col-md-3 col-sm-4 col-form-label">Ancien libelle </label>
                      <div class="col-md-9 col-sm-8">
                        <input type="text" placeholder="seulement si vous avez un autre avant" class="form-control form-control-lg" >
                      </div>
                    </div>
                      <div class="row mb-3">
                                <label class="col-md-3 col-sm-4 col-form-label">Email <span style="color:red">*</span></label>
                                    <div class="col-md-9 col-sm-8">
                                         <input type="email" class="form-control form-control-lg" placeholder="exemple@domaine.com" required>
                                    </div>
                        </div>
                    <div class="row mb-3">
                      <label class="col-md-3 col-sm-4 col-form-label">Telephone <span style="color:red">*</span></label>
                      <div class="col-md-9 col-sm-8">
                        <input type="text" class="form-control form-control-lg" placeholder="0102030405">
                      </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-sm-4 col-form-label">Nombre d'installation <span style="color:red">*</span></label>
                            <div class="col-md-9 col-sm-8">
                                <input type="number" class="form-control form-control-lg" min="0" placeholder="entrez vtre nombre d'installation">
                           </div>
                   </div>




                  </form>
                </div>
                <div class="card-footer text-end">

                  <button class="btn btn-lg btn-primary" type="submit">Enregistrer</button>
                </div>
              </div>
            </div>



          </div>
        </div>
@endsection
