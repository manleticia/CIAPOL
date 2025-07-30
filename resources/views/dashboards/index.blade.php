@extends('layouts.dashboard', ['title' => 'Accueil - TABLEAU DE BORD'])
@push('css')
    <style>
        #paymentsOverviewChart {
            min-height: 350px;
            position: relative;
        }

        #paymentsOverviewChart .alert {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
        }

        .period-btn.active {
            z-index: 1;
            box-shadow: 0 0 0 2px rgba(115, 103, 240, 0.2);
        }

        .apexcharts-tooltip {
            font-family: inherit;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .apexcharts-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
@section('content')
    <div class="row mb-3">
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
                    <div><span class="fs-3 me-2"> {{ $nbreEntre ?? '0' }}</span> </span></div>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card lift">
                <div class="card-body py-xl-4 py-3">
                    <span class="text-muted">Cheque ou virement en Attente</span>
                    <div><span class="fs-3 me-2"> {{ $virement ?? '0' }}</span> </span></div>

                </div>
            </div>
        </div>
        <div class="col-4 mt-2" style="display: none">
            <div class="card lift">
                <div class="card-body py-xl-4 py-3">
                    <span class="text-muted ">Nombre (chèques / virements / espèces) annuels <br> Apres Validation</span>
                    <div><span class="fs-3 me-2"> {{ $paiImpay ?? '0' }}</span> </span></div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Paiements Aujourd'hui</h6>
                            <h3 class="mt-2 mb-0 fw-bold">{{ number_format($todayPayments->sum('montant'), 0, ',', ' ') }}
                                F CFA</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $growthRate }}% vs hier
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-wallet fs-4 text-primary"></i>
                        </div>
                    </div>
                    <div id="todayPaymentsChart"></div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Paiements Validés</h6>
                            <h3 class="mt-2 mb-0 fw-bold">
                                {{ number_format($validatedPayments->sum('montant'), 0, ',', ' ') }} F CFA</h3>
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>
                                {{ $validatedPercentage }}% du total
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-check-double fs-4 text-success"></i>
                        </div>
                    </div>
                    <div id="validatedPaymentsChart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-12">
            <div class="card lift">
                <div class="card-header">
                    <h5 class="card-title">Liste des Paiements du {{ dateDuJourEnFrancais() }}</h5>
                </div>

                <div class="table-responsive">
                    <table id="entreprisesTable" class="table table-striped table-bordered table-hover align-middle">
                        <thead class="">
                            <tr>
                                <th class="text-center">Raison Sociale</th>
                                <th class="text-center">Libellé de taxe</th>
                                <th class="text-center">Référence</th>
                                <th class="text-center">Montant</th>
                                <th class="text-center">Moyen de Paiement</th>
                                <th class="text-center">Numéro de Paiement</th>
                                <th class="text-center">Date de Paiement</th>
                                <th class="text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->entreprise->raison_sociale ?? 'N/A' }}</td>
                                    <td>{{ $paiement->taxeEntreprise->periode ?? 'N/A' }}</td>
                                    <td>{{ $paiement->referencePaiement ?? ($paiement->codePaiement ?? 'N/A') }}</td>
                                    <td class="text-end">
                                        {{ number_format($paiement->montant ?? 0, 0, ',', ' ') }} F CFA
                                    </td>
                                    <td>{{ $paiement->moyenPaiement ?? 'N/A' }}</td>
                                    <td>{{ $paiement->contactPaiement ?? 'N/A' }}</td>
                                    <td>
                                        {{ $paiement->datePaiement ? \Carbon\Carbon::parse($paiement->datePaiement)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                        <td class="text-center">
                                            <span
                                                class="badge rounded-pill bg-{{ $paiement->status == 1 ? 'success' : 'danger' }}">
                                                {{ $paiement->status == 1 ? 'Validé' : 'En attente' }}
                                            </span>
                                        </td>

                                </tr>
                            @endforeach
                            @if (empty($paiements))
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Aucun paiement enregistré
                                        aujourd'hui</td>
                                </tr>
                            @endif

                        </tbody>
                        @if ($paiements->count() > 0)
                            <tfoot>
                                <tr class="table-active">
                                    <th colspan="3" class="text-end">Total :</th>
                                    <th class="text-end">{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} F CFA
                                    </th>
                                    <th colspan="4"></th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>


            </div>
        </div>
    </div>




    {{-- <div class="row">
        <!-- Graphique Principal -->
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Statistiques des Paiements</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Plein écran">
                            <i class="icon-size-fullscreen"></i>
                        </a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary period-btn"
                                data-period="day">Jour</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary period-btn"
                                data-period="week">Semaine</button>
                            <button type="button" class="btn btn-sm btn-outline-primary period-btn active"
                                data-period="month">Mois</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary period-btn"
                                data-period="year">Année</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="paymentsOverviewChart"></div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#entreprisesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json'
                },
                responsive: true,
                dom: '<"top"lf>rt<"bottom"ip>',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                columnDefs: [{
                        orderable: false,
                        targets: [7]
                    } // Désactiver le tri sur la colonne Actions
                ]
            });

            // Initialiser les tooltips Bootstrap
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>


    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let chart;

            function loadData(period) {
                const chartElement = document.querySelector('#paymentsOverviewChart');
                chartElement.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2 text-muted">Chargement des données ${getPeriodLabel(period).toLowerCase()}...</p>
                </div>`;

                fetch(`/api/payments/stats/${period}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Erreur réseau');
                        return response.json();
                    })
                    .then(data => {
                        if (!data.success) throw new Error(data.error || 'Erreur de données');

                        const formattedSeries = data.data.series.map(amount => parseFloat(amount) || 0);

                        chart.updateOptions({
                            xaxis: {
                                categories: data.data.categories,
                                title: {
                                    text: getPeriodLabel(period)
                                }
                            },
                            chart: {
                                animations: {
                                    enabled: true
                                }
                            }
                        });

                        chart.updateSeries([{
                            name: 'Montant',
                            data: formattedSeries
                        }]);
                    })
                    .catch(error => {
                        chartElement.innerHTML = `
                        <div class="alert alert-danger py-2">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            ${error.message || 'Erreur de chargement des données'}
                        </div>`;
                    });
            }

            function getPeriodLabel(period) {
                const labels = {
                    day: 'Heures',
                    week: 'Jours',
                    month: 'Jours',
                    year: 'Mois'
                };
                return labels[period] || 'Période';
            }

            function initChart() {
                chart = new ApexCharts(document.querySelector("#paymentsOverviewChart"), {
                    series: [{
                        name: 'Montant',
                        data: []
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: true
                        },
                        animations: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            columnWidth: '70%'
                        }
                    },
                    xaxis: {
                        categories: [],
                        title: {
                            text: 'Période'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Montant (F CFA)'
                        },
                        labels: {
                            formatter: val => new Intl.NumberFormat('fr-FR').format(val)
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: val => new Intl.NumberFormat('fr-FR').format(val) + ' F CFA'
                        }
                    }
                });

                chart.render();
                loadData('month'); // chargement par défaut
            }

            // Clic sur bouton période
            document.querySelectorAll('.period-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const period = this.dataset.period;

                    // Mise à jour classes bouton
                    document.querySelectorAll('.period-btn').forEach(b => {
                        b.classList.remove('btn-primary', 'active');
                        b.classList.add('btn-outline-secondary');
                    });

                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-primary', 'active');

                    loadData(period);
                });
            });

            initChart();
        });
    </script>
@endpush
