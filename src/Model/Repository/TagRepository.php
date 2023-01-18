<?php
namespace App\Nig\Model\Repository;

use App\Nig\Model\DataObject\Tag;

class TagRepository extends AbstractRepository {
    public function getNomClePrimaire(): string
    {
        return "idTag";
    }

    public function getNomsColonnes(): array
    {
        return ["idTag", "nameTag"];
    }

    public function getNomTable(): string
    {
        return "Tags";
    }

    public function construire(array $a): Tag
    {
        return new Tag($a['idTag'], $a['nameTag'], $a['idQuestion']);
    }

    public static function save(Tag $t) : int {
        $sqlVerif="SELECT * FROM Tags WHERE nameTag=:nameTagTag ";
        $values= array (
             "nameTagTag"=>\htmlspecialchars($t->getName())
        );
        $existing = (new TagRepository())->rowCount($sqlVerif, $values);

        if($existing == 0){
            $createTag="INSERT INTO Tags (nameTag) VALUES (:nameTag)";
            $valueName= array (
                "nameTag" => $t->getName()
            );
            (new TagRepository())->rawSqlQuery($createTag, $valueName);
            $idTag = DatabaseConnection::getPdo()->lastInsertId($createTag);
        }else{
            $searchTag="SELECT idTag FROM Tags WHERE nameTag=:nameTag";
            $valueName= array (
                "nameTag" => $t->getName()
            );
            $tag = (new TagRepository())->rawSqlQuery($searchTag, $valueName)->fetch();
            
            $idTag=$tag['idTag'];
        }
        $insert = "INSERT INTO has_tag VALUES (:idQuestionTag,:idTag)";
        $values = array (
            "idQuestionTag"=> $t->getIdQuestion(),
            "idTag"=> $idTag
        );
        (new TagRepository())->rawSqlQuery($insert, $values);
        return $idTag;
    }

    public static function getTagsByQuestionId(int $idQuestion) : array {
        $sql = "SELECT * FROM Tags WHERE idTag IN (SELECT idTag FROM has_tag WHERE idQuestion=:idQuestionTag)";
        $values = array(
            "idQuestionTag" => $idQuestion
        );
        $tagsFetched = (new TagRepository())->selectMultiple($sql, $values, false);
        $res = [];
        foreach ($tagsFetched as $tag) {
            $res[] = new Tag($tag['idTag'], $tag['nameTag'], $idQuestion);
        }
        return $res;
    }

    public static function deleteAllTagsByQuestionId(int $idQuestion) {
        $sql = "DELETE FROM has_tag WHERE idQuestion=:idQuestionTag";
        $values = array(
            "idQuestionTag" => $idQuestion
        );
        (new TagRepository())->rawSqlQuery($sql, $values);
    }
}
