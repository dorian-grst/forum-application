<?php
namespace App\Nig\Model\Repository;

use App\Nig\Model\DataObject\Answer;
use App\Nig\Model\DataObject\Question as Question;
use App\Nig\Model\HTTP\Session;

class QuestionRepository extends AbstractRepository{

    protected function getNomTable(): string {
        return "questions";
    }

    protected function getNomClePrimaire(): string {
        return "idQuestion";
    }

    protected function getNomsColonnes(): array {
        return ["idQuestion", "private", "titre", "description", "dateCreation", "dateStart", "dateVoteFin", "loginUser"];
    }

    public function construire(array $ut): Question {
        var_dump($ut);
         return Question::createWithId($ut["author"], $ut["private"], $ut["title"], $ut["description"], $ut["dateStart"], $ut["dateEnd"], $ut["dateCreation"]);
    }

    public static function selectAllOrdered() : array {
        $sql = "SELECT * FROM Questions ORDER BY idQuestion DESC";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $pdoStatement->execute();
        $questions = $pdoStatement->fetchAll();
        return $questions;
    }

    public static function getQuestionById(int $idQuestion) : Question {
        $sql = "SELECT * FROM Questions WHERE idQuestion=:idQuestion";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);    
        $values = array(
            "idQuestion" => $idQuestion
        );
        $pdoStatement->execute($values);
        $question = $pdoStatement->fetch();
        return Question::createWithId($idQuestion, $question['loginUser'], $question['private'], $question['title'], $question['description'], $question['dateStartAnswer'], $question['dateEndAnswer'], $question['dateStartVote'], $question['dateEndVote'], $question['dateCreation']);
    }

    public static function reinstateQuestionById(string $idQuestion): void {
        $sql = "UPDATE Questions SET private = 1 WHERE idQuestion=:idQuestionTag";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = array(
            "idQuestionTag" => $idQuestion
        );
        $pdoStatement->execute($values);
        $pdoStatement->fetch();
    }

    public static function getAllQuestionsOrdered() : array {
        $res = [];
         //$questions = self::selectAllOrdered();
        $questions= self::allPublicAndConcerned();

        foreach ($questions as $question) {
           // $res[] = new Question($question['loginUser'], $question['private'] == 1, $question['title'], $question['description'], $question['dateStart'], $question['dateEnd'], $question['dateCreation']);
            $res[] = Question::createWithId($question['idQuestion'], $question['loginUser'], $question['private'], $question['title'], $question['description'], $question['dateStartAnswer'], $question['dateEndAnswer'], $question['dateStartVote'], $question['dateEndVote'], $question['dateCreation']);

        }
        return $res;
    }

    public static function isAnsweringOpen(Question $q) : bool {
        $now = date("Y-m-d", time());
        $dateStart = date($q->getDateStartAnswer());
        $dateEnd = date($q->getDateEndAnswer());
        return $now >= $dateStart && $now <= $dateEnd;
    }

    public static function onGoingVoting(Question $q) : bool {
        $now = new \DateTime();
        $dateStart = new \DateTime($q->getDateStartVote());
        $dateEnd = new \DateTime($q->getDateEndVote());
        return $now >= $dateStart && $now <= $dateEnd;
    }

    public static function save(Question $q) : int {
        $sql = "INSERT INTO Questions (private, title, description, dateCreation, dateStartAnswer, dateEndAnswer, dateStartVote, dateEndVote, loginUser) VALUES ( :privateTag, :titreTag, :descriptionTag, :dateCreationTag, :dateStartAnswerTag, :dateEndAnswerTag, :dateStartVoteTag, :dateEndVoteTag, :loginUserTag)";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = array(
            "privateTag" => $q->getPrivate(),
            "titreTag" => $q->getTitle(),
            "descriptionTag" => $q->getDescription(),
            "dateCreationTag" => $q->getDateCreation(),
            "dateStartAnswerTag" => $q->getDateStartAnswer(),
            "dateEndAnswerTag" => $q->getDateEndAnswer(),
            "dateStartVoteTag" => $q->getDateStartVote(),
            "dateEndVoteTag" => $q->getDateEndVote(),
            "loginUserTag" => $q->getAuthor()
        );
        
        $pdoStatement->execute($values);
        echo DatabaseConnection::getPdo()->lastInsertId();
        return DatabaseConnection::getPdo()->lastInsertId();
    }

    public static function getAnswers(int $idQuestion) : array{
        $sql="SELECT * FROM Answers a JOIN Sections s ON a.idSection=s.idSection WHERE idQuestion=:idQuestionTag";
        $values=array(
            "idQuestionTag"=>$idQuestion
        );
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $tabAnswers=$pdoStatement->fetchAll();
        return $tabAnswers;
    }

    public static function getQuestionsByUser(string $loginUser) : array {
        $sql = "SELECT * FROM Questions WHERE loginUser=:loginUserTag";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = array(
            "loginUserTag" => $loginUser
        );
        $pdoStatement->execute($values);
        $questions = $pdoStatement->fetchAll();
        $res = [];
        foreach ($questions as $question) {
            $res[] = Question::createWithId($question['idQuestion'], $question['loginUser'], $question['private'] == 1, $question['title'], $question['description'], $question['dateStartAnswer'], $question['dateEndAnswer'], $question['dateStartVote'], $question['dateEndVote'], $question['dateCreation']);
        }
        return $res;
    }

    public static function getAnswersBySection(int $idQuestion, $idSection): array{
        $sql="SELECT * FROM Answers a JOIN Sections s ON a.idSection=s.idSection WHERE idQuestion=:idQuestionTag AND a.idSection=:idSectionTag";
        $values= array(
            "idQuestionTag"=>$idQuestion,
            "idSectionTag"=>$idSection
        );
        $pdoStatement=DatabaseConnection::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $tabAnswers=$pdoStatement->fetchAll();
        $result = array();
        foreach($tabAnswers as $a) {
            $result[] = Answer::createWithId($a['idSection'], $a['idAnswer'], $a['answerContent'], $a['loginUser']);
        }
        return $result;
    }

    public static function getBestAnwsersByQuestion(int $idQuestion): array {
        $results = array();
        $sections = SectionRepository::getSectionsByQuestionId($idQuestion);
        foreach ($sections as $section) {
            $answers = QuestionRepository::getAnswersBySection($idQuestion, $section->getIdSection());
            $sectionResult = array();
            $maxVotes = 0;
            foreach ($answers as $answer) {
                $nb = VoteRepository::getAllVotes($answer->getIdAnswer());
                if ($nb > $maxVotes) {
                    $sectionResult = array($answer->getIdAnswer());
                    $maxVotes = $nb;
                }
                else if ($nb == $maxVotes) {
                    $sectionResult[] = $answer->getIdAnswer();
                }
            }
            $results += [$section->getIdSection() => $sectionResult];
        };
        return $results;
    }

    public static function updateQuestion(Question $q): void {
        $sql = "UPDATE Questions SET private=:privateTag, title=:titleTag, description=:descriptionTag, dateStartAnswer=:dateStartAnswerTag, dateEndAnswer=:dateEndAnswerTag, dateStartVote=:dateStartVoteTag, dateEndVote=:dateEndVoteTag WHERE idQuestion=:idQuestionTag";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = array(
            "privateTag" => $q->getPrivate(),
            "titleTag" => $q->getTitle(),
            "descriptionTag" => $q->getDescription(),
            "dateStartAnswerTag" => $q->getDateStartAnswer(),
            "dateEndAnswerTag" => $q->getDateEndAnswer(),
            "dateStartVoteTag" => $q->getDateStartVote(),
            "dateEndVoteTag" => $q->getDateEndVote(),
            "idQuestionTag" => $q->getIdQuestion()
        );
        $pdoStatement->execute($values);
    }

    public function build($arrayQuestion): Question {
        return Question::createWithId($arrayQuestion['idQuestion'],$arrayQuestion['autor'],$arrayQuestion['private'],$arrayQuestion['title'],$arrayQuestion['description'],$arrayQuestion['dateStart'],$arrayQuestion['dateEnd'], $arrayQuestion['dateCreation']);
    }

    public static function questionPreview($question) {
        require __DIR__ . "/../../view/" . "question/questionPreview.php";
    }

    public static function allPublicAndConcerned(): array{
        $session = Session::getInstance();
        $sql = "";
        $values = [];
        if ($session->lire('role') == 'Administrateur') {
            $sql = "SELECT DISTINCT q.idQuestion, q.private, q.title, q.description,q.dateCreation,q.dateStartAnswer,q.dateEndAnswer,q.dateStartVote,q.dateEndVote,q.loginUser
                    FROM Questions q
                    ORDER BY q.idQuestion DESC";
        }
        else if ($session->contient('login')) {
            $sql = "SELECT DISTINCT q.idQuestion, q.private, q.title, q.description,q.dateCreation,q.dateStartAnswer,q.dateEndAnswer,q.dateStartVote,q.dateEndVote,q.loginUser
                    FROM Questions q
                    LEFT JOIN selected s ON s.idQuestion=q.idQuestion
                    WHERE (s.loginUser=:loginUserTag
                    AND private=1)
                    OR private=0
                    ORDER BY q.idQuestion DESC";
            $values = array (
                "loginUserTag"=>$session->lire("login")
            );
        } else {
            $sql="SELECT * FROM Questions WHERE private=0 ORDER BY idQuestion DESC";
        }
        return (new QuestionRepository())->selectMultiple($sql, $values);
    }

    public static function convertDate($date){
        $dateINT=strtotime($date);
        return $datefr=date('d-m-Y',$dateINT);
    }

    public static function getNbSection($idQuestion){
        $sql="SELECT COUNT(*) FROM Sections WHERE idQuestion=:idQuestionTag";
        $values = array (
            "idQuestionTag"=>$idQuestion
        );
        $data = (new QuestionRepository())->selectSingle($sql, $values);
        return $data['COUNT(*)'];
    }

    public static function archiveQuestionById(string $idQuestion) {
        $sql = "UPDATE Questions SET private=2 WHERE idQuestion=:idQuestionTag;";
        $values = [
            "idQuestionTag" => $idQuestion
        ];
        (new QuestionRepository())->rawSqlQuery($sql, $values);
    }
}