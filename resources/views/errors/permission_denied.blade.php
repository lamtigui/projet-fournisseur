@extends('myApp.admin.adminLayout.adminPage')

@section('content')
 <!-- Navigation des parties prenantes (toujours visible même après l'erreur) -->
 <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
    <a href="/prospectsSection" class="flex-sm-fill text-sm-center nav-link">Clients</a>
    <a href="/clientsSection" class="flex-sm-fill text-sm-center nav-link active">Prospects</a>
    <a href="/suppliersSection" class="flex-sm-fill text-sm-center nav-link">Fournisseurs</a>
    <a href="/suppliersAndClientsSection" class="flex-sm-fill text-sm-center nav-link">Fournisseurs Clients</a>
</nav>
    <div class="container mt-5">
        <div class="alert alert-warning text-center">
            <h4 class="alert-heading" style="font-size: 50px">Accès refusé</h4>
            <p style="font-size: 20px">Vous n'avez pas la permission d'accéder à cette section. Veuillez contacter l'administrateur.</p>
        </div>
    </div>
@endsection
