@extends('myApp.admin.adminLayout.adminPage')
@section('title')
    Profile
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalType = document.getElementById('modals').getAttribute('data-error');
            if (modalType === 'updatePassword') {
                var updateModal = new bootstrap.Modal(document.getElementById('editPassword'));
                updateModal.show();
            }
        });
    </script>
@endsection
@section('info-edit-user')
    <div id="modals" style="display: none" data-error="{{ session('modalType') }}"></div>
    <div class="row g-3 needs-validation form-profile">
        <div class="container-xl">
            <h1 class="app-page-title" style="">Mon Compte</h1>
            <div class="row gy-4">
                <form id="profileForm" action="{{ route('update.user.auth') }}" class="col-12 col-lg-6" method="POST"
                    novalidate>
                    @csrf
                    <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="col-auto">
                                    <div class="app-icon-holder">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                        </svg>
                                    </div><!--//icon-holder-->
                                </div><!--//col-->
                                <div class="col-auto">
                                    <h4 class="app-card-title">Profil</h4>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body px-4 w-100">
                            <div class="item border-bottom py-3">
                                <div class="justify-content-between align-items-center">
                                    <div class="">
                                        <div class="item-label"><strong>Nom</strong></div>
                                        <input type="text" id="newName" name="newName" class="item-data"
                                            value="{{ old('newName', $user->name) }}"
                                            style="border: none; background: transparent; width: 100%; 
          font-size: inherit; color: #5d677c; outline: none;"
                                            required>
                                        @error('newName')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div><!--//col-->
                                </div><!--//row-->
                            </div><!--//item-->
                            <div class="item border-bottom py-3">
                                <div class="justify-content-between align-items-center">
                                    <div class="">
                                        <div class="item-label"><strong>Contact</strong></div>
                                        <input type="tel" id="newContact" name="newContact" class="item-data"
                                            value="{{ old('newContact', $user->contact) }}"
                                            style="border: none; background: transparent; width: 100%; 
                                                    font-size: inherit; color: #5d677c; outline: none;"
                                            required>
                                        @error('newContact')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div><!--//col-->
                                </div><!--//row-->
                            </div><!--//item-->
                            <div class="item border-bottom py-3">
                                <div class="justify-content-between align-items-center">
                                    <div class="">
                                        <div class="item-label"><strong>Adresse</strong></div>
                                        <input type="text" id="newAdresse" name="newAdresse" class="item-data"
                                            value="{{ old('newAdresse', $user->adresse) }}"
                                            style="border: none; background: transparent; width: 100%; 
          font-size: inherit; color: #5d677c; outline: none;">
                                        @error('newAdresse')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div><!--//col-->
                                </div><!--//row-->
                            </div><!--//item-->
                            @if ($user->role == 'super-admin')
                                <div class="item border-bottom py-3">
                                    <div class="justify-content-between align-items-center">
                                        <div class="">
                                            <div class="item-label"><strong>Rôle</strong></div>
                                            <select id="newRole" name="newRole" class="item-data"
                                                style="border: none; background: transparent; width: 100%; 
                             font-size: inherit; color: #5d677c; outline: none;"
                                                required>
                                                <option value="super-admin"
                                                    {{ old('newRole', $user->role) == 'super-admin' ? 'selected' : '' }}>
                                                    Super
                                                    Admin</option>
                                                <option value="admin"
                                                    {{ old('newRole', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="utilisateur"
                                                    {{ old('newRole', $user->role) == 'utilisateur' ? 'selected' : '' }}>
                                                    Utilisateur</option>
                                            </select>
                                            @error('newRole')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div><!--//col-->
                                    </div><!--//row-->
                                </div><!--//item-->
                            @endif
                        </div><!--//app-card-body-->
                        <div class="app-card-footer p-4 mt-auto">
                            <!--<a class="btn app-btn-secondary" href="#" onclick="updateProfile()">Mettre à jour Profil</a>-->
                            <button class="btn app-btn-secondary" type="submit">Mettre à jour
                                Profil</button>
                        </div><!--//app-card-footer-->
                    </div><!--//app-card-->
                </form>
                <form action="{{ route('updateSecurity') }}" method="POST" class="col-12 col-lg-6" id="securityForm"
                    novalidate>
                    @csrf
                    <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="col-auto">
                                    <div class="app-icon-holder">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-shield-check"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5.443 1.991a60.17 60.17 0 0 0-2.725.802.454.454 0 0 0-.315.366C1.87 7.056 3.1 9.9 4.567 11.773c.736.94 1.533 1.636 2.197 2.093.333.228.626.394.857.5.116.053.21.089.282.11A.73.73 0 0 0 8 14.5c.007-.001.038-.005.097-.023.072-.022.166-.058.282-.111.23-.106.525-.272.857-.5a10.197 10.197 0 0 0 2.197-2.093C12.9 9.9 14.13 7.056 13.597 3.159a.454.454 0 0 0-.315-.366c-.626-.2-1.682-.526-2.725-.802C9.491 1.71 8.51 1.5 8 1.5c-.51 0-1.49.21-2.557.491zm-.256-.966C6.23.749 7.337.5 8 .5c.662 0 1.77.249 2.813.525a61.09 61.09 0 0 1 2.772.815c.528.168.926.623 1.003 1.184.573 4.197-.756 7.307-2.367 9.365a11.191 11.191 0 0 1-2.418 2.3 6.942 6.942 0 0 1-1.007.586c-.27.124-.558.225-.796.225s-.526-.101-.796-.225a6.908 6.908 0 0 1-1.007-.586 11.192 11.192 0 0 1-2.417-2.3C2.167 10.331.839 7.221 1.412 3.024A1.454 1.454 0 0 1 2.415 1.84a61.11 61.11 0 0 1 2.772-.815z" />
                                            <path fill-rule="evenodd"
                                                d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                        </svg>
                                    </div><!--//icon-holder-->
                                </div><!--//col-->
                                <div class="col-auto">
                                    <h4 class="app-card-title">Sécurité</h4>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body px-4 w-100">
                            <div class="item border-bottom py-3">
                                <div class="justify-content-between align-items-center">
                                    <div class="">
                                        <div class="item-label"><strong>Email</strong></div>
                                        <input type="text" id="displayEmail" class="item-data" name="email"
                                            value="{{ old('email', $user->email) }}" readonly
                                            style="border: none; background: transparent; width: 100%; 
                                        font-size: inherit; color: #5d677c; outline: none;"
                                            data-email="{{ old('newEmail', $user->email) }}">
                                    </div><!--//col-->
                                </div><!--//row-->
                            </div><!--//item-->
                            <div class="item border-bottom py-3">
                                <div class="justify-content-between align-items-center">
                                    <div class="">
                                        <div class="item-label"><strong>Mot de passe</strong></div>
                                        <input type="password" id="displayPassword" class="item-data" value="••••••••"
                                            readonly
                                            style="border: none; background: transparent; width: 100%; 
                                        font-size: inherit; color: #5d677c; outline: none;">
                                    </div><!--//col-->
                                </div><!--//row-->
                            </div><!--//item-->
                        </div><!--//app-card-body-->
                        <div class="app-card-footer p-4 mt-auto ">
                            <!-- Update the button to trigger the modal -->
                            @if ($user->role == 'super-admin')
                                <a class="btn app-btn-secondary" href="javascript:void(0);" onclick="openModal()">Mettre
                                    à jour Sécurité</a>
                            @endif
                        </div><!--//app-card-footer-->
                        <!-- Overlay noir transparent -->
                        <div id="overlay"
                            style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.5); z-index: 9998;">
                        </div>
                        <div class="" id="securityModal"
                            style="display: none; position: fixed; top: 50%; left: 50%; 
                           transform: translate(-50%, -50%); background: white; 
                           padding: 20px; box-shadow: 0px 0px 10px rgba(0,0,0,0.5); 
                           border-radius: 8px; z-index: 9999; width: 400px;">
                            <h3 style="color: black; padding-bottom: 2rem;">Modifier la Sécurité</h3>
                            <!-- Affichage des erreurs globales -->
                            @if ($errors->any())
                                <div style="color: red; font-size: 14px; margin-bottom: 10px;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="item border-bottom">
                                <label>
                                    <div class="item-label"><strong>Email :</strong></div>
                                </label>
                                <input type="email" id="newEmail" placeholder="Nouvel email" name="email"
                                    value="{{ old('email', $user->email) }}"
                                    style="width: 100%; padding: 8px; margin-bottom: 10px; outline: none; border: none;"
                                    data-email="{{ old('email', $user->email) }}" required>
                                <!-- Affichage des erreurs de l'email -->
                                @if ($errors->has('email'))
                                    <div class="error-message" style="color: red; font-size: 14px;">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="item border-bottom pt-4">
                                <label>
                                    <div class="item-label"><strong>Ancien mot de passe :</strong></div>
                                </label>
                                <input type="password" id="oldPassword" placeholder="Ancien mot de passe"
                                    name="old_password"
                                    style="width: 100%; padding: 8px; margin-bottom: 10px; outline: none; border: none;"
                                    required>
                                <!-- Affichage des erreurs de l'ancien mot de passe -->
                                @if ($errors->has('old_password'))
                                    <div class="error-message" style="color: red; font-size: 14px;">
                                        {{ $errors->first('old_password') }}
                                    </div>
                                @endif
                            </div>
                            <div class="item border-bottom pt-4">
                                <label>
                                    <div class="item-label"><strong>Nouveau mot de passe :</strong></div>
                                </label>
                                <input type="password" id="newPassword" placeholder="Nouveau mot de passe"
                                    name="new_password"
                                    style="width: 100%; padding: 8px; margin-bottom: 10px; outline: none; border: none;"
                                    required>
                                <!-- Affichage des erreurs du nouveau mot de passe -->
                                @if ($errors->has('new_password'))
                                    <div class="error-message" style="color: red; font-size: 14px;">
                                        {{ $errors->first('new_password') }}
                                    </div>
                                @endif
                            </div>
                            <div class="item border-bottom pt-4">
                                <label>
                                    <div class="item-label"><strong>Confirmer mot de passe :</strong></div>
                                </label>
                                <input type="password" id="confirmPassword" placeholder="Confirmer le mot de passe"
                                    name="new_password_confirmation"
                                    style="width: 100%; padding: 8px; margin-bottom: 10px; outline: none; border: none;"
                                    required>
                                <!-- Affichage des erreurs de confirmation de mot de passe -->
                                @if ($errors->has('new_password_confirmation'))
                                    <div class="error-message" style="color: red; font-size: 14px;">
                                        {{ $errors->first('new_password_confirmation') }}
                                    </div>
                                @endif
                            </div>
                            <div class="pt-5">
                                <button type="submit" id="saveButton"
                                    style="background: green; color: white; padding: 8px 12px; border: none; cursor: pointer; border-radius: 8px;">
                                    Enregistrer
                                </button>
                                <button type="button" onclick="cancelSecurityChanges()"
                                    style="background: red; color: white; padding: 8px 12px; border: none; cursor: pointer; border-radius: 8px;">
                                    Annuler
                                </button>
                            </div>
                        </div>
                        <!-- Hidden field to store the current password -->
                        <input type="text" id="currentPassword" value="{{ old('password', $user->password) }}"
                            readonly style="display: none;">
                    </div><!--//app-card-->
                </form>
            </div><!--//row-->
        </div>
    </div>
    <script defer src="{{ asset('assets/js/updateSecurite.js') }}"></script>
    <script>
        document.getElementById('newContact').addEventListener('input', function(event) {
            // Allow only digits
            event.target.value = event.target.value.replace(/[^0-9]/g, '');
        });
        document.getElementById('newName').addEventListener('input', function(event) {
            // Allow only letters and spaces, no numbers
            event.target.value = event.target.value.replace(/[^a-zA-Z\s]/g, '');
        });
    </script>
@endsection
