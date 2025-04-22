@extends('myApp.admin.adminLayout.adminPage')

@section('parties-prenantes')
<div class="row g-3 mb-4 align-items-center justify-content-between">
    <div class="col-auto">
        <h1 class="app-page-title mb-0" style="color: #404242">JOURNAUX</h1>
    </div>
    <div class="col-auto">
        <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto">
                    <form action="{{ route('journaux.index') }}" method="GET" class="table-search-form row gx-1 align-items-center">
                        <div class="col-auto">
                            <input type="text" name="search" class="form-control search-orders" placeholder="Recherche ..." value="{{ request('search') }}">

                        </div>
                    </form>

                </div><!--//col-->
            </div><!--//row-->
        </div><!--//table-utilities-->
    </div><!--//col-auto-->
</div><!--//row-->

    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        @if (auth()->user()->role == 'super-admin')
        <a href="/historique" class="flex-sm-fill text-sm-center nav-link ">Historique</a>
        <a href="/journaux" class="flex-sm-fill text-sm-center nav-link active">Journaux</a>
    @elseif (auth()->user()->role == 'admin')
        <a href="/historique" class="flex-sm-fill text-sm-center nav-link">Historique</a>
    @endif
    </nav>
@endsection
@section('content')
<div class="tab-content" id="orders-table-tab-content">
    <div class="tab-pane fade show active" id="orders-paid" role="tabpanel" aria-labelledby="orders-paid-tab">
        <div class="app-card app-card-orders-table mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                   
                    <table class="table mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="cell">Nom</th>
                                <th class="cell">Role</th>
                                <th class="cell">Type</th>
                                <th class="cell">Action</th>
                                <th class="cell">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="cell">{{ $log->user ? $log->user->name : 'Système' }}</td>
                                    <td class="cell">{{ $log->user ? $log->user->role ?? 'Role inconnu' : 'Utilisateur inconnu' }}</td>
                                    <td class="cell">{{ $log->type }}</td>
                                    <td class="cell">{{ $log->description }}</td>
                                    <td class="cell">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    {{ $logs->appends(request()->query())->links('vendor.pagination.bootstrap-4') }} <!-- This generates the pagination links -->
</div>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let searchInput = document.querySelector("input[name='search']");
        let searchForm = document.querySelector(".table-search-form");

        searchInput.addEventListener("input", function () {
            if (searchInput.value.trim() === "") {
                window.location.href = "{{ route('journaux.index') }}"; // Refresh the page
            }
        });
    });
</script>

@endsection
