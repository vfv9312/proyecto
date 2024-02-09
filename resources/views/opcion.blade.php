<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>


    <section id="main-home">
        <div class="main-home">
            <div class="">
                <div class="container">
                    <h1>Inicio de Sesión</h1>
                </div>
            </div>
        </div>
    </section>

    <section id="login">
        <div class="login">
            <div class="container">
                <div class="col-md-6">
                    <div class="login-area">
                        <div class="login-back"></div>
                        <div class="login-front">
                            <div>
                                <img src="" alt="logo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="login-text">
                        <form id="login-form" method="POST" action="php/check-login.php">
                            <h1>Introduzca su nombre de usuario y contraseña para iniciar sesión</h1>

                            <div class="form-group">
                                <div class="form-group">
                                    <div class="icon">
                                        <span class="fa fa-user" aria-hidden="true"></span>
                                    </div>
                                    <input id="username" type="text" class="form-control"
                                        placeholder="Nombre de usuario" name="username" value="" autofocus>
                                </div>

                                <div class="form-group">
                                    <div class="icon">
                                        <span class="fa fa-lock" aria-hidden="true"></span>
                                    </div>
                                    <input type="password" placeholder="Contraseña" name="password"
                                        class="form-control">
                                </div>
                            </div>
                            <div id="login-response"></div>
                            <button type="submit" class="btn btn-default login-button">Acceder</button>
                            <p style="margin-top: 25px;">Para el correcto funcionamiento del sistema, se recomienda
                                utilizar.</p>
                            <ul>
                                <li>
                                    <a href="https://www.google.com/chrome/" target="_blank">
                                        <i class="fa fa-chrome fa-3x" aria-hidden="true"></i> Google Chrome
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.mozilla.org/es-MX/firefox/new/" target="_blank">
                                        <i class="fa fa-firefox fa-3x" aria-hidden="true"></i> Mozilla Firefox
                                    </a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



</body>

</html>
ß
