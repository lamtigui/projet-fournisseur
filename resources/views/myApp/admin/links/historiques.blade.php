@extends('myApp.admin.adminLayout.adminPage')
@section('search-bar')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: #404242">HISTORIQUE</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form action="{{ route('historique') }}" method="GET" class="table-search-form row gx-1 align-items-center">
                            <div class="col-auto">
                                <input type="text" name="search" class="form-control search-orders" placeholder="Recherche ..." value="{{ request('search') }}">

                            </div>
                        </form>

                    </div><!--//col-->
                </div><!--//row-->
            </div><!--//table-utilities-->
        </div><!--//col-auto-->
    </div><!--//row-->


@endsection

@section('parties-prenantes')

    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        @if (auth()->user()->role == 'super-admin')
        <a href="/historique" class="flex-sm-fill text-sm-center nav-link active">Historique</a>
        <a href="/journaux" class="flex-sm-fill text-sm-center nav-link">Journaux</a>
    @elseif (auth()->user()->role == 'admin')
        <a href="/historique" class="flex-sm-fill text-sm-center nav-link active">Historique</a>
    @endif
        
    </nav>
@endsection
@section('content')
<div class="tab-content" id="orders-table-tab-content">
    <div class="tab-pane fade show active" id="orders-all" role="tabpanel"
        aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="cell">Nom</th>
                                <th class="cell">Role</th>
                                <th class="cell">Historique de Connexion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historiques as $historique)
                                <tr>
                                    <td class="cell">{{ $historique->user->name }}</td>
                                    <td class="cell">{{ $historique->user->role }}</td>
                                    <td class="cell">{{ \Carbon\Carbon::parse($historique->login_at)->timezone('Africa/Casablanca')->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div>
            {{ $historiques->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}

        </div>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let searchInput = document.querySelector("input[name='search']");
        let searchForm = document.querySelector(".table-search-form");

        searchInput.addEventListener("input", function () {
            if (searchInput.value.trim() === "") {
                window.location.href = "{{ route('historique') }}"; // Refresh the page
            }
        });
    });
</script>

@endsection
