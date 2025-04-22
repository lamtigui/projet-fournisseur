@extends('myApp.admin.adminLayout.adminPage')
@section('search-bar')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: #404242">LES SOUS-CATEGORIES</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form action="#" method="GET"
                            class="table-search-form row gx-1 align-items-center">
                            <div class="col-auto">
                                <input type="text" id="searchInput" name="search" class="form-control search-orders"
                                    placeholder="Recherche ... " onkeyup="searchSousCategorie()">
                            </div>
                        </form>
                    </div><!--//col-->
                    <div class="col-auto">
                        @if (auth()->user()->role == 'super-admin')
                            <a class="btn app-btn-secondary" href="{{ route('sousCategories.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter en pdf</a>
                            <a href="{{ route('export.sous-categories') }}" class="btn app-btn-secondary"><i class="fas fa-file-excel"></i> Exporter en excel</a>

                        @elseif (auth()->user()->role == 'admin')
                        <a class="btn app-btn-secondary" href="{{ route('sousCategories.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter en pdf</a>
                        <a href="{{ route('export.sous-categories') }}" class="btn app-btn-secondary"><i class="fas fa-file-excel"></i> Exporter en excel</a>
                        @endif
                    </div>
                </div><!--//row-->
            </div><!--//table-utilities-->
        </div><!--//col-auto-->
    </div><!--//row-->
@endsection
@section('parties-prenantes')
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a href="/categoriesSection" class="flex-sm-fill text-sm-center nav-link">Categories</a>
        <a href="#" class="flex-sm-fill text-sm-center nav-link active">Sous-Categories</a>
    </nav>
@endsection

@section('errorContent')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalType = document.getElementById('update_add_modals').getAttribute('data-error')

            if (modalType === 'default') {
                var addModal = new bootstrap.Modal(document.getElementById('ModalAddProduct'))
                addModal.show();
            } else if (modalType === 'update') {
                var updateModal = new bootstrap.Modal(document.getElementById('updateProductModal'))
                updateModal.show();
            }
        })
    </script>
