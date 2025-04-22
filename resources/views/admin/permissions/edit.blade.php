@extends('myApp.admin.adminLayout.adminPage')
@section('search-bar')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: #404242">GESTION DES PERMISSIONS</h1>
        </div>
    </div><!--//row-->
@endsection
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg rounded">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        Permissions de {{ $user->name }}
                    </h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.permissions.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check bg-light p-3 rounded border">
                                    <input class="form-check-input" type="checkbox" name="can_see_prospects" id="prospects"
                                           {{ $permissions->can_see_prospects ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="prospects">
                                        <i class="bi bi-person-lines-fill me-2"></i>Voir Prosperts
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check bg-light p-3 rounded border">
                                    <input class="form-check-input" type="checkbox" name="can_see_clients" id="clients"
                                           {{ $permissions->can_see_clients ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="clients">
                                        <i class="bi bi-people-fill me-2"></i>Voir Clients
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check bg-light p-3 rounded border">
                                    <input class="form-check-input" type="checkbox" name="can_see_fournisseurs" id="fournisseurs"
                                           {{ $permissions->can_see_fournisseurs ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="fournisseurs">
                                        <i class="bi bi-truck me-2"></i>Voir Fournisseurs
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check bg-light p-3 rounded border">
                                    <input class="form-check-input" type="checkbox" name="can_see_fournisseurs_clients" id="fournisseurs_clients"
                                           {{ $permissions->can_see_fournisseurs_clients ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="fournisseurs_clients">
                                        <i class="bi bi-diagram-3-fill me-2"></i>Voir Fournisseurs Clients
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle-fill me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


@endsection
