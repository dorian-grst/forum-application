<?php

namespace App\Nig\Model\Repository;

use App\Nig\Model\DataObject\Vote;

class VoteRepository extends AbstractRepository
{
    public function getNomClePrimaire(): string
    {
        return "none";
    }

    public function getNomsColonnes(): array
    {
        return ["idAnswer", "loginUser", "vote"];
    }

    public function getNomTable(): string
    {
        return "voteFor";
    }

    public function construire(array $a): Vote
    {
        return new Vote($a);
    }

    public static function getVote(int $idAnswer, string $loginUser) : ?int {
        $sql="SELECT * FROM voteFor WHERE idAnswer=:idAnswerTag AND loginUser=:loginUserTag";
        $values= array(
            "idAnswerTag"=>$idAnswer,
            "loginUserTag"=>$loginUser
        );
        $vote = (new VoteRepository())->selectSingle($sql, $values, true);
        return $vote == null ? null :  $vote->getVote();
    }

    public static function vote(int $idAnswer, string $loginUser, int $value) {
        self::unvote($idAnswer, $loginUser);
        $sql="INSERT INTO voteFor (idAnswer,loginUser,vote) VALUES (:idAnswerTag,:loginUserTag,:voteTag)";
        $values= array(
            "idAnswerTag"=>$idAnswer,
            "loginUserTag"=>$loginUser,
            "voteTag"=>$value
        );
        return (new VoteRepository())->rawSqlQuery($sql, $values);
    }

    public static function unvote(int $idAnswer, string $loginUser) {
        $sql="DELETE FROM voteFor WHERE idAnswer=:idAnswerTag AND loginUser=:loginUserTag";
        $values= array(
            "idAnswerTag"=>$idAnswer,
            "loginUserTag"=>$loginUser
        );
        return (new VoteRepository())->rawSqlQuery($sql, $values);
    }

    public static function getAllVotes(int $idAnswer): ?int {
        $sql = "SELECT SUM(vote) FROM voteFor WHERE idAnswer=:idAnswerTag";
        $values = [
            "idAnswerTag" => $idAnswer
        ];
        $pdoStatement = (new VoteRepository())->rawSqlQuery($sql, $values);
        return $pdoStatement->fetchColumn();
    }
}