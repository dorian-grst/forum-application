<?php
    namespace App\Nig\Model\DataObject;

    use App\Nig\Model\Repository\QuestionRepository;

    class Question extends AbstractDataObject {
        private int $idQuestion;
        private string $author;
        private int $private;
        private string $title;
        private string $description;
        private string $dateStartAnswer;
        private string $dateEndAnswer;
        private string $dateStartVote;
        private string $dateEndVote;
        private string $dateCreation;

        public static function createWithId(int $idQuestion, string $author, int $private, string $title, string $description, string $dateStartAnswer, string $dateEndAnswer, string $dateStartVote, string $dateEndVote, string $dateCreation) : Question {
            $q = new Question();
            $q->idQuestion=$idQuestion;
            $q->author = $author;
            $q->private = $private;
            $q->title = $title;
            $q->description = $description;
            $q->dateStartAnswer = $dateStartAnswer;
            $q->dateEndAnswer = $dateEndAnswer;
            $q->dateStartVote = $dateStartVote;
            $q->dateEndVote = $dateEndVote;
            $q->dateCreation = $dateCreation;
            return $q;
        }

        public static function create(string $author, int $private, string $title, string $description,string $dateStartAnswer, string $dateEndAnswer, string $dateStartVote, string $dateEndVote, string $dateCreation) : Question {
            $q = new Question();
            $q->author = $author;
            $q->private = $private;
            $q->title = $title;
            $q->description = $description;
            $q->dateStartAnswer = $dateStartAnswer;
            $q->dateEndAnswer = $dateEndAnswer;
            $q->dateStartVote = $dateStartVote;
            $q->dateEndVote = $dateEndVote;
            $q->dateCreation = $dateCreation;
            return $q;
        }

        public function getObjectAsArray(): array
        {
            return [
                    "loginUser" => $this->author,
                "idQuestion" => $this->idQuestion,
                "private" => $this->private,
                "title" => $this->title,
                "description" => $this->description,
                "dateStartAnswer" => $this->dateStartAnswer,
                "dateEndAnswer" => $this->dateEndAnswer,
                "dateStartVote" => $this->dateStartVote,
                "dateEndVote" => $this->dateEndVote,
                "dateCreation" => $this->dateCreation
            ];
        }

        public function getIdQuestion(): int{
            return $this->idQuestion;
        }

        // all setters and getters

        public function getAuthor(): string{
            return $this->author;
        }

        public function setAuthor(string $author): void{
            $this->author = $author;
        }

        public function getPrivate(): int {
            return $this->private;
        }

        public function setPrivate(int $private): void{
            $this->private = $private;
        }

        public function getTitle(): string{
            return $this->title;
        }

        public function setTitle(string $title): void{
            $this->title = $title;
        }

        public function getDescription(): string{
            return $this->description;
        }

        public function setDescription(string $description): void{
            $this->description = $description;
        }
        
        public function getDateStartAnswer(): string{
            return $this->dateStartAnswer;
        }

        public function setDateStartAnswer(string $dateStartAnswer): void{
            $this->dateStartAnswer = $dateStartAnswer;
        }

        public function getDateEndAnswer(): string{
            return $this->dateEndAnswer;
        }

        public function setDateEndAnswer(string $dateEndAnswer): void{
            $this->dateEndAnswer = $dateEndAnswer;
        }

        public function getDateStartVote(): string{
            return $this->dateStartVote;
        }

        public function setDateStartVote(string $dateStartVote): void{
            $this->dateStartVote = $dateStartVote;
        }

        public function getDateEndVote(): string{
            return $this->dateEndVote;
        }

        public function setDateEndVote(string $dateEndVote): void{
            $this->dateEndVote = $dateEndVote;
        }

        public function getDateCreation(): string{
            return $this->dateCreation;
        }

        public function setDateCreation(string $dateCreation): void{
            $this->dateCreation = $dateCreation;
        }

        public function getDateStartVoteObject(): \DateTime{
            return new \DateTime($this->dateStartVote);
        }

        public function getDateEndVoteObject(): \DateTime{
            return new \DateTime($this->dateEndVote);
        }

        public function getNbSection(): int{
            return QuestionRepository::getNbSection($this->idQuestion);
        }

        public function displayPreview() : string {
            $archived = $this->private == 2;
            \ob_start();
            ?>
            <div class="container flex--column <?php if ($archived) echo "archived"?>">
                <!-- TOP MAIN CONTAINER -->
                <div class="flex--row title">
                    <!-- LOGO -->
                    <img src="../web/svg/pencilQuestionHome.svg" alt="pencil">
                    <!-- TITLE -->
                    <div class='title'>
                        <?php echo $this->getTitle() ?>
                    </div>
                    <?php if ($archived) {?>
                        <form method="POST" action="./frontController.php?controller=question&action=reinstate">
                            <input type="hidden" name="idQuestion" value="<?php echo $this->getIdQuestion()?>"/>
                            <button type="submit" class="flex--row reinstate">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 11L14 15L10 19" stroke="#33363F" stroke-width="2"/>
                                    <path d="M9.67063 6.15333C7.56156 6.4359 5.72985 7.09219 4.51677 7.99993C3.3037 8.90768 2.792 10.005 3.077 11.0874C3.362 12.1698 4.42426 13.1634 6.06589 13.8833C7.70751 14.6031 9.81652 15 12 15" stroke="#33363F" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M19.7942 12.75C20.3852 12.2382 20.7687 11.6733 20.923 11.0874C21.0773 10.5015 20.9992 9.90613 20.6933 9.33531C20.3874 8.7645 19.8597 8.2294 19.1402 7.76057C18.4207 7.29174 17.5236 6.89836 16.5 6.60289" stroke="#33363F" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </form>
                    <?php }?>
                </div>
                <!-- AUTHOR CONTAINER-->
                <div class="flex--row">
                    <!-- AUTHOR NAME TEXT -->
                    <div class="text--author">
                        Par :
                    </div>
                    <!-- AUTHOR RECTANGLE -->
                    <div class="rectangle rectangle--blue">
                        <?php echo $this->getAuthor(); ?>
                    </div>
                </div>
                <!-- SEPARATE BAR -->
                <div class="horizontal--sep"></div>
                <!-- MAIN CONTAINER -->
                <div class="text--resume resume--self">
                    <?php echo $this->getDescription(); ?>
                </div>
                <!-- MORE CONTAINER-->
                <button onclick="document.location.href='../web/frontController.php?controller=question&action=detail&idQuestion=<?php echo $this->getIdQuestion() ?>'" id="know-more" class="flex--row know--more" type="button">
                    > En savoir plus
                </button>
            </div>
            <?php
            return \ob_get_clean();
        }

    }

    



?>