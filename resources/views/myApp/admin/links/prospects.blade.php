@extends('myApp.admin.adminLayout.adminPage')
@section('search-bar')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: #404242">LES Clients</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form action="#" method="GET"
                            class="table-search-form row gx-1 align-items-center">
                            <div class="col-auto">
                                <input type="text" id="searchInput" name="search" class="form-control search-orders"
                                    placeholder="Recherche ... " onkeyup="searchProspects()">
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
                                <li><a class="dropdown-item" href="{{ route('clients.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Prosperts</a></li>
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
                                <li><a class="dropdown-item" href="{{ route('export.clients') }}"><i class="fas fa-file-excel"></i> Exporter Prosperts</a></li>
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
                                <i class="fas fa-file-pdf"></i> Exporter en pdf
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('clients.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter Prosperts</a></li>
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
                                <li><a class="dropdown-item" href="{{ route('export.clients') }}"><i class="fas fa-file-excel"></i> Exporter Prosperts</a></li>
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

@section('errorContent')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalType = document.getElementById('modals').getAttribute('data-error');

            if (modalType === 'default') {
                var addModal = new bootstrap.Modal(document.getElementById('add_prospect'));
                addModal.show();
            } else if (modalType === 'update') {
                var updateModal = new bootstrap.Modal(document.getElementById('update_prospect'));
                updateModal.show();
            } else if (modalType === 'remark') {
                var remark = new bootstrap.Modal(document.getElementById('remark'));
                remark.show();
            }
        });
    </script>
@endsection
@section('parties-prenantes')
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a href="/prospectsSection" class="flex-sm-fill text-sm-center nav-link active">Clients</a>
        <a href="/clientsSection" class="flex-sm-fill text-sm-center nav-link">Prosperts</a>
        <a href="/suppliersSection" class="flex-sm-fill text-sm-center nav-link">Fournisseurs</a>
        <a href="/suppliersAndClientsSection" class="flex-sm-fill text-sm-center nav-link">Fournisseurs Clients</a>
    </nav>
@endsection