@endsection
@section('content')
    <div>
        <div id="update_add_modals" style="display: none" data-error="{{ session('modalType') }}">

        </div>

        <form action="/addSousCategory" method="POST">
            @csrf
            <div class="modal fade" id="ModalAddProduct" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter un produit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label"><strong class="det">Nom de la sous-catégorie</strong></label>
                                <input type="text" class="form-control" name="nom_produit"
                                    placeholder="Entrer la sous-catégorie" value="{{ old('nom_produit') }}" />
                                @error('nom_produit', 'default')
                                    <span class="text-danger">{{ $message }}</span> <br>
                                @enderror


                                <div class="mb-3">
                                    <label class="form-label"><strong class="det">Description</strong></label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1"  placeholder="Entrer une description"
                                        name="texte" style="height: 100px">{{ old('texte') }}</textarea>
                                    @error('texte', 'default')
                                        <span class="text-danger">{{ $message }}</span> <br>
                                    @enderror
                                </div>


                                <label class="form-label"><strong class="det">
                                        Catégorie :</strong></label>
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                    name="categorie_id" style="height: 39px">
                                    <option value="">Selectionner la catégorie</option>
                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                            {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom_categorie }}</option>
                                    @endforeach
                                </select>
                                @error('categorie_id', 'default')
                                    <span class="text-danger">{{ $message }}</span> <br>
                                @enderror



                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" data-bs-dismiss="modal" value="Ajouter">
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <!---->


        <div class="page-inner">
            <div class="app-card app-card-orders-table mb-5">
                <div class="app-card-body">
                    <div class="table-responsive">
                        <table id="souscategorie-table" class="table mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="cell">Nom du produit</th>

                                    <th class="cell">Catégorie</th>
                                    <th class="cell text-end">
                                        @if (auth()->user()->role == 'super-admin')
                                            <button type="button" class="btn app-btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#ModalAddProduct">
                                                Ajouter
                                            </button>
                                        @elseif (auth()->user()->role == 'admin')
                                            <button type="button" class="btn app-btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#ModalAddProduct">
                                                Ajouter
                                            </button>
                                        @endif
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($getSousCategories as $sousCategorie)
                                    <tr>
                                        <td class="cell2">{{ $sousCategorie->nom_produit }}</td>
                                        <td class="cell2">{{ $sousCategorie->categorie->nom_categorie }}</td>
                                        @if (auth()->user()->role == 'super-admin')
                                            <td>
                                                <button type="button" class="btn btn-outline-primary border-btn me-5"
                                                    data-bs-toggle="modal" data-bs-target="#updateProductModal"
                                                    data-id={{ $sousCategorie->id }}
                                                    data-name={{ $sousCategorie->nom_produit }}
                                                    data-texte={{ $sousCategorie->texte }}
                                                    data-categorie_id={{ $sousCategorie->categorie_id }}>Modifier</button>

                                                <button type="button"
                                                    class="btn btn-outline-info border-btn me-5 detailButton"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalProductDetail-{{ $sousCategorie->id }}"
                                                    data-name="{{ $sousCategorie->nom_produit }}"
                                                    data-category="{{ $sousCategorie->categorie->nom_categorie }}"
                                                    data-texte = "{{ $sousCategorie->texte }}">
                                                    Details
                                                </button>

                                                <form action="{{ route('product.destroy', $sousCategorie->id) }}"
                                                    method="POST"
                                                    style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;"
                                                    id="delete-form-{{ $sousCategorie->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-outline-danger border-btn"
                                                        onclick="confirmDelete({{ $sousCategorie->id }})">Supprimer</button>
                                                </form>

                                            </td>
                                        @elseif (auth()->user()->role == 'admin')
                                            <td>
                                                <button type="button" class="btn btn-outline-primary border-btn me-5"
                                                    data-bs-toggle="modal" data-bs-target="#updateProductModal"
                                                    data-id={{ $sousCategorie->id }}
                                                    data-name={{ $sousCategorie->nom_produit }}
                                                    data-texte={{ $sousCategorie->texte }}
                                                    data-categorie_id={{ $sousCategorie->categorie_id }}>Modifier</button>

                                                <button type="button"
                                                    class="btn btn-outline-info border-btn me-5 detailButton"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalProductDetail-{{ $sousCategorie->id }}"
                                                    data-name="{{ $sousCategorie->nom_produit }}"
                                                    data-category="{{ $sousCategorie->categorie->nom_categorie }}"
                                                    data-texte = "{{ $sousCategorie->texte }}">
                                                    Details
                                                </button>
                                            </td>
                                        @elseif (auth()->user()->role == 'utilisateur')
                                            <td>
                                                <button type="button"
                                                    class="btn btn-outline-info border-btn me-5 detailButton"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalProductDetail-{{ $sousCategorie->id }}"
                                                    data-name="{{ $sousCategorie->nom_produit }}"
                                                    data-category="{{ $sousCategorie->categorie->nom_categorie }}"
                                                    data-texte = "{{ $sousCategorie->texte }}">
                                                    Details
                                                </button>
                                            </td>
                                        @endif

                                        <div class="modal fade" id="ModalProductDetail-{{ $sousCategorie->id }}"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Details de SousCategorie</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="col-4 det" style="font-size: 20px">Produit</div>
                                                            <div class="col-8 showProduct"><span style="font-size: 17px" id="showProduct-{{ $sousCategorie->id }}"></span></div>

                                                            <div class="col-4 det" style="font-size: 20px">Description</div>
                                                            <div class="col-8 showTextProduct"><span style="font-size: 17px" id="showText-{{ $sousCategorie->id }}"></span></div>

                                                            <div class="col-4 det" style="font-size: 20px">Catégorie</div>
                                                            <div class="col-8 showCategoryProduct"><span style="font-size: 17px" id="showCategory-{{ $sousCategorie->id }}"></span></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/updateProduct" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="updateProductId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modifier le produit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label"><strong class="det">Nom de sous-catégorie</strong></label>
                            <input type="text" class="form-control" name="newNom_produit" id="updateProductName"
                                placeholder="Entrer la sous-catégorie" value="{{ old('newNom_produit') }}" />
                            @if ($errors->has('newNom_produit'))
                                <span class="text-danger">{{ $errors->first('newNom_produit') }}</span>
                            @endif

                            <div class="mb-3">
                                <label class="form-label"><strong class="det">Description</strong></label>
                                <textarea class="form-control" id="updateProductText" placeholder="Entrer une description" name="newTexte" style="height: 100px">{{ old('newTexte', htmlspecialchars($sousCategorie->texte)) }} </textarea>
                                @if ($errors->has('newTexte'))
                                    <span class="text-danger">{{ $errors->first('newTexte') }}</span>
                                @endif
                            </div>


                            <label><strong class="det">Catégorie</strong></label>
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="newCategorie_id" id="updateProductCategoryId" style="color: #797878;">
                                <option value="">Selectionner la catégorie</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}"
                                        {{ old('newCategorie_id') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom_categorie }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('newCategorie_id'))
                                <span class="text-danger">{{ $errors->first('newCategorie_id') }}</span> <br>
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
    <div>
       
        <div>
            {{ $getSousCategories->links('vendor.pagination.bootstrap-4') }}

        </div>
    </div>
