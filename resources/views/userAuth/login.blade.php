<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Connexion</title>
</head>

<body>

    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <h2>Se connecter</h2>
                    <br />

                    <div>

                        @if ($errors->any())
                            <div class="error-container">
                                <ul class="message-container">
                                    @foreach ($errors->all() as $error)
                                        <li class="error-message">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="inputbox">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="email" name="email" class="input-text" value="{{ old('email') }}" />
                            <label for="">Email</label>
                        </div>

                        <div class="inputbox">
                            <input type="password" name="password" id="password" class="input-text"
                                value="{{ old('password') }}" />
                            <ion-icon name="lock-closed-outline" id="togglePassword"
                                style="cursor: pointer;"></ion-icon>
                            <label for="">Mot de passe</label>
                        </div>


                    </div>
                    <br>
                    <div class="forget-password-group"></div>
                    <input type="submit" value="Se connecter" class="buttonLogin" />
                </form>
            </div>

            <!-- Include the JavaScript -->
            <script src="{{ asset('js/login.js') }}"></script>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <script src="{{ asset('assets/js/password-login.js') }}"></script>
</body>

</html>
