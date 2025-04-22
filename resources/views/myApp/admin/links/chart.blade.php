 @extends('myApp.admin.adminLayout.adminPage')
 @section('title')
     Dashboard
 @endsection
 @section('content')
     <div class="page-inner">
         <h1 class="app-page-title">Aperçu</h1>
         <div class="row g-4 mb-4">
             <div class="col-6 col-lg-3">
                 <div class="app-card app-card-stat shadow-sm h-100">
                     <div class="app-card-body p-3 p-lg-4">
                         <h4 class="stats-type mb-1">Les Clients</h4>
                         <div class="stats-figure">{{ $sumTiers }}</div>
                         <div class="stats-meta text-success">
                             @if ($tiersChange > 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                 </svg> +{{ $tiersChange }}
                             @elseif ($tiersChange < 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                 </svg> {{ $tiersChange }}
                             @endif
                         </div>
                     </div>
                     <a class="app-card-link-mask" href="prospectsSection"></a>
                 </div><!--//app-card-->
             </div><!--//col-->
             <div class="col-6 col-lg-3">
                 <div class="app-card app-card-stat shadow-sm h-100">
                     <div class="app-card-body p-3 p-lg-4">
                         <h4 class="stats-type mb-1">Les Prosperts</h4>
                         <div class="stats-figure">{{ $sumClients }}</div>
                         <div class="stats-meta text-success">
                             @if ($clientsChange > 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                 </svg> +{{ $clientsChange }}
                             @elseif ($clientsChange < 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                 </svg> {{ $clientsChange }}
                             @endif
                         </div>
                     </div>
                     <a class="app-card-link-mask" href="clientsSection"></a>
                 </div><!--//app-card-->
             </div><!--//col-->
             <div class="col-6 col-lg-3">
                 <div class="app-card app-card-stat shadow-sm h-100">
                     <div class="app-card-body p-3 p-lg-4">
                         <h4 class="stats-type mb-1">Les Fournisseurs</h4>
                         <div class="stats-figure">{{ $sumSuppliers }}</div>
                         <div class="stats-meta text-success">
                             @if ($suppliersChange > 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                 </svg> +{{ $suppliersChange }}
                             @elseif ($suppliersChange < 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                 </svg> {{ $suppliersChange }}
                             @endif
                         </div>
                     </div><!--//app-card-body-->
                     <a class="app-card-link-mask" href="suppliersSection"></a>
                 </div><!--//app-card-->
             </div><!--//col-->
             <div class="col-6 col-lg-3">
                 <div class="app-card app-card-stat shadow-sm h-100">
                     <div class="app-card-body p-3 p-lg-4">
                         <h4 class="stats-type mb-1">Les Fournisseurs Clients</h4>
                         <div class="stats-figure">{{ $sumFournClients }}</div>
                         <div class="stats-meta text-success">
                             @if ($fournClientsChange > 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                 </svg> +{{ $fournClientsChange }}
                             @elseif ($fournClientsChange < 0)
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd"
                                         d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                 </svg> {{ $fournClientsChange }}
                             @endif
                         </div>
                     </div><!--//app-card-body-->
                     <a class="app-card-link-mask" href="suppliersAndClientsSection"></a>
                 </div><!--//app-card-->
             </div><!--//col-->
         </div><!--//row-->
         <!-- lfoog mgad f style -->
         <div class="row g-4 mb-4">
             <!-- Graphique Linéaire -->
             <div class="col-12 col-lg-6">
                 <div class="app-card app-card-chart h-100 shadow-sm">
                     <div class="app-card-header p-3">
                         <div class="row justify-content-between align-items-center">
                             <div class="col-auto">
                                 <h4 class="app-card-title">Graphique Linéaire</h4>
                             </div><!--//col-->
                             <div class="col-auto">
                                 <div class="card-header-action">
                                     <a href="suppliersSection">Plus</a>
                                 </div><!--//card-header-actions-->
                             </div><!--//col-->
                         </div><!--//row-->
                     </div><!--//app-card-header-->
                     <div class="app-card-body p-3 p-lg-4">
                         <div class="mb-3 d-flex">
                             <!-- Unique ID for Graphique Linéaire Dropdown -->
                             <select class="form-select form-select-sm ms-auto d-inline-flex w-auto line-chart-select"
                                 id="lineChartSelect">
                                 <option value="1" selected>Cette semaine</option>
                                 <option value="2">Aujourd'hui</option>
                                 <option value="3">Ce mois-ci</option>
                                 <option value="4">Cette année</option>
                             </select>
                         </div>
                         <div class="chart-container">
                             <canvas id="canvas-linechart"></canvas>
                         </div>
                     </div><!--//app-card-body-->
                 </div><!--//app-card-->
             </div><!--//col-->
             <!-- Graphique à Barres -->
             <div class="col-12 col-lg-6">
                 <div class="app-card app-card-chart h-100 shadow-sm">
                     <div class="app-card-header p-3">
                         <div class="row justify-content-between align-items-center">
                             <div class="col-auto">
                                 <h4 class="app-card-title">Graphique à Barres</h4>
                             </div><!--//col-->
                             <div class="col-auto">
                                 <div class="card-header-action">
                                     <a href="prospectsSection">Plus</a>
                                 </div><!--//card-header-actions-->
                             </div><!--//col-->
                         </div><!--//row-->
                     </div><!--//app-card-header-->
                     <div class="app-card-body p-3 p-lg-4">
                         <div class="mb-3 d-flex">
                             <!-- Unique ID for Graphique à Barres Dropdown -->
                             <select class="form-select form-select-sm ms-auto d-inline-flex w-auto bar-chart-select"
                                 id="barChartSelect">
                                 <option value="1" selected>Cette semaine</option>
                                 <option value="2">Aujourd'hui</option>
                                 <option value="3">Ce mois-ci</option>
                                 <option value="4">Cette année</option>
                             </select>
                         </div>
                         <div class="chart-container">
                             <canvas id="canvas-barchart"></canvas>
                         </div>
                     </div><!--//app-card-body-->
                 </div><!--//app-card-->
             </div><!--//col-->
         </div><!--//row-->
         <!-- les tableaus lte7t -->
         <div class="row g-4 mb-4">
             @if (Auth::user()->role !== 'utilisateur')
                 <div class="col-12 col-md-12 col-lg-6">
             @endif
             @if (Auth::user()->role === 'utilisateur')
                 <div class=""
                     style="padding-right: calc(var(--bs-gutter-x)*.5);
                 padding-left: calc(var(--bs-gutter-x)*.5);">
             @endif
             <div class="app-card app-card-progress-list h-100 shadow-sm">
                 <div class="app-card-header p-3">
                     <div class="row justify-content-between align-items-center">
                         <div class="col-auto">
                             <h4 class="app-card-title">Nombre de fournisseurs par catégorie</h4>
                         </div><!--//col-->
                         <div class="col-auto">
                             <div class="card-header-action">
                                 <a href="categoriesSection">Plus</a>
                             </div><!--//card-header-actions-->
                         </div><!--//col-->
                     </div><!--//row-->
                 </div><!--//app-card-header-->
                 <div class="app-card-body p-3 p-lg-4">
                     <div class="table-responsive">
                         <table class="table table-borderless mb-0">
                             <thead class="">
                                 <tr>
                                     <th class="meta" style="font-size: 1rem; color: #828d9f">Catégorie
                                     </th>
                                     <th class="meta stat-cell text-center" style="font-size: 1rem; color: #828d9f">
                                         Nombre de fournisseurs</th>
                                 </tr>
                             </thead>
                             <tbody class="">
                                 @foreach ($suppliersNumberByCategory as $categorie)
                                     <tr>
                                         <td class=""><strong>{{ $categorie->nom_categorie }}</strong></td>
                                         <td class="stat-cell text-center">
                                             <strong>{{ $categorie->fournisseurs_count }}</strong>
                                         </td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div><!--//table-responsive-->
                 </div><!--//app-card-body-->
             </div><!--//app-card-->
         </div><!--//col-->
         @if (Auth::user()->role !== 'utilisateur')
             <div class="col-12 col-md-12 col-lg-6">
                 <div class="app-card app-card-stats-table h-100 shadow-sm">
                     <div class="app-card-header p-3">
                         <div class="row justify-content-between align-items-center">
                             <div class="col-auto">
                                 <h4 class="app-card-title">Utilisateurs récemment connectés</h4>
                             </div><!--//col-->
                             <div class="col-auto">
                                 <div class="card-header-action">
                                     <a href="historique">Plus</a>
                                 </div><!--//card-header-actions-->
                             </div><!--//col-->
                         </div><!--//row-->
                     </div><!--//app-card-header-->
                     <div class="app-card-body p-3 p-lg-4">
                         <div class="table-responsive">
                             <table class="table table-borderless mb-0" style="">
                                 <thead class="" style="">
                                     <tr style="">
                                         <th class="meta" style="font-size: 1rem"><strong>Nom</strong></th>
                                         <th class="meta stat-cell"
                                             style="font-size: 1rem; direction: ltr; text-align: left;">
                                             <strong>Role</strong>
                                         </th>
                                         <th class="meta stat-cell text-center" style="font-size: 1rem">
                                             <strong>Historique
                                                 de Connexion</strong>
                                         </th>
                                     </tr>
                                 </thead>
                                 <tbody class="">
                                     @foreach ($historiques as $historique)
                                         <tr>
                                             <td class=""><strong>{{ $historique->user->name }}</strong>
                                             </td>
                                             <td class="stat-cell" style="direction: ltr; text-align: left;">
                                                 <strong>
                                                     @if ($historique->user->role === 'super-admin')
                                                         Super Admin
                                                     @elseif ($historique->user->role === 'admin')
                                                         Administrateur
                                                     @elseif ($historique->user->role === 'utilisateur')
                                                         Utilisateur
                                                     @else
                                                         {{ $historique->user->role }}
                                                     @endif
                                                 </strong>
                                             </td>
                                             <td class="stat-cell text-center"><strong>
                                                     {{ \Carbon\Carbon::parse($historique->login_at)->timezone('Africa/Casablanca')->format('d/m/Y H:i') }}
                                                 </strong></td>
                                         </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div><!--//table-responsive-->
                     </div><!--//app-card-body-->
                 </div><!--//app-card-->
             </div><!--//col-->
         @endif
     </div>
     </div>
     </div>
 @endsection
 @section('script')
     <script>
         document.querySelectorAll('button[data-bs-toggle="modal"]').forEach(button => {
             button.addEventListener('click', function() {
                 const userName = this.getAttribute('data-user-name');
                 const userEmail = this.getAttribute('data-user-email');
                 const userContact = this.getAttribute('data-user-contact');
                 const userAdress = this.getAttribute('data-user-adresse');
                 document.querySelector('#showName').innerText = userName;
                 document.querySelector('#showEmail').innerText = userEmail;
                 document.querySelector('#showContact').innerText = userContact;
                 document.querySelector('#showAdress').innerText = userAdress;
             });
         });
     </script>
     <!-- Charts JS -->
     <script src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
     <!-- <script src="{{ asset('assets/js/index-charts.js') }}"></script> -->
     <script src="{{ asset('assets/js/chartsJS/Bar_Chart.js') }}"></script>
     <script src="{{ asset('assets/js/chartsJS/Line_Chart.js') }}"></script>
 @endsection