@extends('myApp.admin.adminLayout.adminPage')
@section('search-bar')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: #404242">LES Prosperts</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form action="#" method="GET" class="table-search-form row gx-1 align-items-center">
                            <div class="col-auto">
                                <input type="text" id="searchInput" name="search" class="form-control search-orders"
                                    placeholder="Recherche ... " onkeyup="searchClients()">
                            </div>
                        </form>
                    </div><!--//col-->

                    <div class="col-auto d-flex align-items-center gap-2">
                        @if (auth()->user()->role == 'super-admin')
                        <div class="dropdown">
                            <button class="btn app-btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-pdf"></i> Exporter en pdf
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('clients.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Prospert</a></li>
                                <li><a class="dropdown-item" href="{{ route('prospects.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Clients</a></li>
                                <li><a class="dropdown-item" href="{{ route('fournisseurs.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Fournisseurs</a></li>
                                <li><a class="dropdown-item" href="{{ route('fournisseurClients.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Fournisseur Clients</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('allData.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Toutes les Tables</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn app-btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-excel"></i> Exporter en Excel
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('export.clients') }}"><i class="fas fa-file-excel"></i> Exporter Prospert</a></li>
                                <li><a class="dropdown-item" href="{{ route('export.prospects') }}"><i class="fas fa-file-excel"></i> Exporter Clients</a></li>
                                <li><a class="dropdown-item" href="{{ route('export.fournisseurs') }}"><i class="fas fa-file-excel"></i> Exporter Fournisseurs</a></li>
                                <li><a class="dropdown-item" href="{{ route('export.fournisseurClients') }}"><i class="fas fa-file-excel"></i> Exporter Fournisseur Clients</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('export.excel') }}"><i class="fas fa-file-excel"></i> Exporter Toutes les Tables</a></li>
                            </ul>
                        </div>
                        @elseif (auth()->user()->role == 'admin')
                        <div class="dropdown">
                            <button class="btn app-btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-pdf"></i> EXPORTER en pdf
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('clients.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Prospert</a></li>
                                <li><a class="dropdown-item" href="{{ route('prospects.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Clients</a></li>
                                <li><a class="dropdown-item" href="{{ route('fournisseurs.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Fournisseurs</a></li>
                                <li><a class="dropdown-item" href="{{ route('fournisseurClients.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Fournisseur Clients</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('allData.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Toutes les Tables</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn app-btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-excel"></i> Exporter en Excel
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('export.clients') }}"><i class="fas fa-file-excel"></i> Exporter Prospert</a></li>
                                <li><a class="dropdown-item" href="{{ route('export.prospects') }}"><i class="fas fa-file-excel"></i> Exporter Clients</a></li>
                                <li><a class="dropdown-item" href="{{ route('export.fournisseurs') }}"><i class="fas fa-file-excel"></i> Exporter Fournisseurs</a></li>
                                <li><a class="dropdown-item" href="{{ route('export.fournisseurClients') }}"><i class="fas fa-file-excel"></i> Exporter Fournisseur Clients</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('export.excel') }}"><i class="fas fa-file-excel"></i> Exporter Toutes les Tables</a></li>
                            </ul>
                        </div>
                        @endif
                    </div>
                    
                    
                </div><!--//row-->
            </div><!--//table-utilities-->
        </div><!--//col-auto-->
    </div><!--//row-->
@endsection

@section('parties-prenantes')
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a href="/prospectsSection" class="flex-sm-fill text-sm-center nav-link">Clients</a>
        <a href="/clientsSection" class="flex-sm-fill text-sm-center nav-link active">Prosperts</a>
        <a href="/suppliersSection" class="flex-sm-fill text-sm-center nav-link">Fournisseurs</a>
        <a href="/suppliersAndClientsSection" class="flex-sm-fill text-sm-center nav-link">Fournisseurs Clients</a>
    </nav>
@endsection

@section('errorContent')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalType = document.getElementById('modals').getAttribute('data-error');

            if (modalType === 'default') {
                var addModal = new bootstrap.Modal(document.getElementById('add_client'));
                addModal.show();
            } else if (modalType === 'update') {
                var updateModal = new bootstrap.Modal(document.getElementById('update_client'));
                updateModal.show();
            } else if (modalType === 'remark') {
                var remark = new bootstrap.Modal(document.getElementById('remark'));
                remark.show();
            }
        });
    </script>
