<main class="flex--column login">
        <div class="flex--row wrapper">
            <div class="flex--column signup">
                <form method="POST" action="frontController.php?action=register&controller=user" class="flex--column">
                    <input type="hidden" name="action" value="createAccount">
                    <div class="flex--row title">
                        <div class="flex--row icon--wrapper">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.3249 15.0763C12.8883 15.0257 12.4456 15 12 15C10.0188 15 8.09292 15.5085 6.52112 16.4465C5.30069 17.1749 4.34666 18.1307 3.74108 19.2183C3.46638 19.7117 3.79562 20.2902 4.34843 20.4054C7.85678 21.1365 11.4437 21.3594 15 21.074V21H14C12.3431 21 11 19.6569 11 18C11 16.5753 11.9932 15.3825 13.3249 15.0763Z" fill="black"/>
                                <path d="M18 14L18 22" stroke="black" stroke-width="2.5" stroke-linecap="round"/>
                                <path d="M22 18L14 18" stroke="black" stroke-width="2.5" stroke-linecap="round"/>
                                <circle cx="12" cy="8" r="5" fill="black"/>
                            </svg>
                        </div>
                        <div>
                            Inscription
                        </div>
                    </div>
                    <div class="flex--row inputs">
                        <div class="flex--column input--wrapper">
                            <label for="loginId">Login</label>
                            <input name="login" id="loginId" placeholder="DarkDorianXX" required>
                        </div>
                        <div class="flex--column input--wrapper">
                            <label for="emailId">Adresse mail</label>
                            <input name="email" id="emailId" placeholder="john.doe@etu.umontpellier.fr" required>
                            <!-- pattern="/^[a-zA-Z0-9.! #$%&'*+/=? ^_`{|}~-]+@[a-zA-Z0-9-]+(?:\. [a-zA-Z0-9-]+)*$/" -->
                        </div>
                    </div>

                    <div class="flex--row inputs">
                        <div class="flex--column input--wrapper">
                            <label for="loginId">Mot de passe</label>
                            <input name="pwd" id="pwdId" placeholder="xxx" type="password" required onkeyup="onPwdChange(this.value)">
                        </div>
                        <div class="flex--column input--wrapper">
                            <label for="emailId">Confirmez votre mot de passe</label>
                            <input id="pwdComfirm" placeholder="xxx" type="password" required onkeyup="onPwdChange(this.value)">
                        </div>
                    </div>

                    <div class="flex--row condition">
                        <div class="indicator" id="len-indicator">
                        </div>
                        <div>
                            Entre 8 et 16 caractères.
                        </div>
                    </div>
                    <div class="flex--row condition">
                        <div class="indicator" id="upper-indicator">
                        </div>
                        <div>
                            Au moins une majuscule et un caractère spécial.
                        </div>
                    </div>
                    <div class="flex--row condition">
                        <div class="indicator" id="same-indicator">
                        </div>
                        <div>
                            Les deux mots de passe sont identiques.
                        </div>
                    </div>

                    <button id="create" disabled type="submit">Je crée un compte</button>
                </form>
            </div>

            <div class="vertical--sep">
            </div>

            <div class="flex--column signin">
                <form method="POST" action="frontController.php?action=connected&controller=user" class="flex--column">
                    <input type="hidden" name="action" value="checkLogin">
                    <div class="flex--row title">
                        <div class="flex--row icon--wrapper">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.6515 19.4054C20.2043 19.2902 20.5336 18.7117 20.2589 18.2183C19.6533 17.1307 18.6993 16.1749 17.4788 15.4465C15.907 14.5085 13.9812 14 12 14C10.0188 14 8.09292 14.5085 6.52112 15.4465C5.30069 16.1749 4.34666 17.1307 3.74108 18.2183C3.46638 18.7117 3.79562 19.2902 4.34843 19.4054C9.39524 20.4572 14.6047 20.4572 19.6515 19.4054Z" fill="#222222"/>
                                <circle cx="12" cy="8" r="5" fill="#222222"/>
                            </svg>
                        </div>
                        <div>
                            Connexion
                        </div>
                    </div>
                    <div class="flex--column input--wrapper">
                        <label for="emailId2">Login</label>
                        <input id="emailId2" name="login" placeholder="Pseudo123">
                    </div>
                    <div class="flex--column input--wrapper">
                        <label for="pwdId2">Mot de passe</label>
                        <input id="pwdId2" name="pwd" placeholder="xxx" type="password">
                    </div>

                    <button type="submit">Je me connecte</button>
                </form>
            </div>
        </div>
    </form>
    <script src="../web/js/login-format.js"></script>
</main>