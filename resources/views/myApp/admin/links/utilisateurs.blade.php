@extends('myApp.admin.adminLayout.adminPage')

@section('search-bar')
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: #404242">LES UTILISATEURS</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form action="{{ route('search.users') }}" method="GET" class="table-search-form row gx-1 align-items-center">
                            <div class="col-auto">
                                <input type="text" name="search"
                                    class="form-control search-orders" placeholder="Recherche ... ">
                            </div>
                        </form>

                    </div><!--//col-->

                    <div class="col-auto d-flex align-items-center gap-2">
                        <a class="btn app-btn-secondary" href="{{ route('users.pdf') }}"><i class="fas fa-file-pdf"></i> Exporter en pdf</a>
                        <a href="{{ route('export.users') }}" class="btn app-btn-secondary"><i class="fas fa-file-excel"></i> Exporter en excel</a>
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

            if (modalType === 'update') {
                var updateModal = new bootstrap.Modal(document.getElementById('updateUserModal'));
                updateModal.show();
            } else if (modalType === 'default') {
                var addModal = new bootstrap.Modal(document.getElementById('ModalAddUser'));
                addModal.show();
            }
        });
    </script>
@endsection
@section('content')
                <div id="modals" style="display:none;" data-error="{{ session('modalType') }}"></div>


                <div>
                    <form action="/addUser" method="POST">
                        @csrf
                        <div class="modal fade" id="ModalAddUser" tabindex="-1" aria-labelledby="ModalAddUserLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un utilisateur
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                    
                                        <div class="mb-3">
                                            <label class="form-label"><strong class="det">Nom</strong></label>
                                            <input type="text" class="form-control" name="name" placeholder="Entrer le nom..."
                                                value="{{ old('name') }}">
                                            @error('name', 'default')
                                            <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                    
                                        <div class="mb-3">
                                            <label class="form-label"><strong class="det">Email</strong></label>
                                            <input type="email" class="form-control" name="email" placeholder="Entrer l'email..."
                                                value="{{ old('email') }}">
                                            @error('email', 'default')
                                            <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                    
                                        <div class="mb-3">
                                            <label class="form-label"><strong class="det">Mot de
                                                    passe</strong></label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Entrer le mot de passe...">
                                            @error('password', 'default')
                                            <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                    
                                        <div class="mb-3">
                                            <label class="form-label"><strong class="det">Confirmer le mot de passe</strong></label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                placeholder="Confirmer votre mot de passe...">
                                            @error('password_confirmation', 'default')
                                            <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                    
                                        <div class="mb-3">
                                            <label class="form-label"><strong class="det">Adresse</strong></label>
                                            <input type="text" class="form-control" name="adresse" placeholder="Entrer l'adresse..."
                                                value="{{ old('adresse') }}">
                    
                                            @error('adresse', 'default')
                                            <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                    
                                        <div class="mb-3">
                                            <label class="form-label"><strong class="det">Contact</strong></label>
                                            <input type="tel" class="form-control" required name="contact" placeholder="Entrer le contact..."
                                                value="{{ old('contact') }}" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            @error('contact', 'default')
                                            <span class="text-danger">{{ $message }}</span> 
                                            @enderror
                                        </div>
                    
                                        <div class="mb-3">
                                            <label class="form-label"><strong class="det">Rôle</strong></label>
                                            <select class="form-select" id="" name="role" style="color: #5d677c;">
                                                <option value="">Sélectionner le rôle</option>
                                                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="utilisateur" {{ old('role')=='utilisateur' ? 'selected' : '' }}>Utilisateur
                                                </option>
                                                <option value="super-admin" {{ old('role')=='super-admin' ? 'selected' : '' }}>Super Admin
                                                </option>
                                            </select>
                                            @error('role', 'default')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                    
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal"
                                                value="Ajouter">Ajouter</button>
                                        </div>
                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>



                    <div class="tab-content" id="orders-table-tab-content">
                        <div class="tab-pane fade show active" id="orders-all" role="tabpanel"
                            aria-labelledby="orders-all-tab">
                            <div class="app-card app-card-orders-table shadow-sm mb-5">
                                <div class="app-card-body">
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="table app-table-hover mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="cell">Nom complet</th>
                                                        <th class="cell">Email</th>
                                                        <th class="cell">Contact</th>
                                                        <th class="cell">Adresse</th>
                                                        <th class="cell">Rôle</th>
                                                        <th class="cell text-end"><button type="button" class="btn app-btn-secondary"
                                                            data-bs-toggle="modal" data-bs-target="#ModalAddUser">
                                                            Ajouter
                                                        </button></th>
                                                      
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    @foreach ($users as $user)
                                                    <tr>
                                                        <td class="cell2">{{ $user->name }}</td>
                                                        <td class="cell2">{{ $user->email }}</td>
                                                        <td class="cell2">{{ $user->contact }}</td>
                                                        <td class="cell2">{{ $user->adresse }}</td>
                                                        <td class="cell2">{{ $user->role }}</td>
                                                        <td><a href="{{ route('admin.permissions.edit', $user->id) }}" class="btn btn-outline-warning border-btn me-4">
                                                            <i class="bi bi-shield-lock"></i> Gérer permissions
                                                        </a>
                                                            <button type="button" class="btn btn-outline-primary border-btn me-4" data-bs-toggle="modal"
                                                                data-bs-target="#updateUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                                data-email="{{ $user->email }}" data-contact="{{ $user->contact }}" data-adresse="{{ $user->adresse }}"
                                                                data-role="{{ $user->role }}">Modifier</button>

                                                                <button type="button" class="btn btn-outline-info border-btn me-4"
                                                                        data-bs-toggle="modal" data-bs-target="#detailsUserModal"
                                                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                                        data-email="{{ $user->email }}" data-contact="{{ $user->contact }}"
                                                                        data-adresse="{{ $user->adresse }}" data-role="{{ $user->role }}">
                                                                        Détails
                                                                </button>
                                                                
                                                                <form action="{{ route('user.destroy', $user->id) }}" id="delete-form-{{ $user->id }}" method="POST"
                                                                    style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-outline-danger border-btn"
                                                                        onclick="confirmDelete({{ $user->id }})">Supprimer</button>
                                                                </form>
                                                                
                                                        </td>
                                                        <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="updateUserModalLabel">Modifier
                                                                            l'utilisateur</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="/updateUser" method="POST">
                                                                        @csrf
                                                                     <div class="modal-body">
                                                                        <input type="hidden" name="id" value="{{ $user->id }}" id="updateUserId">
                                                                       
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong class="det">Nom</strong></label>
                                                                                <input type="text" class="form-control" id="updateUserName" name="newName"
                                                                                    placeholder="Entrer le nom..." value="{{ old('newName', $user->name) }}">
                                                                                @if ($errors->has('newName'))
                                                                                <span class="text-danger">
                                                                                    {{ $errors->first('newName') }}</span>
                                                                                @endif
                                                                            </div>
                                                
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong class="det">Email</strong></label>
                                                                                <input type="email" class="form-control" id="updateUserEmail" name="newEmail"
                                                                                    placeholder="Entrer l'email..." value="{{ old('newEmail', $user->email) }}">
                                                                                @if ($errors->has('newEmail'))
                                                                                <span class="text-danger">
                                                                                    {{ $errors->first('newEmail') }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong class="det">Adresse</strong></label>
                                                                                <input type="text" class="form-control" id="updateUserAdresse" name="newAdresse"
                                                                                    placeholder="Entrer l'adresse..." value="{{ old('newAdresse', $user->adresse) }}">
                                                                                @if ($errors->has('newAdresse'))
                                                                                <span class="text-danger">
                                                                                    {{ $errors->first('newAdresse') }}</span>
                                                                                @endif
                                                                            </div>
                                                
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong class="det">Contact</strong></label>
                                                                                <input type="tel" class="form-control" id="updateUserContact" name="newContact"
                                                                                    placeholder="Entrer le contact..." required value="{{ old('newContact', $user->contact) }}">
                                                                                @if ($errors->has('newContact'))
                                                                                <span class="text-danger">
                                                                                    {{ $errors->first('newContact') }}</span>
                                                                                @endif
                                                                            </div>
                                                
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong class="det">Rôle</strong></label>
                                                                                <select id="updateUserRole" class="form-select" name="newRole" style="color: #5d677c;">
                                                                                    <option value="admin" {{ old('newRole', $user->role) == 'admin' ? 'selected' : ''
                                                                                        }}>Admin</option>
                                                                                    <option value="utilisateur" {{ old('newRole', $user->role) == 'utilisateur' ?
                                                                                        'selected'
                                                                                        : '' }}>Utilisateur</option>
                                                                                    <option value="super-admin" {{ old('newRole', $user->role) == 'super-admin' ?
                                                                                        'selected'
                                                                                        : '' }}>Super Admin</option>
                                                                                </select>
                                                                                @if ($errors->has('newRole'))
                                                                                <span class="text-danger">
                                                                                    {{ $errors->first('newRole') }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong class="det">Entrer le mot de
                                                                                        passe</strong></label>
                                                                                <input type="password" class="form-control" name="newPassword"
                                                                                    placeholder="Entrer le mot de passe...">
                                                                                @if ($errors->has('newPassword'))
                                                                                <span class="text-danger">
                                                                                    {{ $errors->first('newPassword') }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label"><strong class="det">Confirmer
                                                                                        le mot de passe</strong></label>
                                                                                <input type="password" class="form-control" name="newPassword_confirmation"
                                                                                    placeholder="Confirmer le mot de passe...">
                                                                                @if ($errors->has('newPassword_confirmation'))
                                                                                <span class="text-danger">
                                                                                    {{ $errors->first('newPassword_confirmation') }}</span>
                                                                                @endif
                                                                            </div>
                                                
                                                                            <div class="d-grid">
                                                                                <button type="submit" class="btn btn-primary">Modifier</button>
                                                                            </div>
                                                                        
                                                                    </div>
                                                                </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </tr>
                                               

                                                    <div class="modal fade" id="detailsUserModal" tabindex="-1" aria-labelledby="detailsUserModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailsUserModalLabel">Détails de l'utilisateur</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body px-md-5">
                                                                    <div class="row">
                                                                        <div class="col-4 det" style="font-size: 18px"> Nom :  </div>
                                                                        <div class="col-6"> <span style="font-size: 18px" id="detailsUserName"></span> </div>
                                                    
                                                                        <div class="col-4 det" style="font-size: 18px"> Email : </div>
                                                                        <div class="col-6"> <span style="font-size: 18px" id="detailsUserEmail"> </span></div>
                                                    
                                                                        <div class="col-4 det" style="font-size: 18px"> Contact : </div>
                                                                        <div class="col-6"> <span style="font-size: 18px" id="detailsUserContact"></span> </div>
                                                    
                                                                        <div class="col-4 det" style="font-size: 18px"> Adresse : </div>
                                                                        <div class="col-6"> <span style="font-size: 18px" id="detailsUserAdresse"></span> </div>
                                                    
                                                                        <div class="col-4 det" style="font-size: 18px"> Rôle : </div>
                                                                        <div class="col-6"> <span style="font-size: 18px" id="detailsUserRole"></span> </div>
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



                        <div>
                          
                            <div>
                                {{ $users->links('vendor.pagination.bootstrap-4') }}

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
            document.getElementById("toggleDetailsPassword").addEventListener("click", function () {
                let passwordInput = document.getElementById("detailsUserPassword");
                let icon = this.querySelector("i");
        
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.replace("fa-eye", "fa-eye-slash");
                } else {
                    passwordInput.type = "password";
                    icon.classList.replace("fa-eye-slash", "fa-eye");
                }
            });
        </script>
        
           <script>
            document.addEventListener("DOMContentLoaded", function () {
                var detailsModal = document.getElementById('detailsUserModal');
        
                detailsModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    document.getElementById('detailsUserName').innerText = button.getAttribute('data-name');
                    document.getElementById('detailsUserEmail').innerText = button.getAttribute('data-email');
                    document.getElementById('detailsUserContact').innerText = button.getAttribute('data-contact');
                    document.getElementById('detailsUserAdresse').innerText = button.getAttribute('data-adresse');
                    document.getElementById('detailsUserRole').innerText = button.getAttribute('data-role');
                });
            });
        </script>
        

           <script>
               document.addEventListener("DOMContentLoaded", function() {
                   const updateUserModal = document.getElementById('updateUserModal');
                   updateUserModal.addEventListener('show.bs.modal', event => {
                       const button = event.relatedTarget;
                       const userId = button.getAttribute('data-id');
                       const userName = button.getAttribute('data-name');
                       const userEmail = button.getAttribute('data-email');
                       const userContact = button.getAttribute('data-contact');
                       const userAdresse = button.getAttribute('data-adresse');
                       const userRole = button.getAttribute('data-role');

                       document.getElementById('updateUserId').value = userId;
                       document.getElementById('updateUserName').value = userName;
                       document.getElementById('updateUserEmail').value = userEmail;
                       document.getElementById('updateUserContact').value = userContact;
                       document.getElementById('updateUserAdresse').value = userAdresse;
                       document.getElementById('updateUserRole').value = userRole;
                   });
               });
           </script>

           <script>
               function confirmDelete(userId) {
                   Swal.fire({
                       title: 'Supprimer l\'utilisateur !',
                       text: "êtes-vous sûr que vous voulez supprimer cet utilisateur ?",
                       icon: 'warning',
                       showCancelButton: true,
                       confirmButtonColor: '#d33',
                       cancelButtonColor: '#3085d6',
                       cancelButtonText: 'Annuler',
                       confirmButtonText: 'Oui, Supprimer-le !'
                   }).then((result) => {
                       if (result.isConfirmed) {
                           document.getElementById('delete-form-' + userId).submit();
                           Swal.fire(
                                "Supprimé !",
                                "L'utilisateur' a été supprimé avec succès.",
                                "success"
                            );
                       }
                   });
               }
           </script>

           <script>
               document.querySelectorAll('button[data-bs-toggle="modal"]').forEach(button => {
                   button.addEventListener('click', function() {
                       const userName = this.getAttribute('data-user-name')
                       const userEmail = this.getAttribute('data-user-email')
                       const userContact = this.getAttribute('data-user-contact')
                       const userAdress = this.getAttribute('data-user-adresse')
                       const userProduct = this.getAttribute('data-user-product')
                       const userCategory = this.getAttribute('data-user-product-category')

                       document.querySelector('#showNameUser').innerText = userName
                       document.querySelector('#showEmailUser').innerText = userEmail
                       document.querySelector('#showContactUser').innerText = userContact
                       document.querySelector('#showAdressUser').innerText = userAdress
                       document.querySelector('#showProductUser').innerText = userProduct
                       document.querySelector('#showCategoryUser').innerText = userCategory
                   })

               });
           </script>
           <script>
               document.addEventListener('DOMContentLoaded', function() {
                   const searchInput = document.querySelector('input[name="search"]');

                   searchInput.addEventListener('keydown', function(event) {
                       if (event.key === 'Enter') {
                           event.preventDefault();
                       }
                   });

                   searchInput.addEventListener('input', function() {
                       const searchQuery = searchInput.value;

                       if (searchQuery.length > 0) {
                           fetch(`/search-users?search=${searchQuery}`)
                               .then(response => response.json())
                               .then(data => {
                                   console.log(data)
                                   const tbody = document.querySelector('tbody');
                                   tbody.innerHTML = '';

                                   data.forEach(user => {




                                       const row = document.createElement('tr');
                                       row.innerHTML = `
                                        <td class="cell2">${user.name}</td>
                                        <td class="cell2">${user.email}</td>
                                        <td class="cell2">${user.contact}</td>
                                        <td class="cell2">${user.adresse}</td>
                                        <td class="cell2">${user.role}</td>
                                        <td class="cell2">
                                                       <a class="btn btn-outline-primary border-btn me-4" data-bs-toggle="modal"
                                                           data-bs-target="#updateUserModal"
                                                           data-id="${user.id}"
                                                           data-name="${user.name}"
                                                           data-email="${user.email}"
                                                           data-contact="${user.contact}"
                                                           data-adresse="${user.adresse}"
                                                           data-role="${user.role}"
                                                           >
                                                           Modifier
                                                       </a>
                                                       <button type="button" class="btn btn-outline-info border-btn me-4"
                                                                        data-bs-toggle="modal" data-bs-target="#detailsUserModal"
                                                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                                        data-email="{{ $user->email }}" data-contact="{{ $user->contact }}"
                                                                        data-adresse="{{ $user->adresse }}" data-role="{{ $user->role }}">
                                                                        Détails
                                                                </button>
                                        


                                        <form action="{{ route('user.destroy', $user->id) }}" id="delete-form-${user.id}" method="POST"
                                                               style="display: inline; border-radius: 1cap; border-style: inherit; color: transparent;">

                                            @method('DELETE')
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="button" class="btn btn-outline-danger border-btn"
                                                    onclick="confirmDelete(${user.id})">Supprimer</button>
                                        </form>
                                        </td>
                                        `
                                       tbody.appendChild(row);
                                   });

                                   document.querySelectorAll('button[data-bs-toggle="modal"]').forEach(
                                       button => {
                                           button.addEventListener('click', function() {
                                               const userName = this.getAttribute(
                                                   'data-user-name');
                                               const userEmail = this.getAttribute(
                                                   'data-user-email');
                                               const userContact = this.getAttribute(
                                                   'data-user-contact');
                                               const userAdresse = this.getAttribute(
                                                   'data-user-adresse');
                                               const userRole = this.getAttribute(
                                                   'data-user-role');



                                               document.querySelector('#showNameUser').innerText =
                                                   userName;
                                               document.querySelector('#showEmailUser').innerText =
                                                   userEmail;
                                               document.querySelector('#showContactUser')
                                                   .innerText = userContact;
                                               document.querySelector('#showAdressUser')
                                                   .innerText = userAdresse;
                                               document.querySelector('#showRoleUser').innerText =
                                                   userRole;


                                           });
                                       });
                               })
                               .catch(error => {
                                   console.error('Error fetching users:', error);
                               });
                       } else {
                           location.reload();
                       }
                   });
               });
           </script>
       @endsection
