<?php
    namespace App\Nig\Controller;

    use App\Nig\Lib\MessageFlash;
    use App\Nig\Lib\Password;
    use App\Nig\Model\DataObject\User;
    use App\Nig\Model\HTTP\Session;
    use App\Nig\Model\Repository\DatabaseConnection;
    use App\Nig\Model\Repository\UserRepository;

    Class ControllerUser
    {
        public static function displayView(string $pathView, array $parameters = [])
        {
            extract($parameters); // Crée des variables à partir du tableau $parametres
            require __DIR__ . "/../$pathView"; // Charge la vue
        }

        public static function login(): void
        {
            self::displayView('./view.php', [
                "pageTitle" => "Login",
                "cheminVueBody" => 'user/login.php'
            ]);
        }

        public static function manage(): void {
            self::displayView('./view.php', [
                "pageTitle" => "Manage",
                "cheminVueBody" => 'admin/manage.php',
                "autors"=>UserRepository::allAutors()
            ]);
        }

        public static function register()
        {
            $login = htmlspecialchars($_POST['login']);
            if (UserRepository::checkAvailability($login) && !str_contains($login," ")) {
                $email = htmlspecialchars($_POST['email']);
                $password = Password::hacher($_POST['pwd']);
                $avatarUrl = "../web/img/pp.png"; //img de base, l'utilisateur en choisira une nouvelle plus tard
                $newUser = new User($login, $login, $email, $password, $avatarUrl);
                UserRepository::register($newUser);
                $session=Session::getInstance();
                $session->enregistrer('login',$login);
                $session->enregistrer('avatarUrl',$avatarUrl);
                $session->enregistrer("nameUser",$login);
                $session->enregistrer('role','Utilisateur');
                $session->enregistrer("mail",$email);
                MessageFlash::ajouter("success", "L'inscription a été enregistrée avec succès !");
                ControllerQuestion::home();
            }else{
                MessageFlash::ajouter("danger", "L'identifiant est déjà utilisé.");
                self::login(); //changez ça pour mettre un msg d'avertissement
            }
        }



        public static function connected(){
            $loginEntry=$_POST['login'];
            $passwordEntry=$_POST['pwd'];
            $sql="SELECT password FROM Users WHERE loginUser=:loginUserTag";
            $pdoStatement=DatabaseConnection::getPdo()->prepare($sql);
            $values= array (
                "loginUserTag"=>$loginEntry,
            );
            $pdoStatement->execute($values);
            $password=$pdoStatement->fetch();
            $ok=false;
            if($password){
                if(Password::verifier($passwordEntry,$password[0])){
                    $ok=true;
                }
            }
            if($ok){
                $session=Session::getInstance();
                $session->enregistrer('login',$loginEntry);
                $session->enregistrer('nameUser',UserRepository::getNameUser($loginEntry));
                $session->enregistrer('avatarUrl',UserRepository::getAvatar($loginEntry));
                $session->enregistrer('mail',UserRepository::getMail($loginEntry));

                if(UserRepository::isAutor($loginEntry)){
                    $session->enregistrer('role','Auteur');
                }else if (UserRepository::isAdmin($loginEntry)) {
                    $session->enregistrer('role', 'Administrateur');
                } else{
                    $session->enregistrer('role','Utilisateur');
                }
                ControllerQuestion::home();
            }else{
                MessageFlash::ajouter("danger", "Identifiant ou mot de passe incorrect.");
                self::login();
            }
        }

        public static function profile(){
            self::displayView("./view.php", [
                "pageTitle" => "profile",
                "cheminVueBody" => "user/profile.php"]);
        }

        public static function deconnected(){
            $session=Session::getInstance();
            $session->detruire();
            self::login();
        }

        public static function addAutor(): void{
            $newAuthor=htmlspecialchars($_POST['pseudo']);
            if(!UserRepository::alreadyAutor($newAuthor)){
                UserRepository::addGlobalAutor($newAuthor);
            }
            self::manage();
        }

        public static function deleteAutor(): void {
            $author = $_GET['loginAutor'];
            UserRepository::deleteGlobalAutor($author);
            self::manage();
        }
    }

?>