<?php
namespace App\Nig\Model\Repository;

use App\Nig\Lib\Password;
use App\Nig\Model\DataObject\User;
use App\Nig\Model\HTTP\Session;

class UserRepository extends AbstractRepository {
    public function getNomClePrimaire(): string
    {
        return "loginUser";
    }

    public function getNomsColonnes(): array
    {
        return ["loginUser", "email", "password", "avatarUrl", "name"];
    }

    public function getNomTable(): string
    {
        return "Users";
    }

    public function construire(array $a): User
    {
        return new User($a['loginUser'], $a['name'], $a['email'], $a['password'], $a['avatarUrl']);
    }

    public static function register(User $user){
            $sql="INSERT INTO Users VALUES (:loginUserTag,:emailTag,:passwordTag,:avatarUrlTag,:nameTag)";
            $values=array (
                "loginUserTag"=> $user->getLogin(),
                "emailTag"=>$user->getEmail(),
                "passwordTag"=>$user->getPassword(),
                "avatarUrlTag"=>$user->getAvatarUrl(),
                "nameTag"=>$user->getNameUser()
            );
        (new UserRepository())->rawSqlQuery($sql, $values);
        }

        public static function rename(User $u, String $newName){
            $sql="UPDATE Users SET name=:newNameTag WHERE loginUser=:loginTag";
            $values= array (
                "newNameTag"=>$newName,
                "loginTag"=>$u->getLogin()
            );
            $pdoStatement=DatabaseConnection::getPdo()->prepare($sql)->execute($values);
            $u->setNameUser($newName);
        }

        public static function changeAvatar(User $u, String $newAvatar){
            $sql="UPDATE Users SET avatarUrl=:newAvatarTag WHERE loginUser=:loginTag ";
            $values= array (
                "newAvatarTag"=>$newAvatar,
                "loginTag"=>$u->getLogin()
            );
            $pdoStatement=DatabaseConnection::getPdo()->prepare($sql)->execute($values);
            $u->setAvatarUrl($newAvatar);
        }

        public static function logIn(String $login, String $password): ?User{
            $sql="SELECT * FROM User WHERE loginUser=:loginUserTag AND password=:passwordTag ";
            $values=array (
                "loginUserTag"=>$login,
                "passwordTag"=>$password
            );
            return (new UserRepository())->selectSingle($sql, $values, true);
        }

        public static function allUser(): array{
            $session = Session::getInstance();
            $sql="SELECT * FROM Users EXCEPT SELECT * FROM Users WHERE loginUser=:loginUserTag ORDER BY name";
            $values = array (
                "loginUserTag"=>$session->lire('login')
            );
            return (new UserRepository())->selectMultiple($sql, $values, true);
        }

        public static function isAdmin(string $login): bool {
            $sql="SElECT * FROM Administrators WHERE loginUser=:loginUserTag";
            $values=array (
                "loginUserTag"=>$login
            );
            return (new UserRepository())->rowCount($sql, $values) > 0;
        }

        public static function checkAvailability(string $login): bool{
            $sql = "SElECT * FROM Users WHERE loginUser=:loginUserTag";
            $values = array (
                "loginUserTag"=>$login
            );
            return (new UserRepository())->rowCount($sql, $values) == 0;
        }

        public static function isAutor($login): bool{
            $sql = "SELECT * FROM Autors WHERE loginUser=:loginUserTag";
            $values = array  (
                "loginUserTag"=>$login
            );
            return (new UserRepository())->rowCount($sql, $values) == 1;
        }

        public static function getAvatar($login): string {
            $sql="SELECT * FROM Users WHERE loginUser=:loginUserTag";
            $values = array (
                "loginUserTag"=> $login
            );
            $user = (new UserRepository())->selectSingle($sql, $values, true);
            return $user->getAvatarUrl();
        }


        public static function isCollaborator(string $login, int $idQuestion):bool{
            $sql = "SELECT * FROM selected WHERE loginUser=:loginUserTag AND roleName='collaborator' AND idQuestion=:idQuestionTag";
            $values = array (
                "loginUserTag"=>$login,
                "idQuestionTag"=>$idQuestion
            );
            return (new UserRepository())->rowCount($sql, $values) == 1;
        }

        public static function addVoter(string $login,$idQuestion){
            $sql="INSERT INTO selected VALUES(:loginUserTag,:idQuestionTag,:roleNameTag) ";
            $values= array (
                "loginUserTag"=>$login,
                "idQuestionTag"=>$idQuestion,
                "roleNameTag"=>"voter"
            );
            (new UserRepository())->rawSqlQuery($sql, $values);
        }

        public static function addAutor(string $login, int $idQuestion){
            $sql = "INSERT INTO selected VALUES(:loginUserTag,:idQuestionTag,:roleNameTag) ";
            $values = array(
                "loginUserTag"=>$login,
                "idQuestionTag"=>$idQuestion,
                "roleNameTag"=>"autor"
            );
            (new UserRepository())->rawSqlQuery($sql, $values);
        }

