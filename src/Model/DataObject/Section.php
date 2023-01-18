<?php

namespace App\Nig\Model\DataObject;

use App\Nig\Model\HTTP\Session;
use App\Nig\Model\Repository\SectionRepository;
use App\Nig\Model\Repository\UserRepository;
use App\Nig\Model\Repository\QuestionRepository;

class Section extends AbstractDataObject
{
    private ?int $idSection;
    private string $title;
    private string $content;
    private int $idQuestion;

    public function __construct(?int $idSection, string $title, string $content, int $idQuestion)
    {
        $this->idSection = $idSection;
        $this->title=$title;
        $this->content=$content;
        $this->idQuestion=$idQuestion;
    }

    public static function createWithId(int $idSection, string $title, string $content, int $idQuestion) : Section {
        $s = new Section($idSection, $title, $content, $idQuestion);
        return $s;
    }

    public static function create(string $title, string $content, int $idQuestion) : Section {
        $s = new Section(-1, $title, $content, $idQuestion);
        return $s;
    }

    public function getObjectAsArray(): array
    {
        return [
                "idSection" => $this->idSection,
            "title" => $this->title,
            "content" => $this->content,
            "idQuestion" => $this->idQuestion
        ];
    }

    /**
     * @return string
     */
    public function getIdSection(): string
    {
        return $this->idSection;
    }

    /**
     * @param string $idSection
     */
    public function setIdSection(string $idSection): void
    {
        $this->idSection = $idSection;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * @param int $idQuestion
     */
    public function setIdQuestion(int $idQuestion): void
    {
        $this->idQuestion = $idQuestion;
    }

    public function display() : string {
        \ob_start();
        ?>
        <div class="detail--section">
            <div class="detail--section--title">
                <?php echo $this->title ?>
            </div>
            <div class="detail--section--text">
                <?php echo $this->content ?>
            </div>
            <?php
            $session=Session::getInstance();
            if ($session->contient('login')) {
                $login = $session->lire('login');
                $hasAnswered = SectionRepository::hasUserAnswered($login, $this->getIdSection());
                if(!$hasAnswered && UserRepository::isCollaborator($login, $this->getIdQuestion()) && QuestionRepository::isAnsweringOpen(QuestionRepository::getQuestionById($this->getIdQuestion()))) {
                    ?>
            <a href="../web/frontController.php?controller=answer&action=answer&id=<?php echo $this->idSection?>" class="click--to--answer--question">
            <div class='answer--to--question'>
                Répondre à cette section
            </div>
            </a>
            <?php
                }
            } ?>
        </div>
        <?php
        return \ob_get_clean();
    }



}