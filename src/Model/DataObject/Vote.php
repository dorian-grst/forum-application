<?php

namespace App\Nig\Model\DataObject;

class Vote extends AbstractDataObject
{
    private string $idAnswer;
    private string $loginUser;
    private string $vote;

    public function getObjectAsArray(): array
    {
        return [
            "idAnswer" => $this->idAnswer,
            "loginUser" => $this->loginUser,
            "vote" => $this->vote
        ];
    }

    public function __construct(array $obj) {
        $this->loginUser = $obj['loginUser'];
        $this->idAnswer = $obj['idAnswer'];
        $this->vote = $obj['vote'];
    }

    public function getVote(): int {
        return $this->vote;
    }

    public function getAuthor() {
        return $this->loginUser;
    }

    public function getIdAnwser() {
        return $this->idAnswer;
    }
}