        public static function getAllVotersByQuestionId(int $idQuestion): array{
            $sql="SELECT loginUser FROM selected WHERE idQuestion=:idQuestionTag AND roleName='voter'";
            $pdoStatement=DatabaseConnection::getPdo()->prepare($sql);
            $value= array (
                "idQuestionTag"=>$idQuestion
            );
            $pdoStatement->execute($value);
            $data=$pdoStatement->fetchAll();
            $voters=[];
            foreach ($data as $voter){
                $voters[]=$voter['loginUser'];
            }
            return $voters;
        }

        public static function getAllCollaboratorsByQuestionId(int $idQuestion): array{
            $sql="SELECT loginUser FROM selected WHERE idQuestion=:idQuestionTag AND roleName='collaborator'";
            $pdoStatement=DatabaseConnection::getPdo()->prepare($sql);
            $value= array (
                "idQuestionTag"=>$idQuestion
            );
            $pdoStatement->execute($value);
            $data=$pdoStatement->fetchAll();
            $collaborators=[];
            foreach ($data as $collaborator){
                $collaborators[]=$collaborator['loginUser'];
            }
            return $collaborators;
        }

        public static function setCollaborator(string $login, int $idQuestion){
            $sql = "UPDATE selected SET roleName=:roleNameTag WHERE idQuestion=:idQuestionTag AND loginUser=:loginUserTag";
            $values = array (
                "roleNameTag"=>"collaborator",
                "idQuestionTag"=>$idQuestion,
                "loginUserTag"=>$login
            );
            (new UserRepository())->rawSqlQuery($sql, $values);
        }

        public static function getNameUser($login){
            $sql = "SELECT * FROM Users WHERE loginUser=:loginUserTag";
            $values = array (
                "loginUserTag"=>$login
            );
            $user = (new UserRepository())->selectSingle($sql, $values, true);
            return $user->getNameUser();
        }

        public static function getMail($login){
            $sql="SELECT * FROM Users WHERE loginUser=:loginUserTag";
            $values = array (
                "loginUserTag"=>$login
            );
            $user = (new UserRepository())->selectSingle($sql, $values, true);
            return $user->getEmail();
        }

        public static function getCoAutor($idAnswer){
            $sql = "SELECT * FROM participate WHERE idAnswer=:idAnswerTag ";
            $values = array (
                "idAnswerTag"=>$idAnswer
            );
            return (new UserRepository())->selectMultiple($sql, $values);
        }

        public static function hasCoAutor($idAnswer){
            $sql="SELECT * FROM participate WHERE idAnswer=:idAnswerTag";
            $values = array (
                "idAnswerTag"=>$idAnswer
            );
            return (new UserRepository())->rowCount($sql, $values) > 0;
        }

        public static function canVote($login,$idQuestion): bool{
            $sql="SELECT * FROM selected WHERE loginUser=:loginUserTag AND idQuestion=:idQuestionTag";
            $values= array (
                "loginUserTag"=>$login,
                "idQuestionTag"=>$idQuestion
            );

            return (new UserRepository())->rowCount($sql, $values) == 1;
        }

        public static function allAutors(){
            $sql="SELECT * FROM Autors ORDER BY loginUser";
            $pdoStatement=DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute();
            $autorData=$pdoStatement->fetchAll();
            $autors=[];
            foreach ($autorData as $autor){
                $autors[]=new User($autor['loginUser'],null,null,null,null);
            }
            return $autors;
        }

        public static function alreadyAutor(String $login): bool {
            $sql="SELECT loginUser FROM Autors WHERE loginUser=:loginTag";
            $values = array (
                "loginTag"=>$login
            );

            $verif = (new UserRepository())->selectSingle($sql, $values);
            if($verif){
                if($verif[0]==$login){
                    return true;
                }else {
                    return false;
                }
            }else return false;
        }

        public static function authentificate(string $pwd): bool {
            $session = Session::getInstance();
            $sql="SELECT * FROM Users WHERE loginUser=:loginUserTag;";
            $values=array (
                "loginUserTag"=>$session->lire("login"),
            );
            $user = (new UserRepository())->selectSingle($sql, $values, true);
            return Password::verifier($pwd, $user->getPassword());
        }

        public static function addGlobalAutor(string $name): void{
                $sql="INSERT INTO Autors VALUES (:loginTag)";
                $values = array (
                    "loginTag" => $name
                );
            (new UserRepository())->rawSqlQuery($sql, $values);
        }

        public static function deleteGlobalAutor(string $autor): void {
            $sql = "DELETE FROM Autors WHERE loginUser=:loginTag";
            $values = array (
                "loginTag"=>$autor
            );
            (new UserRepository())->rawSqlQuery($sql, $values);
        }

        public static function resetVotersAndCollaboratorsByQuestionId(int $idQuestion){
            $sql="DELETE FROM selected WHERE idQuestion=:idQuestionTag AND (roleName='voter' OR roleName='collaborator')";
            $pdoStatement=DatabaseConnection::getPdo()->prepare($sql);
            $value= array (
                "idQuestionTag"=>$idQuestion
            );
            $pdoStatement->execute($value);
        }
    }
?>