<main>
    <script src="../web/js/profileContent.js"></script>
    <div class="flex--column profile--background">
    </div>
    <div class="flex--column profile--container">
        <div class="flex--row align--center">
            <div class="flex--row profile--username">
                <img class='nav--user--picture profile--user--picture' src="<?php echo $session->lire('avatarUrl') ?>" alt='picture'>
                <?php $session = \App\Nig\Model\HTTP\Session::getInstance();
                echo $session->lire('login');
                ?>
                <div class="profil--username--role rectangle rectangle--orange margin__top5left5">
                <?php $session = \App\Nig\Model\HTTP\Session::getInstance();

                if ($session->contient('role')) {
                    echo $session->lire('role');
                }
                ?>
            </div>
            </div>
        </div>
        <div class="horizontal--sep"></div>
        <div class="flex--row profile--content">
            <div class="flex--column">
                <div onclick="changeContent('info')" class="option--profile">
                    <input  type="radio" id="info" name="profile" value="info" checked/>
                    <label class="btn" for="info">
                    Mes informations
                    </label>
                </div>
                <div onclick="changeContent('question')" class="option--profile">
                    <input  type="radio" id="question" name="profile" value="question"/>
                    <label class="btn" for="question">
                    Mes questions
                    </label>
                </div>
                <div onclick="changeContent('answer')" class="option--profile">
                    <input  type="radio" id="answer" name="profile" value="answer"/>
                    <label class="btn" for="answer">
                    Mes réponses
                    </label>
                </div>
                <div class="deconnexion"> <a class="contenu--deconnexion" href="frontController.php?controller=user&action=deconnected">
                        Déconnexion
                        <svg width="25" height="28" viewBox="0 0 31 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 12.9752C0 10.2138 2.23858 7.97522 5 7.97522H11.26V18.486H0V12.9752Z" fill="white" />
                            <path d="M0 23.7415H11.26V34.2522H5C2.23858 34.2522 0 32.0136 0 29.2522V23.7415Z" fill="white" />
                            <path d="M3.75339 7.99669L23.5557 7.99669L23.5557 20.2378L3.75339 7.99669Z" fill="white" />
                            <path d="M24.0098 20.5201L24.0097 34.3666L5.5 34.3666L24.0098 20.5201Z" fill="white" />
                            <path d="M23.4583 7.97522V7.97522C26.0494 7.97522 28.1499 10.0758 28.1499 12.6669V29.5604C28.1499 32.1516 26.0494 34.2521 23.4583 34.2521V34.2521V7.97522Z" fill="white" />
                        </svg></a>

                </div>
            </div>
            <div class="profile--information">
                <div class="flex--column content--info ">
                    <div>Nom d'utilisateur : <?php $session = \App\Nig\Model\HTTP\Session::getInstance();
                        echo $session->lire('nameUser');

                        ?></div>
                    <div>Adresse mail : <?php $session = \App\Nig\Model\HTTP\Session::getInstance();
                        echo $session->lire('mail');
                        ?></div>
                </div>
                <div class="flex--column content--answer content--none">
                    <?php
                    $answers = \App\Nig\Model\Repository\AnswerRepository::getAnswersByUser($session->lire('login'));

                    foreach ($answers as $answer){
                        $id = $answer->getSectionId();
                        $sec=\App\Nig\Model\Repository\SectionRepository::getSectionById($id);
                        $titleSec = $sec->getTitle();
                        $idQ = $sec->getIdQuestion();
                        $quest = \App\Nig\Model\Repository\QuestionRepository::getQuestionById($idQ);
                        echo "<div class='profile--rectangle'>
                        $titleSec
                        <div class='profile--separation'></div>
                        <div class='question--answered'>En réponse à :</div>
                        <div class='question--asked'> $quest</div>
                    </div>";}
                    ?>
                </div>
                <div class="flex--column content--question content--none">
                    <?php
                    $questions = \App\Nig\Model\Repository\QuestionRepository::getQuestionsByUser($session->lire('login'));
                    foreach ($questions as $question){
                        $title = $question->getTitle();
                        echo "<div class='profile--rectangle'> $title </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</main>
