<?php
namespace App\Nig\Model\Repository;

use App\Nig\Model\DataObject\Answer as Answer;

class AnswerRepository extends AbstractRepository {
    public function getNomClePrimaire(): string
    {
        return "idAnswer";
    }

    public function getNomsColonnes(): array
    {
        return ["idAnswer", "answerContent", "idSection", "loginUser"];
    }

    public function getNomTable(): string
    {
        return "Answers";
    }

    public function construire(array $answer): Answer
    {
        return Answer::createWithId($answer['idSection'],$answer['idAnswer'],$answer['answerContent'],$answer['loginUser']);
    }

    public static function getAnswersForAQuestionByOneUser(int $idQuestion, string $loginUser){
            $sql="SELECT a.idAnswer,a.answerContent,a.idSection,a.loginUser FROM Answers a JOIN Sections s ON a.idSection=s.idSection JOIN Questions q ON s.idQuestion=q.idQuestion WHERE q.idQuestion=:idQuestionTag AND a.loginUser=:loginUserTag";
            $values=array (
                "idQuestionTag"=>$idQuestion,
                "loginUserTag"=> $loginUser
            );
            return (new AnswerRepository())->selectMultiple($sql, $values, true);
        }

    public static function save(Answer $s) {
        $sql= "INSERT INTO Answers (answerContent,idSection, loginUser) VALUES (:contentTag,:idQuestionTag, :loginUserTag)";
        $values= array (
            "contentTag"=>$s->getContent(),
            "idQuestionTag"=>$s->getIdSection(), //pour le moment pas de idQuestion enregistré
            "loginUserTag"=>$s->getAuthor()
        );
        return (new AnswerRepository())->rawSqlQuery($sql, $values);
    }

    public static function getAnswersByQuestionId(int $idQuestion) : array {
        $sql="SELECT * FROM Answers a JOIN Sections s ON a.idSection = s.idSection WHERE idQuestion=:idQuestionTag";
        $values= array(
            "idQuestionTag"=> $idQuestion
        );
        return (new AnswerRepository())->selectMultiple($sql, $values, true);
    }
        
     public static function getAnswersByUser(string $loginUser) : array {
        $sql="SELECT * FROM Answers a JOIN Sections s ON a.idSection = s.idSection WHERE loginUser=:loginUserTag";
        $values = array(
            "loginUserTag"=> $loginUser
        );
         return (new VoteRepository)->selectMultiple($sql, $values, true);
     }

     public static function deleteAnswerById(string $id) {
            $sql = "DELETE FROM Answers WHERE idAnswer=:idAnswerTag";
            $values = [
                "idAnswerTag" => $id
            ];
         (new VoteRepository())->rawSqlQuery($sql, $values);
     }
} 