@endsection
@section('content2')
    <div class="modal fade" id="QueryModalProductDetail" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="show-info-product ">
                        <label class="label-detail-product"><strong class="det">Produit</strong></label>
                        <h6 class="info-product" id="showProduct">
                        </h6>
                    </div>
                    <div class="show-info-product ">
                        <label class="label-detail-product"><strong class="det">Description</strong></label>
                        <h6 class="info-product" id="showTextProduct">
                        </h6>
                    </div>
                    <div class="show-info-product ">
                        <label class="label-detail-product"><strong class="det">Catégorie</strong></label>
                        <h6 class="info-product" id="showCategoryProduct">
                        </h6>
                    </div>

                </div>

            </div>
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
    <script>
        document.addEventListener(("DOMContentLoaded"), function() {
            const updateProductModal = document.getElementById('updateProductModal');
            updateProductModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-id');
                const productName = button.getAttribute('data-name');
                const productTexte = button.getAttribute('data-texte');
                const productCategorieId = button.getAttribute('data-categorie_id')

                document.getElementById('updateProductId').value = productId;
                document.getElementById('updateProductName').value = productName;
                document.getElementById('updateProductText').value = productTexte;
                document.getElementById('updateProductCategoryId').value = productCategorieId;
            })

        })
    </script>

    <script>
        function confirmDelete(productId) {
            Swal.fire({
                title: 'Supprimer ce produit !',
                text: "êtes-vous sûr que vous voulez supprimer ce produit ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Oui, Supprimer-le !'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + productId).submit();
                    Swal.fire(
                        "Supprimé !",
                        "Le produit a été supprimé avec succès.",
                        "success"
                    );
                }
            });
        }
    </script>

    <script>
        document.querySelectorAll('.detailButton').forEach(button => {
            button.addEventListener('click', function() {

                const productId = this.getAttribute('data-bs-target').split('-').pop();
                const productName = this.getAttribute('data-name')
                const categoryName = this.getAttribute('data-category')
                const productText = this.getAttribute('data-texte')

                document.querySelector(`#showProduct-${productId}`).innerText = productName
                document.querySelector(`#showText-${productId}`).innerText = productText
                document.querySelector(`#showCategory-${productId}`).innerText = categoryName
            })

        });
    </script>
  <script>
    function searchSousCategorie() {
        let input = document.getElementById('searchInput');
        let filter = input.value.toLowerCase();
        let table = document.getElementById('souscategorie-table');
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