@endsection
@section('content')
    <div id="modals" style="display:none;" data-error="{{ session('modalType') }}"></div>
    <form action="{{ route('client.add') }}" method="POST">
        @csrf
        <div class="modal fade" id="add_client" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clientModalLabel">Ajouter un client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label class="form-label"><strong class="det">Nom de la société</strong></label><br>
                        <input type="text" class="form-control" name="nomSociete_client"
                            placeholder="Entrer le nom de la société..." value="{{ old('nomSociete_client') }}" />
                        @error('nomSociete_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>
                        @enderror



                        <label class="form-label"><strong class="det">GSM1 de la société</strong></label><br>
                        <input type="tel" class="form-control" name="GSM1_client"
                            placeholder="Entrer le GSM1..." value="{{ old('GSM1_client') }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        @error('GSM1_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>

                        @enderror


                        <label class="form-label"><strong class="det">GSM2 de la société</strong></label><br>
                        <input type="tel" class="form-control" name="GSM2_client"
                            placeholder="Entrer le GSM2..." value="{{ old('GSM2_client') }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        @error('GSM2_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>
                        @enderror
                        
                        
                        <label class="form-label"><strong class="det">Personne à contacter</strong></label><br>
                        <input type="text" class="form-control" name="nom_client" placeholder="Entrer le client..."
                            value="{{ old('nom_client') }}" />
                        @error('nom_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>
                        @enderror


                        <label class="form-label"><strong class="det">Numero de telephone</strong></label><br>
                        <input type="tel" class="form-control" name="tele_client"
                            placeholder="Entrer le contact..." value="{{ old('tele_client') }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        @error('tele_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>
                        @enderror


                        <label class="form-label"><strong class="det">Email</strong></label><br>
                        <input type="email" class="form-control" name="email_client" placeholder="Entrer l'émail..."
                            value="{{ old('email_client') }}" />
                        @error('email_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>
                        @enderror


                        <label class="form-label"><strong class="det">Lien de la société</strong></label><br>
                        <input type="url" class="form-control" name="lien_client"
                            placeholder="Entrer le lien..." value="{{ old('lien_client') }}"/>
                        @error('lien_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>
                        @enderror

                        <label class="form-label"><strong class="det">Ville</strong></label>
                        <input type="text" class="form-control" name="ville_client" placeholder="Entrer la ville..."
                            value="{{ old('ville_client') }}" />
                        @error('ville_client', 'default')
                            <span class="text-danger">{{ $message }}</span> <br>
                        @enderror

                        <label for="categorie" class="form-label"><strong class="det">Catégorie</strong></label>
                        <select id="categorie" class="form-control" name="categorie_id">
                            <option value="">Sélectionner la catégorie</option>
                            @foreach ($categories as $categorie)
                                <option value="{{ $categorie->id }}"
                                    {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom_categorie }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Label pour les sous-catégories, caché tant qu'une catégorie n'est pas sélectionnée -->
                        <label for="sous-categorie" class="form-label" id="label-sous-categorie"
                            {{ request('categorie_id') ? '' : 'style=display:none;' }}>
                            <strong class="det">Sous-Catégorie</strong>
                        </label>

                        <!-- Sélecteur de sous-catégorie, caché tant qu'une catégorie n'est pas sélectionnée -->
                        <select id="sous-categorie" class="form-control" name="sous_categorie_id"
                            {{ request('categorie_id') ? '' : 'style=display:none;' }}>
                            <option value="">Sélectionner une sous-catégorie</option>
                            @if (request('categorie_id'))
                                @foreach ($sousCategories as $sousCategorie)
                                    <option value="{{ $sousCategorie->id }}"
                                        {{ request('sous_categorie_id') == $sousCategorie->id ? 'selected' : '' }}>
                                        {{ $sousCategorie->nom_produit }}
                                    </option>
                                @endforeach
                            @endif
                        </select>



                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Ajouter" data-bs-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="app-card app-card-orders-table mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table id="client-table" class="table app-table-hover mb-0 text-center">
                    <thead>
                        <tr>
                            <th class="cell">Nom de la société</th>
                            <th class="cell">GSM1 de la société</th>
                            <th class="cell">GSM2 de la société</th>
                            <th class="cell">Personne à contacter</th>
                            <th class="cell">Numero de telephone</th>
                            <th class="cell">Email</th>
                            <th class="cell">Lien de la société</th>
                            <th class="cell">Ville</th>
                            <th class="cell">Catégorie</th>
                            <th class="cell">Contacté Par</th>
                            <th class="cell text-end">
                                <button type="button" class="btn app-btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#add_client">
                                    Ajouter
                                </button>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $utilisateurs = \App\Models\User::get();
                        @endphp
                        @foreach ($clients as $client)
                            <tr>
                                <td class="cell2">
                                    {!! !empty($client->nomSociete_client) ? $client->nomSociete_client : '<span class="text-danger">Particulier</span>' !!}
                                </td>
                                <td class="cell2">
                                    {!! !empty($client->GSM1_client) ? $client->GSM1_client : '<span class="text-danger">Non disponible</span>' !!}
                                </td>
                                <td class="cell2">
                                    {!! !empty($client->GSM2_client) ? $client->GSM2_client : '<span class="text-danger">Non disponible</span>' !!}
                                </td>
                                <td class="cell2">
                                    {!! !empty($client->nom_client) ? $client->nom_client : '<span class="text-danger">Non disponible</span>' !!}
                                </td>
                                <td class="cell2">
                                    {!! !empty($client->tele_client) ? $client->tele_client : '<span class="text-danger">Non disponible</span>' !!}
                                </td>
                                <td class="cell2">
                                    {!! !empty($client->email_client) ? $client->email_client : '<span class="text-danger">Non disponible</span>' !!}
                                </td>
                                <td class="cell2">
                                    @if(!empty($client->lien_client))
                                        <a href="{{ $client->lien_client }}" target="_blank" class="text-primary">
                                            {{ Str::limit($client->lien_client, 20) }} <!-- Limite l'affichage -->
                                        </a>
                                    @else
                                        <span class="text-danger">Non disponible</span>
                                    @endif
                                </td>
                                <td class="cell2">{{ $client->ville_client }}</td>
                                <td class="cell2">
                                    @forelse ($client->categorieClients as $assoc)
                                        @if ($assoc->categorie)
                                            {{ $assoc->categorie->nom_categorie }}
                                        @endif
                                    @empty
                                        Non catégorisé
                                    @endforelse
                                </td>

                                <td class="cell2">
                                    {{ !empty($client->utilisateur->name) ? $client->utilisateur->name : 'Personne' }}
                                </td>

                                @if (auth()->user()->role == 'super-admin')
                                    <td class="button-container">
                                        <div class="d-flex align-items-center gap-2"
                                            style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;">
                                            <a href="#" class="btn btn-outline-primary border-btn me-4"
                                                data-bs-toggle="modal" data-bs-target="#update_client"
                                                data-id="{{ $client->id }}"
                                                data-society="{{ $client->nomSociete_client }}"
                                                data-GSM1="{{ $client->GSM1_client }}"
                                                data-GSM2="{{ $client->GSM2_client }}"
                                                data-lien="{{ $client->lien_client }}"
                                                data-name="{{ $client->nom_client }}"
                                                data-tele="{{ $client->tele_client }}"
                                                data-email="{{ $client->email_client }}"
                                                data-ville="{{ $client->ville_client }}"
                                                data-category="{{ $client->categories->first()?->id ?? '' }}">
                                                Modifier
                                            </a>




                                            <button type="button" class="btn btn-outline-success border-btn me-4"
                                                data-bs-toggle="modal" data-bs-target="#remark-{{ $client->id }}">
                                                Remarque
                                            </button>



                                            <button type="button"
                                                class="btn btn-outline-info detailButton border-btn me-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#ModalClientDetails-{{ $client->id }}"
                                                data-name="{{ $client->nom_client }}"
                                                data-email="{{ $client->email_client }}"
                                                data-tele="{{ $client->tele_client }}"
                                                data-ville="{{ $client->ville_client }}"
                                                data-society-name="{{ !empty($client->nomSociete_client) ? $client->nomSociete_client : 'Particulier' }}"
                                                data-GSM1="{{ !empty($client->GSM1_client) ? $client->GSM1_client : 'Non disponible' }}"
                                                data-GSM2="{{ !empty($client->GSM2_client) ? $client->GSM2_client : 'Non disponible' }}"
                                                data-lien="{{ !empty($client->lien_client) ? $client->lien_client : 'Non disponible' }}"
                                                data-remark="{{ $client->remark }}"
                                                data-user="{{ !empty($client->utilisateur->name) ? $client->utilisateur->name : 'Personne' }}">

                                                Details
                                            </button>


                                            <form action="{{ route('client.destroy', $client->id) }}" method="POST"
                                                style="display: inline border-radius: 1cap; border-style: inherit; color: transparent;"
                                                id="delete-form-{{ $client->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger border-btn me-4"
                                                    onclick="confirmDelete({{ $client->id }})">
                                                    Supprimer
                                                </button>
                                            </form>

                                            <form class="user-form"
                                                action="{{ route('user.select.client', $client->id) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <select class="form-select userSelect" aria-label="Default select example"
                                                    data-client-id="{{ $client->id }}" style="margin-right:100px"
                                                    name="user_id">
                                                    <option value="">Contacté Par</option>
                                                    @foreach ($utilisateurs as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>

                                            <form class="client-form" action="{{ route('client.select', $client->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <select name="status" id="" class="form-select status-select">
                                                    <option value="">Selectionner la table</option>
                                                    @foreach ($select as $item)
                                                        <option value="{{ $item }}">{{ $item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                @elseif (auth()->user()->role == 'admin')
                                    <td class="button-container">
                                        <div class="d-flex align-items-center gap-2"
                                            style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;">
                                            <a href="#" class="btn btn-outline-primary border-btn me-4"
                                                data-bs-toggle="modal" data-bs-target="#update_client"
                                                data-id="{{ $client->id }}"
                                                data-society="{{ $client->nomSociete_client }}"
                                                data-GSM1="{{ $client->GSM1_client }}"
                                                data-GSM2="{{ $client->GSM2_client }}"
                                                data-lien="{{ $client->lien_client }}"
                                                data-name="{{ $client->nom_client }}"
                                                data-tele="{{ $client->tele_client }}"
                                                data-email="{{ $client->email_client }}"
                                                data-ville="{{ $client->ville_client }}"
                                                data-category="{{ $client->categories->first()?->id ?? '' }}">
                                                Modifier
                                            </a>


                                            <form class="user-form"
                                                action="{{ route('user.select.client', $client->id) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <select class="form-select userSelect" aria-label="Default select example"
                                                    data-client-id="{{ $client->id }}" style="margin-right:100px"
                                                    name="user_id">
                                                    <option value="">Contacté Par</option>
                                                    @foreach ($utilisateurs as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>

                                            <button type="button" class="btn btn-outline-success border-btn me-4"
                                                data-bs-toggle="modal" data-bs-target="#remark-{{ $client->id }}">
                                                Remarque
                                            </button>



                                            <button type="button"
                                                class="btn btn-outline-info detailButton border-btn me-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#ModalClientDetails-{{ $client->id }}"
                                                data-name="{{ $client->nom_client }}"
                                                data-email="{{ $client->email_client }}"
                                                data-tele="{{ $client->tele_client }}"
                                                data-ville="{{ $client->ville_client }}"
                                                data-society-name="{{ !empty($client->nomSociete_client) ? $client->nomSociete_client : 'Particulier' }}"
                                                data-GSM1="{{ !empty($client->GSM1_client) ? $client->GSM1_client : 'Non disponible' }}"
                                                data-GSM2="{{ !empty($client->GSM2_client) ? $client->GSM2_client : 'Non disponible' }}"
                                                data-lien="{{ !empty($client->lien_client) ? $client->lien_client : 'Non disponible' }}"
                                                data-remark="{{ $client->remark }}"
                                                data-user="{{ !empty($client->utilisateur->name) ? $client->utilisateur->name : 'Personne' }}">

                                                Details
                                            </button>

                                            <form class="client-form" action="{{ route('client.select', $client->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <select name="status" id="" class="form-select status-select">
                                                    <option value="">Selectionner la table</option>
                                                    @foreach ($select as $item)
                                                        <option value="{{ $item }}">{{ $item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                @elseif (auth()->user()->role == 'utilisateur')
                                    <td class="button-container">
                                        <div class="d-flex align-items-center gap-2"
                                            style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;">


                                            <button type="button" class="btn btn-outline-success border-btn me-4"
                                                data-bs-toggle="modal" data-bs-target="#remark-{{ $client->id }}">
                                                Remarque
                                            </button>



                                            <button type="button"
                                                class="btn btn-outline-info detailButton border-btn me-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#ModalClientDetails-{{ $client->id }}"
                                                data-name="{{ $client->nom_client }}"
                                                data-email="{{ $client->email_client }}"
                                                data-tele="{{ $client->tele_client }}"
                                                data-ville="{{ $client->ville_client }}"
                                                data-society-name="{{ !empty($client->nomSociete_client) ? $client->nomSociete_client : 'Particulier' }}"
                                                data-GSM1="{{ !empty($client->GSM1_client) ? $client->GSM1_client : 'Non disponible' }}"
                                                data-GSM2="{{ !empty($client->GSM2_client) ? $client->GSM2_client : 'Non disponible' }}"
                                                data-lien="{{ !empty($client->lien_client) ? $client->lien_client : 'Non disponible' }}"
                                                data-remark="{{ $client->remark }}"
                                                data-user="{{ !empty($client->utilisateur->name) ? $client->utilisateur->name : 'Personne' }}">

                                                Details
                                            </button>
                                            <form class="user-form"
                                                action="{{ route('user.select.client', $client->id) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <select class="form-select userSelect" aria-label="Default select example"
                                                    data-client-id="{{ $client->id }}" style="margin-right:100px"
                                                    name="user_id">
                                                    <option value="">Contacté Par</option>
                                                    @foreach ($utilisateurs as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            <form class="client-form" action="{{ route('client.select', $client->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <select name="status" id="" class="form-select status-select">
                                                    <option value="">Selectionner la table</option>
                                                    @foreach ($select as $item)
                                                        <option value="{{ $item }}">{{ $item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                                <form action="{{ route('remark.client', $client->id) }}" method="POST">
                                    @csrf
                                    <div class="modal fade" id="remark-{{ $client->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">REMARQUE</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <textarea name="remark" id="remarque" class="form-control" style="height: 100px">{{ old('remark', $client->remark) }}</textarea>
                                                        @error('remark')
                                                            <div class="alert alert-danger">
                                                                {{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Ajouter la
                                                        remarque</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </tr>
                            <div class="modal fade" id="ModalClientDetails-{{ $client->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Details du client
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-6 det" style="font-size: 18px">Nom de la socité</div>
                                                <div class="col-6 showSocietyClient"><span style="font-size: 18px"
                                                        id="showSocietyDetail-{{ $client->id }}"></span></div>

                                                <div class="col-6 det" style="font-size: 18px">GSM1 de la société</strong>
                                                </div>
                                                <div class="col-6 showGSM1Client"><span style="font-size: 18px"
                                                        id="showGSM1Detail-{{ $client->id }}"></span></div>

                                                <div class="col-6 det" style="font-size: 18px">GSM2 de la société</strong>
                                                </div>
                                                <div class="col-6 showGSM2Client"><span style="font-size: 18px"
                                                        id="showGSM2Detail-{{ $client->id }}"></span></div>

                                                <div class="col-6 det" style="font-size: 18px">Personne à
                                                    contacter</strong></div>
                                                <div class="col-6 showNameClient"><span style="font-size: 18px"
                                                        id="showNameDetail-{{ $client->id }}"></span></div>

                                                <div class="col-6 det" style="font-size: 18px">Numero De
                                                    Telephone</strong></div>
                                                <div class="col-6 showContactClient"><span style="font-size: 18px"
                                                        id="showContactDetail-{{ $client->id }}"></span></div>

                                                <div class="col-6 det" style="font-size: 18px">Email</strong></div>
                                                <div class="col-6 showEmailClient"><span style="font-size: 18px"
                                                        id="showEmailDetail-{{ $client->id }}"></span></div>
                                                
                                                
                                                <div class="col-6 det" style="font-size: 18px">Lien de la société</strong>
                                                </div>
                                                <div class="col-6 showLienClient"><a href="{{ $client->lien_client }}" target="_blank" class="text-primary" style="font-size: 18px">
                                                    {{ Str::limit($client->lien_client, 20) }} <!-- Limite l'affichage -->
                                                </a></div>

                                                <div class="col-6 det" style="font-size: 18px">Ville</strong></div>
                                                <div class="col-6 showVilleClient"><span style="font-size: 18px"
                                                        id="showVilleDetail-{{ $client->id }}"></span></div>



                                                <div class="col-6 det" style="font-size: 18px">Les catégories</strong>
                                                </div>
                                                <div class="col-6">
                                                    <select
                                                        class="form-select form-select-sm col-6 info-client showCategoryClient"
                                                        aria-label=".form-select-sm example"
                                                        id="categories-{{ $client->id }}" style="color: #5d6778">
                                                        <option class="col-6" value="" selected>Voir la(les)
                                                            catégories</option>
                                                        @foreach ($client->allCategories as $categorie)
                                                            <option value="{{ $categorie->id }}">
                                                                {{ $categorie->nom_categorie }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-6 det" style="font-size: 18px">Sous-Catégorie</strong>
                                                </div>
                                                <div class="col-6">
                                                    <select
                                                        class="form-select form-select-sm col-6 info-client showProductClient"
                                                        aria-label=".form-select-sm example"
                                                        id="products-{{ $client->id }}"
                                                        style="color: #5d6778; font-size: 15px"><strong>
                                                            <option class="col-6" value="" selected>Voir les
                                                                produits associé</option>
                                                        </strong>
                                                    </select>
                                                </div>

                                                <div class="col-6 det" style="font-size: 18px">Contacté Par</strong></div>
                                                <div class="col-6 showUserClient"><span style="font-size: 18px"
                                                        id="showUserDetail-{{ $client->id }}"></span></div>

                                                <div class="col-6 det" style="font-size: 18px">Remarque</strong></div>
                                                <div class="col-6 showRemarkClient"><span style="font-size: 18px"
                                                        id="showRemarkDetail-{{ $client->id }}"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!--//modifier-client-->
    @if (isset($client))
        <div class="modal fade" id="update_client" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('client.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="updateClientId">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modifier le client</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label class="form-label"><strong class="det">Nom de la société</strong></label>
                                <input type="text" class="form-control" name="newNomSociete_client"
                                    placeholder="Entrer le nom de la société..." id="updateClientSociety"
                                    value="{{ old('newNomSociete_client', $client->nomSociete_client) }}" />
                                @if ($errors->has('newNomSociete_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newNomSociete_client') }}</span> <br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">GSM1 de la société</strong></label>
                                <input type="tel" class="form-control" name="newGSM1_client"
                                    placeholder="Entrer GSM1..." id="updateClientGSM1"
                                    value="{{ old('newGSM1_client', $client->GSM1_client) }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                                @if ($errors->has('newGSM1_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newGSM1_client') }}</span> <br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">GSM2 de la société</strong></label>
                                <input type="tel" class="form-control" name="newGSM2_client"
                                    placeholder="Entrer GSM2..." id="updateClientGSM2"
                                    value="{{ old('newGSM2_client', $client->GSM2_client) }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                                @if ($errors->has('newGSM2_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newGSM2_client') }}</span> <br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">Personne à contacter</strong></label>
                                <input id="updateClientName" type="text" class="form-control" name="newNom_client"
                                    placeholder="Entrer le client..."
                                    value="{{ old('newNom_client', $client->nom_client) }}" />
                                @if ($errors->has('newNom_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newNom_client') }}</span> <br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">Numéro De Téléphone</strong></label>
                                <input id="updateClientContact" type="tel" class="form-control"
                                    name="newTele_client" placeholder="Entrer le contact..."
                                    value="{{ old('newTele_client', $client->tele_client) }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                                @if ($errors->has('newTele_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newTele_client') }}</span> <br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">Email</strong></label>
                                <input id="updateClientEmail" type="email" class="form-control" name="newEmail_client"
                                    placeholder="Entrer l'émail..."
                                    value="{{ old('newEmail_client', $client->email_client) }}" />
                                @if ($errors->has('newEmail_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newEmail_client') }}</span> <br>
                                @endif

                            </div>

                            <div>
                                <label class="form-label"><strong class="det">Lien de la société</strong></label>
                                <input type="url" class="form-control" name="newLien_client"
                                    placeholder="Entrer le lien..." id="updateClientLien"
                                    value="{{ old('newLien_client', $client->lien_client) }}"/>
                                @if ($errors->has('newLien_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newLien_client') }}</span> <br>
                                @endif

                            </div>

                            <div>
                                <label class="form-label"><strong class="det">Ville</strong></label>
                                <input id="updateClientVille" type="text" class="form-control" name="newVille_client"
                                    placeholder="Entrer la ville..."
                                    value="{{ old('newVille_client', $client->ville_client) }}" />
                                @if ($errors->has('newVille_client'))
                                    <span class="text-danger">
                                        {{ $errors->first('newVille_client') }}</span>
                                @endif

                            </div>

                            <div>
                                <label class="form-label"><strong class="det">Catégorie</strong></label>
                                <select id="updateClientCategory" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" name="newCategorie_id" style="height: 39px">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">

                                            {{ $cat->nom_categorie }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('newCategorie_id'))
                                    <span class="text-danger">
                                        {{ $errors->first('newCategorie_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" data-bs-dismiss="modal" value="Modifier">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div>

        <div>
            {{ $clients->links('vendor.pagination.bootstrap-4') }}

        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('pagination-select');
            const form = document.getElementById('pagination-form');
            const perPageInput = document.getElementById('per-page-input');

            select.addEventListener('change', function() {
                perPageInput.value = this.value;
                form.submit();
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Quand une catégorie est sélectionnée
            $('#categorie').change(function() {
                var categorieId = $(this).val();

                // Si une catégorie est sélectionnée
                if (categorieId) {
                    // Afficher le champ des sous-catégories et son label
                    $('#label-sous-categorie').show();
                    $('#sous-categorie').show();

                    // Faire une requête AJAX pour récupérer les sous-catégories
                    $.ajax({
                        url: '/sous-categories/' + categorieId, // L'URL de ta route
                        type: 'GET',
                        success: function(response) {
                            // Vider le select de sous-catégories
                            $('#sous-categorie').empty();
                            $('#sous-categorie').append(
                                '<option value="">Sélectionner une sous-catégorie</option>');

                            // Ajouter les sous-catégories au select
                            $.each(response, function(index, sousCategorie) {
                                $('#sous-categorie').append('<option value="' +
                                    sousCategorie.id + '">' + sousCategorie
                                    .nom_produit + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            // Si une erreur se produit
                            console.log('Erreur :', error);
                        }
                    });
                } else {
                    // Si aucune catégorie n'est sélectionnée, cacher le champ des sous-catégories et son label
                    $('#label-sous-categorie').hide();
                    $('#sous-categorie').hide();
                }
            });
        });
    </script>

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const updateProspectModal = document.getElementById('update_client');
            updateProspectModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;

                const clientId = button.getAttribute('data-id');
                const clientName = button.getAttribute('data-name');
                const clientEmail = button.getAttribute('data-email');
                const clientContact = button.getAttribute('data-tele');
                const clientVille = button.getAttribute('data-ville');
                const clientSociety = button.getAttribute('data-society');
                const clientGSM1 = button.getAttribute('data-GSM1');
                const clientGSM2 = button.getAttribute('data-GSM2');
                const clientLien = button.getAttribute('data-lien');
                const clientCategory = button.getAttribute('data-category')

                document.getElementById('updateClientId').value = clientId;
                document.getElementById('updateClientName').value = clientName;
                document.getElementById('updateClientEmail').value = clientEmail;
                document.getElementById('updateClientContact').value = clientContact;
                document.getElementById('updateClientVille').value = clientVille;
                document.getElementById('updateClientSociety').value = clientSociety;
                document.getElementById('updateClientGSM1').value = clientGSM1;
                document.getElementById('updateClientGSM2').value = clientGSM2;
                document.getElementById('updateClientLien').value = clientLien;
                document.getElementById('updateClientCategory').value = clientCategory;


            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.status-select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const form = this.closest('.client-form');
                    if (form) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.userSelect'); // Sélectionne tous les selects
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const form = this.closest(
                        '.user-form'); // Trouve le formulaire correspondant
                    if (form) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        function confirmDelete(clientId) {
            Swal.fire({
                title: 'Supprimer le client !',
                text: "êtes-vous sûr que vous voulez supprimer ce client ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Oui, Supprimer-le !'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + clientId).submit();
                    Swal.fire(
                        "Supprimé !",
                        "Le client a été supprimé avec succès.",
                        "success"
                    );
                }
            });
        }
    </script>

    <script>
        document.querySelectorAll(`.detailButton`).forEach(button => {

            button.addEventListener('click', function() {
                const clientId = this.getAttribute('data-bs-target').split('-').pop();
                const clientName = this.getAttribute('data-name') || 'Non disponible'
                const clientEmail = this.getAttribute('data-email') || 'Non disponible'
                const clientContact = this.getAttribute('data-tele') || 'Non disponible'
                const clientVille = this.getAttribute('data-ville')
                const clientSociety = this.getAttribute('data-society-name')
                const clientGSM1 = this.getAttribute('data-GSM1')
                const clientGSM2 = this.getAttribute('data-GSM2')
                const clientLien = this.getAttribute('data-lien')
                const clientRemark = this.getAttribute('data-remark')
                const clientUser = this.getAttribute('data-user')

                document.querySelector(`#showNameDetail-${clientId}`).innerText = clientName
                document.querySelector(`#showEmailDetail-${clientId}`).innerText = clientEmail
                document.querySelector(`#showContactDetail-${clientId}`).innerText = clientContact
                document.querySelector(`#showVilleDetail-${clientId}`).innerText = clientVille
                document.querySelector(`#showSocietyDetail-${clientId}`).innerText = clientSociety
                document.querySelector(`#showGSM1Detail-${clientId}`).innerText = clientGSM1
                document.querySelector(`#showGSM2Detail-${clientId}`).innerText = clientGSM2
                document.querySelector(`#showLienDetail-${clientId}`).innerText = clientLien
                document.querySelector(`#showRemarkDetail-${clientId}`).innerText = clientRemark
                document.querySelector(`#showUserDetail-${clientId}`).innerText = clientUser
            })
        });

        document.addEventListener('DOMContentLoaded', function() {

            const categories = @json($categories);
            // console.log(categories);

            document.querySelectorAll('.showCategoryclient').forEach(selectCategory => {
                const clientId = selectCategory.id.split('-').pop();
                const products = document.getElementById(`products-${clientId}`);


                if (products) {
                    selectCategory.addEventListener('change', function() {
                        const selectedCategoryId = this.value;
                        products.innerHTML = '';

                        if (selectedCategoryId) {
                            const selectedCategory = categories.find(category => {
                                return category.id == selectedCategoryId;
                            });

                            if (selectedCategory && selectedCategory.sous_categories.length > 0) {
                                selectedCategory.sous_categories.forEach(sous_category => {
                                    const option = document.createElement('option');
                                    option.value = sous_category.id;
                                    option.textContent = sous_category.nom_produit;
                                    option.selected = true;
                                    option.disabled = true;

                                    products.appendChild(option);
                                });
                            } else {
                                const emptyOption = document.createElement('option');
                                emptyOption.textContent = 'Aucun produit trouvé';
                                emptyOption.disabled = true;
                                products.appendChild(emptyOption);
                            }
                        }
                    });
                }
            });
        });
    </script>


    <script>
        function searchClients() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('client-table');
            let tr = table.getElementsByTagName('tr');

            // Itérer à travers les lignes du tableau (commence à 1 pour ignorer l'entête)
            for (let i = 1; i < tr.length; i++) {
                let tds = tr[i].getElementsByTagName('td');
                let matchFound = false;

                // Vérifier chaque colonne pour la recherche
                for (let j = 0; j < tds.length; j++) {
                    let td = tds[j];
                    if (td) {
                        if (td.textContent.toLowerCase().includes(filter)) {
                            matchFound = true;
                            break;
                        }
                    }
                }

                // Afficher ou masquer la ligne en fonction de la correspondance
                if (matchFound) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    </script>
@endsection
@section('content2')
    <div class="modal fade" id="QueryClientsDetails" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="show-info-client show-society">
                        <label class="label-detail-client">Nom de la société</label>
                        <h6 class="info-client" id="showSocietyClient">
                        </h6>
                    </div>
                    <div class="show-info-client show-society">
                        <label class="label-detail-client">GSM1 de la société</label>
                        <h6 class="info-client" id="showGSM1Client">
                        </h6>
                    </div>
                    <div class="show-info-client show-society">
                        <label class="label-detail-client">GSM2 de la société</label>
                        <h6 class="info-client" id="showGSM2Client">
                        </h6>
                    </div>
                    <div class="show-info-client show-name">
                        <label class="label-detail-client">Personne à contacter</label>
                        <h6 class="info-client" id="showNameClient"></h6>
                    </div>
                    <div class="show-info-client show-contact">
                        <label class="label-detail-client">Numero De Telephone</label>
                        <h6 class="info-client" id="showContactClient"></h6>
                    </div>
                    <div class="show-info-client show-email">
                        <label class="label-detail-client">Email</label>
                        <h6 class="info-client" id="showEmailClient">
                        </h6>
                    </div>
                    <div class="show-info-client show-society">
                        <label class="label-detail-client">Lien de la société</label>
                        <h6 class="info-client" id="showLienClient">
                        </h6>
                    </div>


                    <div class="show-info-client show-ville">
                        <label class="label-detail-client">Ville</label>
                        <h6 class="info-client" id="showVilleClient">
                        </h6>
                    </div>
                    <div class="show-info-client show-category" style="margin-top:10px">
                        <label class="label-detail-client">Les catégories</label>
                        <select class="form-select form-select-sm info-client showCategoryClient"
                            aria-label=".form-select-sm example" style="width: 200px; height: 30px"
                            id="categoriesQuery-1">
                            <option value="" selected>Voir la(les) catégories</option>

                        </select>
                    </div>

                    <div class="show-info-client show-product" style="margin-bottom: 40px; margin-top:10px">
                        <label class="form-label label-detail-client">Sous-Catégorie</label>
                        <select class="form-select form-select-sm info-client showProductClient"
                            aria-label=".form-select-sm example" id="productsQuery-1" style="width: 200px; height: 30px">

                        </select>
                    </div>
                    <div class="show-info-client show-user">
                        <label class="label-detail-client">Contacté Par</label>
                        <h6 class="info-client" id="showUserClient">
                        </h6>
                    </div>
                    <div class="show-info-client show-remark">
                        <label class="label-detail-client">Remarque</label>
                        <p class="info-client" id="showRemarkClient" style="font-size: 12px">
                        </p>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection
