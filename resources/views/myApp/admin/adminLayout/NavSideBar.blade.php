<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge" /> --}}
    <title>Gestion des fournisseurs</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
</head>

<body>
    <header class="app-header fixed-top">
        @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row">
                        <div class="col-6" id="col-left">
                            <!-- Hamburger button to toggle sidebar -->
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 30 30" role="img">
                                    <title>Menu</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                        stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                            <!-- Close button for sidebar -->
                            <!-- <a href="#" id="sidepanel-close" class="sidepanel-toggler d-xl-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 30 30" role="img">
                                    <title>Close</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                        stroke-width="2" d="M4 7l22 22M4 23l22-22"></path>
                                </svg>
                            </a>-->
                        </div><!--//col-->
                        <div class="app-utilities col-6" id="col-right">
                            <div class="app-utility-item app-user-dropdown dropdown">
                                <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-expanded="false"><img src="assets/img/logo.png"
                                        alt=""></a>
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li><a class="dropdown-item" href="{{ route('update.user.auth.form') }}">Compte</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se
                                            déconnecter</a></li>
                                </ul>
                            </div><!--//app-user-dropdown-->
                        </div><!--//app-utilities-->
                    </div><!--//row-->
                </div><!--//app-header-content-->
            </div><!--//container-fluid-->
        </div><!--//app-header-inner-->
        <!-- Sidebar -->
        <div id="app-sidepanel">
            <div class="sidepanel-inner d-flex flex-column">
                <div class="templatemo-flex-row">
                    <div class="templatemo-sidebar">
                        <header class="templatemo-site-header pt-3 pb-3">
                            <h3>MATERIEL LEVAGE MAROC</h3>
                        </header>
                        <div class="">
                            <div class="custom-hr"></div>
                        </div>
                        <!-- Menu items (inside the sidebar) -->
                        <nav class="templatemo-left-nav">
                            <ul>
                                <li><a href="{{ route('dashboardSection') }}"
                                        class="{{ request()->routeIs('dashboardSection') ? 'active' : '' }}"><i
                                            class="fa fa-chart-bar fa-fw"></i>
                                        Tableau de bord</a>
                                </li>
                                @if (Auth::user()->role === 'super-admin')
                                    <li>
                                        <a href="{{ route('usersSection') }}"
                                            class="{{ request()->routeIs('usersSection') ? 'active' : '' }}">
                                            <i class="fa fa-users fa-fw"></i> Liste des utilisateurs
                                        </a>
                                    </li>
                                @endif

                                <li><a href="{{ route('prospectsSection') }}"
                                    class="{{ request()->routeIs('prospectsSection', 'clientsSection', 'suppliersAndClientsSection', 'suppliersSection') ? 'active' : '' }}"><i
                                        class="fas fa-users-cog"></i> Répertoire partenaires</a></li>

                                <li><a href="{{ route('categoriesSection') }}"
                                        class="{{ request()->routeIs('categoriesSection' , 'productsSection') ? 'active' : '' }}"><i
                                            class="fas fa-list"></i> Les catégories et sous catégories</a></li>

                                @if (Auth::user()->role !== 'utilisateur')
                                    <li><a href="{{ route('historique') }}"
                                            class="{{ request()->routeIs('historique' , 'journaux.index') ? 'active' : '' }}"><i
                                                class="fas fa-history"></i> Historique
                                            et Journaux de connexion</a></li>
                                @endif

                                <li><a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                            class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
                            </ul>
                        </nav>
                    </div>
                </div><!--//sidepanel-inner-->
            </div><!--//app-sidepanel-->
        </div><!--//sidebar-->
    </header><!--//app-header-->
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js') }}"></script>
    <script>
        $("#displayNotif").on("click", function() {
            var placementFrom = $("#notify_placement_from option:selected").val();
            var placementAlign = $("#notify_placement_align option:selected").val();
            var state = $("#notify_state option:selected").val();
            var style = $("#notify_style option:selected").val();
            var content = {};
            content.message =
                'Turning standard Bootstrap alerts into "notify" like notifications';
            content.title = "Bootstrap notify";
            if (style == "withicon") {
                content.icon = "fa fa-bell";
            } else {
                content.icon = "none";
            }
            content.url = "index.html";
            content.target = "_blank";

            $.notify(content, {
                type: state,
                placement: {
                    from: placementFrom,
                    align: placementAlign,
                },
                time: 1000,
            });
        });
    </script>
</body>

</html>
