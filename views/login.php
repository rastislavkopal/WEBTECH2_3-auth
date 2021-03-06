<div id="login-container" class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-3 mx-auto mb-5">
    <div class="card card0 border-0">
        <div class="row d-flex">
            <div class="col-lg-6">
                <div class="card1 pb-5">
                    <div class="row"> <span id="logo-text">,,Tu by mohol byť nejaky cool citát."</span> </div>
                    <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img src="./assets/img/jeremy_hh.jpg" alt="img" class="image"> </div>
                </div>
            </div>

<!--LOGIN-->
            <form class="col-lg-6" id="login-form" >
                <div class="card2 card border-0 px-4 py-4">
                    <div class="row mb-3 px-3">
                        <h6 class="mb-0 mr-4 mt-2">Prihláste sa cez:</h6>
                        <a id="google-oauth" href="https://wt78.fei.stuba.sk/zadanie3/api/oauth">
                            <div class="facebook text-center mr-3">
                                <div class="fa fa-facebook">
                                    <img src="./assets/img/google.png" alt="gmail login" width="17" height="17">
                                </div>
                            </div>
                        </a>
                        <a onclick="goLdap()">
                            <div class="linkedin text-center mr-3">
                                <div class="fa fa-linkedin">
                                    <img src="./assets/img/ldap.png" alt="ldap login" width="35" height="35">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="row px-3 mb-2">
                        <div class="line"></div> <small class="or text-center">Alebo</small>
                        <div class="line"></div>
                    </div>


                    <div>
                        <div class="row px-3"> <label class="mb-1">
                                <span class="mb-0 text-sm">Email adresa:</span>
                            </label> <input class="mb-3 form-control-sm" type="text" name="email" placeholder="Zadajte validnú emailovú adresu">  </div>
                        <div class="row px-3"> <label class="mb-1">
                                <span class="mb-0 text-sm">Heslo:</span>
                            </label> <input class="form-control-sm" type="password" name="password" placeholder="Zadajte heslo" autocomplete="new-password"> </div>
                        <br>
                        <div class="row px-3"> <label class="mb-1">
                                <span class="mb-0 text-sm">Overovací kód:</span>
                            </label> <input class="mb-4 form-control-sm" type="text" name="code" placeholder="Overte kód z google auth aplikácie">  </div>
                        <div class="row px-3 mb-3">
<!--                            <div class="custom-control custom-checkbox custom-control-inline"> <input id="chk1" type="checkbox" name="chk" class="custom-control-input"> <label for="chk1" class="custom-control-label text-sm">Zapamätať</label> </div>-->

                        </div>
                        <div class="row mb-3 px-3"> <button class="btn btn-blue text-center" type="button" onclick="loginUser()">Prihlásiť sa</button> </div>
                        <div class="row mb-4 px-3"> <small class="font-weight-bold">Ešte nie ste zaregistrovaný? <a class="text-danger" onclick="goRegister()">Registrácia</a></small> </div>
                    </div>
            </div>
        </form>

<!-- REGISTER-->
            <form id="register-form" class="col-lg-6 px-5 py-5">
                <div class="row px-3"> <label class="mb-1">
                        <span class="mb-0 text-sm">Email adresa:</span>
                    </label> <input class="mb-4 form-control-sm" type="text" name="email" placeholder="Zadajte validnú emailovú adresu"> </div>

                <div class="row px-3"> <label class="mb-1">
                        <span class="mb-0 text-sm">Meno:</span>
                    </label> <input class="mb-4 form-control-sm" type="text" name="first_name" placeholder="Zadajte vaše meno.."> </div>
                <div class="row px-3"> <label class="mb-1">
                        <span class="mb-0 text-sm">Priezvisko:</span>
                    </label> <input class="mb-4 form-control-sm" type="text" name="surname" placeholder="Zadajte priezvisko.."> </div>

                <div class="row px-3"> <label class="mb-1">
                        <span class="mb-0 text-sm">Heslo:</span>
                    </label> <input type="password" name="password" class="mb-4 form-control-sm" placeholder="Zadajte heslo"> </div>
                <div class="row px-3"> <label class="mb-1">
                        <span class="mb-0 text-sm">Zopakujte heslo:</span>
                    </label> <input type="password" name="password-again" class="mb-4 form-control-sm" placeholder="Heslo znova..." autocomplete="new-password"> </div>

                <div class="row mb-3 px-3"> <button class="btn btn-blue text-center my-3" type="button" onclick="registerUser()">Registrovať</button> </div>
                <div class="row mb-4 px-3"> <small class="font-weight-bold">Už máte účet? <a class="text-danger" onclick="goLogin()">Prihláste sa</a></small> </div>

                <div id="2fa-register">

                </div>

            </form>
<!-- LDAP-->
            <form id="ldap-form" class="col-lg-6">
                <div class="row px-3"> <label class="mb-1">
                        <span class="mb-0 text-sm">Stuba login:</span>
                    </label> <input class="mb-4" type="text" name="login_name" placeholder="Zadajte svoj stuba ldap login"> </div>

                <div class="row px-3"> <label class="mb-1">
                        <span class="mb-0 text-sm">STUBA Heslo:</span>
                    </label> <input type="password" name="password" placeholder="Zadajte heslo od STUBA účtu"> </div>

                <div class="row mb-3 px-3"> <button class="btn btn-blue text-center my-3" type="button" onclick="loginLdap()">Prihlásiť</button> </div>
                <div class="row mb-4 px-3"> <small class="font-weight-bold">Iný spôsob prihlásenia? <a class="text-danger" onclick="goLogin()">Späť</a></small> </div>


            </form>
        </div>
    </div>
</div>