@section('content')
    <div id="modals" style="display:none;" data-error="{{ session('modalType') }}"></div>
    <form action="{{ route('prospect.add') }}" method="POST">
        @csrf
        <div class="modal fade" id="add_prospect" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label"><strong class="det">Nom de la société</strong></label>
                        <input type="text" class="form-control" name="nomSociete_prospect"
                            placeholder="Entrer le nom de la société..." value="{{ old('nomSociete_prospect') }}" />
                        @error('nomSociete_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror

                        <label class="form-label"><strong class="det">GSM1 de la société</strong></label>
                        <input type="tel" class="form-control" name="GSM1_prospect"
                            placeholder="Entrer le GSM1..." value="{{ old('GSM1_prospect') }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        @error('GSM1_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror
                        <label class="form-label"><strong class="det">GSM2 de la société</strong></label>
                        <input type="tel" class="form-control" name="GSM2_prospect"
                            placeholder="Entrer le GSM2..." value="{{ old('GSM2_prospect') }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        @error('GSM2_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror


                        <label class="form-label"><strong class="det">Personne à contacter</strong></label>
                        <input type="text" class="form-control" name="nom_prospect" placeholder="Entrer le prospect..."
                            value="{{ old('nom_prospect') }}" />
                        @error('nom_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror

                        <label class="form-label"><strong class="det">Numero de telephone</strong></label>
                        <input type="tel" class="form-control" name="tele_prospect"
                            placeholder="Entrer le contact..." value="{{ old('tele_prospect') }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        @error('tele_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror
                        <label class="form-label"><strong class="det">Email</strong></label>
                        <input type="email" class="form-control" name="email_prospect" placeholder="Entrer l'émail..."
                            value="{{ old('email_prospect') }}" />
                        @error('email_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror
                        <label class="form-label"><strong class="det">Lien de la société</strong></label>
                        <input type="url" class="form-control" name="lien_prospect"
                            placeholder="Entrer le lien..." value="{{ old('lien_prospect') }}"/>
                        @error('lien_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror

                        <label class="form-label"><strong class="det">Ville</strong></label>
                        <input type="text" class="form-control" name="ville_prospect"
                            placeholder="Entrer la ville..." value="{{ old('ville_prospect') }}" />
                        @error('ville_prospect', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror
                        <label class="form-label"><strong class="det">Catégorie</strong></label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                            name="categorie_id" id="categorie" style="color: #a6a6a6;">
                            <option value="">Selectionner la catégorie</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nom_categorie }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_id', 'default')
                            <span class="text-danger">{{ $message }}</span><br>
                        @enderror
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

    <div class="page-inner">
        <div class="app-card app-card-orders-table mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table id="prospect-table" class="table app-table-hover mb-0 text-center">
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
                                            data-bs-target="#add_prospect">
                                            Ajouter
                                        </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $utilisateurs = \App\Models\User::get();
                            @endphp
                            @foreach ($prospects as $prospect)
                                <tr>
                                    <td class="cell2">
                                        {!! !empty($prospect->nomSociete_prospect) ? $prospect->nomSociete_prospect : '<span class="text-danger">Particulier</span>' !!}
                                    </td>
                                    <td class="cell2">
                                        {!! !empty($prospect->GSM1_prospect) ? $prospect->GSM1_prospect :'<span class="text-danger">Non disponible</span>' !!}
                                    </td>
                                    <td class="cell2">
                                        {!! !empty($prospect->GSM2_prospect) ? $prospect->GSM2_prospect : '<span class="text-danger">Non disponible</span>' !!}
                                    </td>
                                    <td class="cell2">
                                        {!! !empty($prospect->nom_prospect) ? $prospect->nom_prospect : '<span class="text-danger">Non disponible</span>' !!}
                                    </td>
                                    <td class="cell2">
                                        {!! !empty($prospect->tele_prospect) ? $prospect->tele_prospect : '<span class="text-danger">Non disponible</span>' !!}
                                    </td>
                                    <td class="cell2">
                                        {!! !empty($prospect->email_prospect) ? $prospect->email_prospect : '<span class="text-danger">Non disponible</span>' !!}
                                    </td>
                                    <td class="cell2">
                                        @if(!empty($prospect->lien_prospect))
                                            <a href="{{ $prospect->lien_prospect }}" target="_blank" class="text-primary">
                                                {{ Str::limit($prospect->lien_prospect, 20) }} <!-- Limite l'affichage -->
                                            </a>
                                        @else
                                            <span class="text-danger">Non disponible</span>
                                        @endif
                                    </td>
                                    <td class="cell2">{{ $prospect->ville_prospect }}</td>
                                    <td class="cell2">
                                        @forelse ($prospect->categorieProspects as $assoc)
                                            @if ($assoc->categorie)
                                                {{ $assoc->categorie->nom_categorie }}
                                            @endif
                                        @empty
                                            Non catégorisé
                                        @endforelse
                                    </td>
                                    <td class="cell2">
                                        {{ !empty($prospect->utilisateur->name) ? $prospect->utilisateur->name : 'Personne' }}
                                    </td>

                                    @if (auth()->user()->role == 'super-admin')
                                        <td class="button-container">
                                            <div class="d-flex align-items-center gap-2"
                                                style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;">
                                                <a href="#" class="btn btn-outline-primary border-btn me-4"
                                                    data-bs-toggle="modal" data-bs-target="#update_prospect"
                                                    data-id="{{ $prospect->id }}"
                                                    data-society="{{ $prospect->nomSociete_prospect }}"
                                                    data-GSM1="{{ $prospect->GSM1_prospect }}"
                                                    data-GSM2="{{ $prospect->GSM2_prospect }}"
                                                    data-lien="{{ $prospect->lien_prospect }}"
                                                    data-name="{{ $prospect->nom_prospect }}"
                                                    data-tele="{{ $prospect->tele_prospect }}"
                                                    data-email="{{ $prospect->email_prospect }}"
                                                    data-ville="{{ $prospect->ville_prospect }}"
                                                    data-category="{{ $prospect->categories->first()?->id ?? '' }}">
                                                    Modifier
                                                </a>



                                                <button type="button" class="btn btn-outline-success border-btn me-4"
                                                    data-bs-toggle="modal" data-bs-target="#remark-{{ $prospect->id }}">
                                                    Remarque
                                                </button>




                                                <button type="button"
                                                    class="btn btn-outline-info detailButton border-btn me-4"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalProspectDetails-{{ $prospect->id }}"
                                                    data-name="{{ $prospect->nom_prospect }}"
                                                    data-email="{{ $prospect->email_prospect }}"
                                                    data-tele="{{ $prospect->tele_prospect }}"
                                                    data-ville="{{ $prospect->ville_prospect }}"
                                                    data-society-name="{{ !empty($prospect->nomSociete_prospect) ? $prospect->nomSociete_prospect : 'Particulier' }}"
                                                    data-GSM1="{{ !empty($prospect->GSM1_prospect) ? $prospect->GSM1_prospect : 'Non disponible' }}"
                                                    data-GSM2="{{ !empty($prospect->GSM2_prospect) ? $prospect->GSM2_prospect : 'Non disponible' }}"
                                                    data-lien="{{ !empty($prospect->lien_prospect) ? $prospect->lien_prospect : 'Non disponible' }}"
                                                    data-remark="{{ $prospect->remark }}"
                                                    data-user="{{ !empty($prospect->utilisateur->name) ? $prospect->utilisateur->name : 'Personne' }}">

                                                    Details
                                                </button>


                                                <form action="{{ route('prospect.destroy', $prospect->id) }}"
                                                    method="POST"
                                                    style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;"
                                                    id="delete-form-{{ $prospect->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-outline-danger border-btn me-4"
                                                        onclick="confirmDelete({{ $prospect->id }})">
                                                        Supprimer
                                                    </button>
                                                </form>


                                                <form class="user-form"
                                                    action="{{ route('user.select.prospect', $prospect->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <select class="form-select userSelect"
                                                        aria-label="Default select example"
                                                        data-prospect-id="{{ $prospect->id }}" style="margin-right:100px"
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


                                                <form class="prospect-form"
                                                    action="{{ route('prospect.select', $prospect->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <select name="status" id=""
                                                        class="form-select status-select">
                                                        <option value="" selected>Selectionner la table</option>
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
                                                    data-bs-toggle="modal" data-bs-target="#update_prospect"
                                                    data-id="{{ $prospect->id }}"
                                                    data-society="{{ $prospect->nomSociete_prospect }}"
                                                    data-GSM1="{{ $prospect->GSM1_prospect }}"
                                                    data-GSM2="{{ $prospect->GSM2_prospect }}"
                                                    data-lien="{{ $prospect->lien_prospect }}"
                                                    data-name="{{ $prospect->nom_prospect }}"
                                                    data-tele="{{ $prospect->tele_prospect }}"
                                                    data-email="{{ $prospect->email_prospect }}"
                                                    data-ville="{{ $prospect->ville_prospect }}"
                                                    data-category="{{ $prospect->categories->first()?->id ?? '' }}">
                                                    Modifier
                                                </a>


                                                <form class="user-form"
                                                    action="{{ route('user.select.prospect', $prospect->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <select class="form-select userSelect"
                                                        aria-label="Default select example"
                                                        data-prospect-id="{{ $prospect->id }}" style="margin-right:100px"
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
                                                    data-bs-toggle="modal" data-bs-target="#remark-{{ $prospect->id }}">
                                                    Remarque
                                                </button>




                                                <button type="button"
                                                    class="btn btn-outline-info detailButton border-btn me-4"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalProspectDetails-{{ $prospect->id }}"
                                                    data-name="{{ $prospect->nom_prospect }}"
                                                    data-email="{{ $prospect->email_prospect }}"
                                                    data-tele="{{ $prospect->tele_prospect }}"
                                                    data-ville="{{ $prospect->ville_prospect }}"
                                                    data-society-name="{{ !empty($prospect->nomSociete_prospect) ? $prospect->nomSociete_prospect : 'Particulier' }}"
                                                    data-GSM1="{{ !empty($prospect->GSM1_prospect) ? $prospect->GSM1_prospect : 'Non disponible' }}"
                                                    data-GSM2="{{ !empty($prospect->GSM2_prospect) ? $prospect->GSM2_prospect : 'Non disponible' }}"
                                                    data-lien="{{ !empty($prospect->lien_prospect) ? $prospect->lien_prospect : 'Non disponible' }}"
                                                    data-remark="{{ $prospect->remark }}"
                                                    data-user="{{ !empty($prospect->utilisateur->name) ? $prospect->utilisateur->name : 'Personne' }}">

                                                    Details
                                                </button>
                                                <form class="prospect-form"
                                                    action="{{ route('prospect.select', $prospect->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <select name="status" id=""
                                                        class="form-select status-select">
                                                        <option value="" selected>Selectionner la table</option>
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
                                                    data-bs-toggle="modal" data-bs-target="#remark-{{ $prospect->id }}">
                                                    Remarque
                                                </button>




                                                <button type="button"
                                                    class="btn btn-outline-info detailButton border-btn me-4"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalProspectDetails-{{ $prospect->id }}"
                                                    data-name="{{ $prospect->nom_prospect }}"
                                                    data-email="{{ $prospect->email_prospect }}"
                                                    data-tele="{{ $prospect->tele_prospect }}"
                                                    data-ville="{{ $prospect->ville_prospect }}"
                                                    data-society-name="{{ !empty($prospect->nomSociete_prospect) ? $prospect->nomSociete_prospect : 'Particulier' }}"
                                                    data-GSM1="{{ !empty($prospect->GSM1_prospect) ? $prospect->GSM1_prospect : 'Non disponible' }}"
                                                    data-GSM2="{{ !empty($prospect->GSM2_prospect) ? $prospect->GSM2_prospect : 'Non disponible' }}"
                                                    data-lien="{{ !empty($prospect->lien_prospect) ? $prospect->lien_prospect : 'Non disponible' }}"
                                                    data-remark="{{ $prospect->remark }}"
                                                    data-user="{{ !empty($prospect->utilisateur->name) ? $prospect->utilisateur->name : 'Personne' }}">

                                                    Details
                                                </button>
                                                <form class="user-form"
                                                    action="{{ route('user.select.prospect', $prospect->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <select class="form-select userSelect"
                                                        aria-label="Default select example"
                                                        data-prospect-id="{{ $prospect->id }}"
                                                        style="margin-right:100px" name="user_id">
                                                        <option value="">Contacté Par</option>
                                                        @foreach ($utilisateurs as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                                <form class="prospect-form"
                                                action="{{ route('prospect.select', $prospect->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <select name="status" id=""
                                                    class="form-select status-select">
                                                    <option value="" selected>Selectionner la table</option>
                                                    @foreach ($select as $item)
                                                        <option value="{{ $item }}">{{ $item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            </div>
                                        </td>
                                    @endif
                                    <form action="{{ route('remark.prospect', $prospect->id) }}" method="POST">
                                        @csrf
                                        <div class="modal fade" id="remark-{{ $prospect->id }}" tabindex="-1"
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
                                                            
                                                            <textarea name="remark" id="remarque" class="form-control" style="height: 100px">{{ old('remark', $prospect->remark) }}</textarea>
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

                                <div class="modal fade" id="ModalProspectDetails-{{ $prospect->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Details du Client</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">

                                                    <div class="col-6 det" style="font-size: 18px">Nom de la socité</div>
                                                    <div class="col-6 showSocietyProspect"><span style="font-size: 18px" id="showSocietyDetail-{{ $prospect->id }}"></span></div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">GSM1 de la société</strong></div>
                                                    <div class="col-6 showGSM1Prospect"><span style="font-size: 18px" id="showGSM1Detail-{{ $prospect->id }}"></span></div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">GSM2 de la société</strong></div>
                                                    <div class="col-6 showGSM2Prospect"><span style="font-size: 18px" id="showGSM2Detail-{{ $prospect->id }}"></span></div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Personne à contacter</strong></div>
                                                    <div class="col-6 showNameProspect"><span style="font-size: 18px" id="showNameDetail-{{ $prospect->id }}"></span></div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Numero De Telephone</strong></div>
                                                    <div class="col-6 showContactProspect"><span style="font-size: 18px" id="showContactDetail-{{ $prospect->id }}"></span></div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Email</strong></div>
                                                    <div class="col-6 showEmailProspect"><span style="font-size: 18px" id="showEmailDetail-{{ $prospect->id }}"></span></div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Lien de la société</strong></div>
                                                    <div class="col-6 showLienProspect"><a href="{{ $prospect->lien_prospect }}" target="_blank" class="text-primary" style="font-size: 18px">
                                                        {{ Str::limit($prospect->lien_prospect, 20) }} <!-- Limite l'affichage -->
                                                    </a></div>

                                                    <div class="col-6 det" style="font-size: 18px">Ville</strong></div>
                                                    <div class="col-6 showVilleProspect"><span style="font-size: 18px" id="showVilleDetail-{{ $prospect->id }}"></span></div>
                                            
                                            
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Les catégories</strong></div>
                                                    <div class="col-6">
                                                        <select class="form-select form-select-sm col-6 info-prospect showCategoryProspect"
                                                            aria-label=".form-select-sm example" id="categories-{{ $prospect->id }}" style="color: #5d6778">
                                                            <option class="col-6" value="" selected>Voir la(les) catégories</option>
                                                            @foreach ($prospect->allCategories as $categorie)
                                                                <option value="{{ $categorie->id }}">
                                                                    {{ $categorie->nom_categorie }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Sous-Catégorie</strong></div>
                                                    <div class="col-6">
                                                        <select class="form-select form-select-sm col-6 info-prospect showProductProspect"
                                                            aria-label=".form-select-sm example" id="products-{{ $prospect->id }}" style="color: #5d6778; font-size: 15px"><strong>
                                                            <option class="col-6" value="" selected>Voir les produits associé</option></strong>
                                                        </select>
                                                    </div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Contacté Par</strong></div>
                                                    <div class="col-6 showUserProspect"><span style="font-size: 18px" id="showUserDetail-{{ $prospect->id }}"></span></div>
                                            
                                                    <div class="col-6 det" style="font-size: 18px">Remarque</strong></div>
                                                    <div class="col-6 showRemarkProspect"><span style="font-size: 18px" id="showRemarkDetail-{{ $prospect->id }}"></span></div>
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

    @if (isset($prospect))
        <div class="modal fade" id="update_prospect" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('prospect.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="updateProspectId">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modifier le Clients</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label class="form-label"><strong class="det">Nom de la société</strong></label>
                                <input type="text" class="form-control" name="newNomSociete_prospect"
                                    placeholder="Entrer le nom de la société..." id="updateProspectSociety"
                                    value="{{ old('newNomSociete_prospect', $prospect->nomSociete_prospect) }}" />
                                @if ($errors->has('newNomSociete_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newNomSociete_prospect') }}</span><br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">GSM1 de la société</strong></label>
                                <input type="tel" class="form-control" name="newGSM1_prospect"
                                    placeholder="Entrer GSM1..." id="updateProspectGSM1"
                                    value="{{ old('newGSM1_prospect', $prospect->GSM1_prospect) }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                                @if ($errors->has('newGSM1_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newGSM1_prospect') }}</span><br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">GSM2 de la société</strong></label>
                                <input type="tel" class="form-control" name="newGSM2_prospect"
                                    placeholder="Entrer GSM2..." id="updateProspectGSM2"
                                    value="{{ old('newGSM2_prospect', $prospect->GSM2_prospect) }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                                @if ($errors->has('newGSM2_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newGSM2_prospect') }}</span><br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">Personne à contacter</strong></label>
                                <input id="updateProspectName" type="text" class="form-control"
                                    name="newNom_prospect" placeholder="Entrer le prospect..."
                                    value="{{ old('newNom_prospect', $prospect->nom_prospect) }}" />
                                @if ($errors->has('newNom_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newNom_prospect') }}</span><br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">Numeroon De Téléphone</strong></label>
                                <input id="updateProspectContact" type="tel" class="form-control"
                                    name="newTele_prospect" placeholder="Entrer le contact..."
                                    value="{{ old('newTele_prospect', $prospect->tele_prospect) }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                                @if ($errors->has('newTele_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newTele_prospect') }}</span><br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">Email</strong></label>
                                <input id="updateProspectEmail" type="email" class="form-control"
                                    name="newEmail_prospect" placeholder="Entrer l'émail..."
                                    value="{{ old('newEmail_prospect', $prospect->email_prospect) }}" />
                                @if ($errors->has('newEmail_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newEmail_prospect') }}</span><br>
                                @endif

                            </div>
                            <div>
                                <label class="form-label"><strong class="det">Lien de la société</strong></label>
                                <input type="tel" class="form-control" name="newLien_prospect"
                                    placeholder="Entrer le lien..." id="updateProspectLien"
                                    value="{{ old('newLien_prospect', $prospect->lien_prospect) }}"/>
                                @if ($errors->has('newLien_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newLien_prospect') }}</span><br>
                                @endif

                            </div>

                            <div>
                                <label class="form-label"><strong class="det">Ville</strong></label>
                                <input id="updateProspectVille" type="text" class="form-control"
                                    name="newVille_prospect" placeholder="Entrer la ville..."
                                    value="{{ old('newVille_prospect', $prospect->ville_prospect) }}" />
                                @if ($errors->has('newVille_prospect'))
                                    <span class="text-danger">
                                        {{ $errors->first('newVille_prospect') }}</span><br>
                                @endif

                            </div>

                            <div>
                                <label class="form-label"><strong class="det">Catégorie</strong></label>
                                <select id="updateProspectCategory" class="form-select form-select-sm"
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
            {{ $prospects->links('vendor.pagination.bootstrap-4') }}

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const updateProspectModal = document.getElementById('update_prospect');
            updateProspectModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;

                const prospectId = button.getAttribute('data-id');
                const prospectName = button.getAttribute('data-name');
                const prospectEmail = button.getAttribute('data-email');
                const prospectContact = button.getAttribute('data-tele');
                const prospectVille = button.getAttribute('data-ville');
                const prospectSociety = button.getAttribute('data-society');
                const prospectGSM1 = button.getAttribute('data-GSM1');
                const prospectGSM2 = button.getAttribute('data-GSM2');
                const prospectLien = button.getAttribute('data-lien');
                const prospectCategory = button.getAttribute('data-category')

                document.getElementById('updateProspectId').value = prospectId;
                document.getElementById('updateProspectName').value = prospectName;
                document.getElementById('updateProspectEmail').value = prospectEmail;
                document.getElementById('updateProspectContact').value = prospectContact;
                document.getElementById('updateProspectVille').value = prospectVille;
                document.getElementById('updateProspectSociety').value = prospectSociety;
                document.getElementById('updateProspectGSM1').value = prospectGSM1;
                document.getElementById('updateProspectGSM2').value = prospectGSM2;
                document.getElementById('updateProspectLien').value = prospectLien;
                document.getElementById('updateProspectCategory').value = prospectCategory;


            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.status-select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const form = this.closest('.prospect-form');
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
        function confirmDelete(prospectId) {
            Swal.fire({
                title: 'Supprimer le Client !',
                text: "êtes-vous sûr que vous voulez supprimer ce Client ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Oui, Supprimer-le !'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + prospectId).submit();
                    Swal.fire(
                        "Supprimé !",
                        "Le Client a été supprimé avec succès.",
                        "success"
                    );
                }
            });
        }
    </script>

    <script>
        document.querySelectorAll(`.detailButton`).forEach(button => {

            button.addEventListener('click', function() {
                const prospectId = this.getAttribute('data-bs-target').split('-').pop();
                const prospectName = this.getAttribute('data-name') || 'Non disponible'
                const prospectEmail = this.getAttribute('data-email') || 'Non disponible'
                const prospectContact = this.getAttribute('data-tele') || 'Non disponible'
                const prospectVille = this.getAttribute('data-ville')
                const prospectSociety = this.getAttribute('data-society-name')
                const prospectGSM1 = this.getAttribute('data-GSM1')
                const prospectGSM2 = this.getAttribute('data-GSM2')
                const prospectLien = this.getAttribute('data-lien')
                const prospectRemark = this.getAttribute('data-remark')
                const prospectUser = this.getAttribute('data-user')

                document.querySelector(`#showNameDetail-${prospectId}`).innerText = prospectName
                document.querySelector(`#showEmailDetail-${prospectId}`).innerText = prospectEmail
                document.querySelector(`#showContactDetail-${prospectId}`).innerText = prospectContact
                document.querySelector(`#showVilleDetail-${prospectId}`).innerText = prospectVille
                document.querySelector(`#showSocietyDetail-${prospectId}`).innerText = prospectSociety
                document.querySelector(`#showGSM1Detail-${prospectId}`).innerText = prospectGSM1
                document.querySelector(`#showGSM2Detail-${prospectId}`).innerText = prospectGSM2
                document.querySelector(`#showLienDetail-${prospectId}`).innerText = prospectLien
                document.querySelector(`#showRemarkDetail-${prospectId}`).innerText = prospectRemark
                document.querySelector(`#showUserDetail-${prospectId}`).innerText = prospectUser
            })
        });

        document.addEventListener('DOMContentLoaded', function() {

            const categories = @json($categories);
            // console.log(categories);

            document.querySelectorAll('.showCategoryProspect').forEach(selectCategory => {
                const prospectId = selectCategory.id.split('-').pop();
                const products = document.getElementById(`products-${prospectId}`);


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
    function searchProspects() {
        let input = document.getElementById('searchInput');
        let filter = input.value.toLowerCase();
        let table = document.getElementById('prospect-table');
        let tr = table.getElementsByTagName('tr');


        for (let i = 1; i < tr.length; i++) {
            let tds = tr[i].getElementsByTagName('td');
            let matchFound = false;


            for (let j = 0; j < tds.length; j++) {
                let td = tds[j];
                if (td) {
                    if (td.textContent.toLowerCase().includes(filter)) {
                        matchFound = true;
                        break;
                    }
                }
            }


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
    <div class="modal fade" id="QueryProspectDetails" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="show-info-prospect show-society">
                        <label class="label-detail-prospect">Nom de la société</label>
                        <h6 class="info-prospect" id="showSocietyProspect">
                        </h6>
                    </div>
                    <div class="show-info-prospect show-society">
                        <label class="label-detail-prospect">GSM1 de la société</label>
                        <h6 class="info-prospect" id="showGSM1Prospect">
                        </h6>
                    </div>
                    <div class="show-info-prospect show-society">
                        <label class="label-detail-prospect">GSM2 de la société</label>
                        <h6 class="info-prospect" id="showGSM2Prospect">
                        </h6>
                    </div>
                    <div class="show-info-prospect show-name">
                        <label class="label-detail-prospect">Personne à contacter</label>
                        <h6 class="info-prospect" id="showNameProspect"></h6>
                    </div>
                    <div class="show-info-prospect show-contact">
                        <label class="label-detail-prospect">Numero De Telephone</label>
                        <h6 class="info-prospect" id="showContactProspect"></h6>
                    </div>
                    <div class="show-info-prospect show-email">
                        <label class="label-detail-prospect">Email</label>
                        <h6 class="info-prospect" id="showEmailProspect">
                        </h6>
                    </div>
                    <div class="show-info-prospect show-society">
                        <label class="label-detail-prospect">Lien de la société</label>
                        <h6 class="info-prospect" id="showLienProspect">
                        </h6>
                    </div>

                    <div class="show-info-prospect show-ville">
                        <label class="label-detail-prospect">Ville</label>
                        <h6 class="info-prospect" id="showVilleProspect">
                        </h6>
                    </div>
                    <div class="show-info-prospect show-category" style="margin-top:10px">
                        <label class="label-detail-prospect">Les catégories</label>
                        <select class="form-select form-select-sm info-prospect showCategoryProspect"
                            aria-label=".form-select-sm example" style="width: 200px; height: 30px"
                            id="categoriesQuery-1">
                            <option value="" selected>Voir la(les) catégories</option>

                        </select>
                    </div>

                    <div class="show-info-prospect show-product" style="margin-bottom: 40px; margin-top:10px">
                        <label class="form-label label-detail-prospect">Sous-Catégorie</label>
                        <select class="form-select form-select-sm info-prospect showProductProspect"
                            aria-label=".form-select-sm example" id="productsQuery-1" style="width: 200px; height: 30px">

                        </select>
                    </div>
                    <div class="show-info-prospect show-user">
                        <label class="label-detail-prospect">Contacté Par</label>
                        <h6 class="info-prospect" id="showUserProspect">
                        </h6>
                    </div>
                    <div class="show-info-prospect show-remark">
                        <label class="label-detail-prospect">Remarque</label>
                        <p class="info-prospect" id="showRemarkProspect" style="font-size: 12px">
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
