<?php
namespace App\Nig\Controller;
use App\Nig\Lib\MessageFlash;
use App\Nig\Model\DataObject\Question;
use App\Nig\Model\DataObject\Section;
use App\Nig\Model\DataObject\Tag;
use App\Nig\Model\DataObject\User;
use App\Nig\Model\HTTP\Session;
use App\Nig\Model\DataObject\Answer;
use App\Nig\Model\Repository\AnswerRepository;
use App\Nig\Model\Repository\DatabaseConnection;
use App\Nig\Model\Repository\QuestionRepository;
use App\Nig\Model\Repository\SectionRepository;
use App\Nig\Model\Repository\TagRepository;
use App\Nig\Model\Repository\UserRepository;

class ControllerQuestion
{
    public static function home(): void
    {
        $questions = QuestionRepository::getAllQuestionsOrdered();
        $baseArray = [
            "questions" => $questions,
            "pageTitle" => "accueil",
            "cheminVueBody" => "question/home.php"
        ];
        self::displayView("./view.php", $baseArray);
    }

    public static function create(): void
    {
        self::displayView("./view.php", [
            "pageTitle" => "create",
            "cheminVueBody" => "question/create.php",
            "users" => UserRepository::allUser()]);
    }

    public static function update(): void
    {
        self::displayView("./view.php", [
            "pageTitle" => "Edition",
            "cheminVueBody" => "question/create.php",
            "question" => QuestionRepository::getQuestionById($_GET["idQuestion"]),
            "tags" => TagRepository::getTagsByQuestionId($_GET["idQuestion"]),
            "voters" => UserRepository::getAllVotersByQuestionId($_GET["idQuestion"]),
            "collaborators" => UserRepository::getAllCollaboratorsByQuestionId($_GET["idQuestion"]),
            "users" => UserRepository::allUser(),
        ]);
    }

    public static function detail(): void
    {
        $idQuestion = $_GET["idQuestion"];
        $question = QuestionRepository::getQuestionById($idQuestion);
        $tags = TagRepository::getTagsByQuestionId($idQuestion);
        $sections = SectionRepository::getSectionsByQuestionId($idQuestion);
        $answers = AnswerRepository::getAnswersByQuestionId($idQuestion);

        self::displayView("./view.php", [
            "question" => $question,
            "tags" => $tags,
            "sections" => $sections,
            "answers" => $answers,
            "pageTitle" => "détail",
            "cheminVueBody" => "question/detail.php",
            "answers" => $answers]);
    }

    public static function displayView(string $pathView, array $parameters = [])
    {
        extract($parameters); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../$pathView"; // Charge la vue
    }

    public static function updated(): void
    {
        $autor = "baka";
        $private = $_POST['visibility'] == "private" ? true : false;
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $dateCreation = date("Y-m-d H:i:s");
        $idQuestion = \htmlspecialchars($_POST['idQuestion']);
        $question = Question::createWithId($idQuestion, $autor, $private, $title, $description, $_POST['dateStartAnswer'], $_POST['dateEndAnswer'], $_POST['dateStartVote'], $_POST['dateEndVote'], $dateCreation);
        QuestionRepository::updateQuestion($question);

        TagRepository::deleteAllTagsByQuestionId($idQuestion);

        $nbTags = $_POST['nb-tags'];
        for ($i = 1; $i <= $nbTags; $i++) {
            $nomTag = htmlspecialchars($_POST['tag-' . $i]);
            $tag = new Tag(null, $nomTag, $idQuestion);
            TagRepository::save($tag);
        }

        SectionRepository::deleteAllSectionsByQuestionId($idQuestion);

        $nbSections = $_POST['nb-sections'];
        for ($i = 1; $i <= $nbSections; $i++) {
            $nameSection = htmlspecialchars($_POST['titre-section-' . $i]);
            $descriptionSection = htmlspecialchars($_POST['description-section-' . $i]);
            $section = new Section(null, $nameSection, $descriptionSection, $idQuestion);
            SectionRepository::save($section);
        }

        UserRepository::resetVotersAndCollaboratorsByQuestionId($idQuestion);

        $dataVoters=$_POST['allVoters'];
        $dataCollaborators=$_POST['allContributors'];
        
        $voters=explode("_",$dataVoters);
        for($i=0;$i<count($voters);$i++){
            UserRepository::addVoter($voters[$i],$idQuestion);
        }

        $contributors=explode("_",$dataCollaborators);
        for ($i=0;$i<count($contributors);$i++) {
            UserRepository::setCollaborator($contributors[$i],$idQuestion);
        }

        MessageFlash::ajouter("success", "La question a été modifiée avec succès");
        header("Location: frontController.php?action=home");
    }

