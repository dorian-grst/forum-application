<?php
namespace App\Nig\Model\Repository;

use App\Nig\Model\DataObject\Section;
use App\Nig\Model\DataObject\Question;

class SectionRepository extends AbstractRepository {
    protected function getNomsColonnes(): array {
        return ["idSection", "title", "content", "idQuestion"];
    }

    protected function getNomClePrimaire(): string {
        return "idSection";
    }

    protected function getNomTable(): string {
        return "Sections";
    }

    protected function construire(array $ut): Section {
        return new Section($ut["idSection"], $ut["title"], $ut["content"], $ut["idQuestion"]);
    }

    public static function save(Section $s) {
        $sql = "INSERT INTO Sections (title,content,idQuestion) VALUES (:titleTag,:contentTag,:idQuestionTag)";
        $values = array (
            "titleTag"=>$s->getTitle(),
            "contentTag"=>$s->getContent(),
            "idQuestionTag"=>$s->getIdQuestion() //pour le moment pas de idQuestion enregistré
        );
        return (new SectionRepository())->rawSqlQuery($sql, $values);
    }

    public static function getSectionById(int $idSection) : Section {
        $sql = "SELECT * FROM Sections WHERE idSection=:idSectionTag";
        $values = array(
            "idSectionTag"=> $idSection
        );
        return (new SectionRepository())->selectSingle($sql, $values, true);
    }

    public static function getSectionsByQuestionId(int $idQuestion) : array {
        $sql = "SELECT * FROM Sections WHERE idQuestion=:idQuestionTag";
        $values = array(
            "idQuestionTag"=> $idQuestion
        );
        return (new SectionRepository())->selectMultiple($sql, $values, true);
    }

    public static function deleteAllAnwserPerQuestion(Question $q): bool {
        $sql = "DELETE * FROM Sections WHERE idQuestion=:idQuestionTag";
        $values = array(
            "idQuestionTag" => $q->getIdQuestion()
        );
        return (new SectionRepository())->rawSqlQuery($sql, $values);
    }

    public static function hasUserAnswered(string $idUser, string $idSection): bool {
        $sql = "SELECT COUNT(*) FROM Answers WHERE idSection=:idSectionTag AND loginUser=:loginUserTag";
        $values = array(
            "loginUserTag" => $idUser,
            "idSectionTag" => $idSection
        );
        $nb = (new SectionRepository())->selectSingle($sql, $values);
        return $nb[0] >= 1;
    }

    public static function deleteAllSectionsByQuestionId($idQuestion) {
        $sql = "DELETE FROM Sections WHERE idQuestion=:idQuestionTag";
        $values = array(
            "idQuestionTag" => $idQuestion
        );
        (new SectionRepository())->rawSqlQuery($sql, $values);
    }

    public static function getIdWithidSection(string $idsection){
        $sql="SELECT * FROM Sections s WHERE idSection=:idSectionTag";
        $values = array (
            "idSectionTag"=>$idsection
        );
        $section = (new SectionRepository())->selectSingle($sql, $values, true);
        return $section->getIdQuestion();
    }
}
?>