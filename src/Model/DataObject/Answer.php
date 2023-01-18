<?php

namespace App\Nig\Model\DataObject;
use App\Nig\Model\DataObject\Section;
use App\Nig\Model\Repository\DatabaseConnection;
use App\Nig\Model\Repository\AnswerRepository;
use App\Nig\Model\Repository\SectionRepository;
use App\Nig\Model\Repository\QuestionRepository;
use App\Nig\Model\HTTP\Session;
use App\Nig\Model\Repository\UserRepository;
use App\Nig\Model\Repository\VoteRepository;

class Answer extends AbstractDataObject
{
    private string $idSection;
    private ?string $idAnswer;
    private string $content;
    private string $author;

    public function __construct(){}

    public static function createWithId(string $idSection, string $idAnswer, string $content, string $author) : Answer {
        $a = new Answer();
        $a->idSection = $idSection;
        $a->idAnswer = $idAnswer;
        $a->content = $content;
        $a->author = $author;
        return $a;
    }

    public static function create(string $idSection, string $content, string $author) : Answer {
        $a = new Answer();
        $a->idSection = $idSection;
        $a->content = $content;
        $a->author = $author;
        return $a;
    }

    public function getObjectAsArray(): array
    {
        return [
                "idAnswer" => $this->idAnswer,
            "content" => $this->content,
            "loginUser" => $this->author,
            "idSection" => $this->idSection
        ];
    }

    // all setters and getters

    public function getIdSection(): string
    {
        return $this->idSection;
    }

    public function setIdSection(string $idSection): void
    {
        $this->idSection = $idSection;
    }

    public function getIdAnswer(): string
    {
        return $this->idAnswer;
    }

    public function setIdAnswer(string $idAnswer): void
    {
        $this->idAnswer = $idAnswer;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function display() : string {
        $session = Session::getInstance();
        $concernedSection = SectionRepository::getSectionById($this->idSection);
        $concernedQuestion = QuestionRepository::getQuestionById($concernedSection->getIdQuestion());
        $onGoing = QuestionRepository::onGoingVoting($concernedQuestion);
        $linkBtn = null;
        if($session->contient('login')){
            $voteValue = VoteRepository::getVote($this->idAnswer, $session->lire('login'));
        }else{
            $voteValue=null;
        }

        $canAlter = $session->lire('login') == $this->getAuthor() & !$onGoing || $session->contient('role') && $session->lire('role') == 'Administrateur';

        $bestAnswers = QuestionRepository::getBestAnwsersByQuestion($concernedQuestion->getIdQuestion());
        $isBestAnswer = date('Y-m-d H:i:s') >= $concernedQuestion->getDateEndVoteObject()->format('Y-m-d H:i:s') & in_array($this->idAnswer, $bestAnswers[$this->idSection]);

        $isConflict = count($bestAnswers[$this->idSection]) > 1 & $isBestAnswer;
        $linkBtn = "./svg/vote-btn.svg";
        switch ($voteValue) {
            case 1:
                $linkBtn = "./svg/like.svg";
                break;
            case -1:
                $linkBtn = "./svg/dislike.svg";
                break;
            case 2:
                $linkBtn = "./svg/superlike.svg";
                break;
        }
        if ($voteValue == null) {
            $voteValue = 0;
        }
        \ob_start();
        ?>
            <div class="answer container flex--column <?php if($isBestAnswer) echo "best--answer" ?>">
            <div class="answer--section">
                <div class="flex--row detail--desc">
                <div class="answer--section--title">
                    <?php echo $concernedSection->getTitle() ?>
                </div>
                <div class = "flex--row detail--description--container">
                    <?php
                    if ($isConflict && ($session->lire('login') == $concernedQuestion->getAuthor() || $session->lire("role") == "Administrateur")) {
                        ?>
                        <form method="POST" action="./frontController.php?controller=answer&action=voted" onsubmit="return confirm('Etes vous sur de choisir la réponse de <?php $this->getAuthor()?> comme meilleure réponse de la section <?php $concernedSection->getTitle()?>')">
                            <input type="submit" value="Choisir comme réponse">
                            <input name="vote-value-<?php echo $this->idAnswer ?>" value="1" type="hidden">
                            <input name="id-question" value="<?php echo $concernedQuestion->getIdQuestion() ?>" type="hidden">
                        </form>
                        <?php
                    }
                    ?>
                    <?php if ($canAlter && !$isConflict) {?>
                        <a href="./frontController.php?action=delete&controller=answer&idQuestion=<?php echo $concernedQuestion->getIdQuestion()?>&idAnswer=<?php echo $this->getIdAnswer() ?>" onsubmit="return comfirm('Etes vous sur de supprimmer cette réponse ?')">
                            <img class="detail--description--image" src="../web/svg/delete.svg" alt="delete" />
                        </a>
                    <?php }?>
                </div>
            </div>
                <div class="answer--section--text">
                    <div>
                        <?php echo $this->getContent() ?>
                    </div>
                    <?php if ($onGoing & UserRepository::canVote(Session::getInstance()->lire('login'),$concernedQuestion->getIdQuestion())) { ?>
                            <div class="vote-container" >
                    <img class="vote-button" src="<?php echo $linkBtn ?>" alt="vote">
                        <div class="vote-pannel ">
                            <img class="vote-no <?php if ($voteValue == -1) echo 'selected'; else '' ?>" src="./svg/dislike.svg" alt="">
                            <img class="vote-yes <?php if ($voteValue == 1) echo 'selected'; else '' ?>" src="./svg/like.svg" alt="">
                            <img class="vote-big-yes <?php if ($voteValue == 2) echo 'selected'; else '' ?>" src="./svg/superlike.svg" alt="">
                            <input type="hidden" name="vote-value-<?php echo $this->getIdAnswer() ?>" value="<?php echo $voteValue ?>">
                        </div>
                            </div>
                    <?php } ?>
                </div>
            </div>
            <div class="horizontal--sep"></div>
                <div class="answer--bottom flex--row">
                    <div class="answer--bottom--left flex--row">
                        <div class="flex--row answer--bottom--left--authors">
                            <img class="flex--row answer--bottom--left--authors--image" src="../web/svg/author.svg" alt="author" />
                            <div>
                                Collaborateur
                            </div>
                        </div>

                        <div class="answer--bottom--left--author rectangle rectangle--blue">
                            <?php echo $this->author ?>
                        </div>
                    </div>
                    <div class="answer--bottom--right flex--row <?php

                    if(!UserRepository::hasCoAutor($this->idAnswer)){
                        echo 'hidden';
                    }
                    ?>" >
                        <div class="flex--row answer--bottom--left--authors">
                            <img class="flex--row answer--bottom--left--authors--image" src="../web/svg/author.svg" alt="author" />
                            <div>
                                Co-auteur(s)
                            </div>
                        </div>

                        <div class="answer--bottom--left--author rectangle rectangle--blue">
                            <?php  $coAutors=UserRepository::getCoAutor($this->getIdAnswer());
                                foreach ($coAutors as $coAutor) {
                                   echo $coAutor;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        return \ob_get_clean();
    }

}