    public static function tryToUpdate(): void {
        if ($_POST['dateStartAnswer'] < $_POST['dateEndAnswer'] && $_POST['dateEndAnswer'] < $_POST['dateStartVote'] && $_POST['dateStartVote'] < $_POST['dateEndVote']) {
            self::updated();
        }
        else {
            MessageFlash::ajouter("danger", "La question n'a pas été modifiée car les dates ne correspondent pas.");
            header("Location: frontController.php?action=update&idQuestion=" . $_POST['idQuestion']);
        }
    }

    public static function reinstate(): void {
        $session = Session::getInstance();
        if (!$session->contient("role") || $session->lire("role") != "Administrateur") return;
        $idQuestion = $_POST['idQuestion'];

        QuestionRepository::reinstateQuestionById($idQuestion);
        MessageFlash::ajouter("success", "La question a été restaurée avec succès !");
        self::home();
    }


    public static function created(): void  {
        $session=Session::getInstance();
        $autor = $session->lire('login');
        $private = $_POST['visibility'] == "private" ? 1 : 0;
        $title=htmlspecialchars($_POST['title']);
        $description=htmlspecialchars($_POST['description']);
        $dateCreation = date("Y-m-d H:i:s");
        $question= Question::create($autor, $private, $title, $description, $_POST['dateStartAnswer'], $_POST['dateEndAnswer'], $_POST['dateStartVote'], $_POST['dateEndVote'], $dateCreation);
        $idQuestion=QuestionRepository::save($question);

        $nbSections=\htmlspecialchars($_POST['nb-sections']);
        for ($i=1; $i<=$nbSections;$i++) {
            $titleSection = htmlspecialchars($_POST['titre-section-'.$i]);
            $content = htmlspecialchars($_POST['description-section-'.$i]);
            $section = Section::create($titleSection,$content,$idQuestion);
            SectionRepository::save($section);
        }

        $nbTags = $_POST['nb-tags'];
        $tabTag = [];
        for ($i=1; $i<=$nbTags;$i++) {
            $nomTag = htmlspecialchars($_POST['tag-'.$i]);
            if (!in_array(strtolower($nomTag), $tabTag)) {
                $tag = new Tag(null, $nomTag,$idQuestion);
                TagRepository::save($tag);
                $tabTag[] = strtolower($nomTag);
            }
        }

        $dataVoters=$_POST['allVoters'];
        $dataCollaborators=$_POST['allContributors'];

        UserRepository::addAutor($session->lire('login'),$idQuestion);
        $voters=explode("_",$dataVoters);
        for($i=0;$i<count($voters);$i++){
            UserRepository::addVoter($voters[$i],$idQuestion);
        }
        echo("caca 2");
        $contributors=explode("_",$dataCollaborators);
        for ($i=0;$i<count($contributors);$i++) {
            UserRepository::setCollaborator($contributors[$i],$idQuestion);
        }

        MessageFlash::ajouter("success", "La question a été créée avec succès.");
        header("Location: frontController.php?action=home");
    }

    public static function tryToCreate(): void {
        if ($_POST['dateStartAnswer'] < $_POST['dateEndAnswer'] && $_POST['dateEndAnswer'] < $_POST['dateStartVote'] && $_POST['dateStartVote'] < $_POST['dateEndVote'] && $_POST['allVoters'] != '') {
            self::created();
        } else if ($_POST['allVoters'] == '') {
            MessageFlash::ajouter("danger", "La question n'a pas été créée car il n'y a pas de votants.");
            self::create();
        } else {
            MessageFlash::ajouter("danger", "La question n'a pas été créée car les dates ne correspondent pas.");
            self::create();
        }
    }
    
    public static function allAnswers():void {

    }

    public static function delete(): void {
        $session = Session::getInstance();
        $isAuth = UserRepository::authentificate($_POST['pwd']);

        if (!$isAuth) {
            MessageFlash::ajouter("danger", "Mot de passe incorrect, la question n'a pas été supprimée.");
        }else {
            MessageFlash::ajouter("success", "La question a été supprimée avec succès !");
            QuestionRepository::archiveQuestionById($_POST['idQuestion']);
        }

        self::home();
    }
}
?>