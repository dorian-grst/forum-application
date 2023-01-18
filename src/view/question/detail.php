<main>

    <?php
    if (date('Y-m-d H:i:s') <= $question->getDateEndVoteObject()->format('Y-m-d H:i:s') && date('Y-m-d H:i:s') >= $question->getDateStartVoteObject()->format('Y-m-d H:i:s')) {

    ?>
        <div class="vote container">
            <div class="vote--icon flex--row">
                <div class="vote--icon--svg">
                    <svg width="50" height="50" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="45" height="45" rx="10" fill="#FFFFFF" fill-opacity="0.3" />
                        <path d="M29 19.5333L17 12.6133" stroke="#F1933D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M35 28.3333V17.6667C34.9995 17.199 34.8761 16.7397 34.6421 16.3349C34.408 15.93 34.0717 15.5938 33.6667 15.36L24.3333 10.0267C23.9279 9.79262 23.4681 9.6694 23 9.6694C22.5319 9.6694 22.0721 9.79262 21.6667 10.0267L12.3333 15.36C11.9284 15.5938 11.592 15.93 11.3579 16.3349C11.1239 16.7397 11.0005 17.199 11 17.6667V28.3333C11.0005 28.801 11.1239 29.2603 11.3579 29.6651C11.592 30.07 11.9284 30.4062 12.3333 30.64L21.6667 35.9733C22.0721 36.2074 22.5319 36.3306 23 36.3306C23.4681 36.3306 23.9279 36.2074 24.3333 35.9733L33.6667 30.64C34.0717 30.4062 34.408 30.07 34.6421 29.6651C34.8761 29.2603 34.9995 28.801 35 28.3333Z" stroke="#F1933D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.36 16.28L23 23.0133L34.64 16.28" stroke="#F1933D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M23 36.44V23" stroke="#F1933D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div class="vote--text flex--column">
                <div class="vote--text--title">
                    La question est en train d'être votée.
                </div>
                <div class="vote--text--description">
                    Si vous avez été désigné pour voter sur les réponses, c'est le moment !
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    if (date('Y-m-d H:i:s') >= $question->getDateEndVoteObject()->format('Y-m-d H:i:s')) {
        ?>
        <div class="vote container done">
            <div class="vote--icon flex--row">
                <div class="vote--icon--svg">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5 30.625C24.7487 30.625 30.625 24.7487 30.625 17.5C30.625 10.2513 24.7487 4.375 17.5 4.375C10.2513 4.375 4.375 10.2513 4.375 17.5C4.375 24.7487 10.2513 30.625 17.5 30.625ZM24.1016 13.7652C24.4551 13.3409 24.3978 12.7103 23.9735 12.3568C23.5492 12.0032 22.9187 12.0605 22.5651 12.4848L16.6755 19.5524C16.3288 19.9684 16.1339 20.1988 15.9782 20.3403L15.9723 20.3457L15.9659 20.3409C15.7981 20.214 15.5831 20.0022 15.2002 19.6193L12.3738 16.7929C11.9833 16.4024 11.3501 16.4024 10.9596 16.7929C10.569 17.1834 10.569 17.8166 10.9596 18.2071L13.7859 21.0335L13.8268 21.0743C14.1533 21.401 14.4674 21.7152 14.7596 21.9361C15.087 22.1837 15.5157 22.4165 16.0651 22.3915C16.6145 22.3666 17.0204 22.096 17.324 21.8198C17.595 21.5733 17.8794 21.2319 18.175 20.8771L18.175 20.8771L18.2119 20.8327L24.1016 13.7652Z" fill="#93D976"/>
                    </svg>

                </div>
            </div>
            <div class="vote--text flex--column">
                <div class="vote--text--title">
                    Le vote est terminé !"
                </div>
                <div class="vote--text--description">
                    Consultez les réponses sélectionnées par la communauté.
                </div>
            </div>
        </div>
    <?php } ?>


    <div class="detail container flex--column">
        <div class="detail--tag flex--row">
            <?php
            foreach ($tags as $tag) {
                echo $tag->display();
            }
            ?>
        </div>
        <div class="detail--description">
            <div class="flex--row detail--desc">
                <div class="detail--description--title title">
                    <?php echo $question->getTitle() ?>
                </div>
                <?php
                    use \App\Nig\Model\HTTP\Session;

                    $session = Session::getInstance();
                    if ($session->lire("role") == "Administrateur" || $session->lire("login") == $question->getAuthor()) {
                ?>
                <div class = "detail--description--container">
                    <a href="frontController.php?controller=question&action=update&idQuestion=<?php echo $question->getIdQuestion() ?>">
                        <img class="detail--description--image" src="../web/svg/edit.svg" alt="edit">
                    </a>
                    <form id="deleteQuestionForm" method="POST" action="./frontController.php?action=delete&controller=question" onsubmit="return comfirmPwd()">
                        <script>
                            var comfirmPwd = () => {
                                let pwd = prompt("Comfirmez l'action avec votre mot de passe");
                                let input = document.createElement("input");
                                input.type = "hidden";
                                input.name = "pwd";
                                input.value = pwd;
                                document.getElementById("deleteQuestionForm").appendChild(input);
                                return true;
                            }
                        </script>
                        <input type="hidden" name="idQuestion" value="<?php echo $question->getIdQuestion() ?>"/>
                        <button type="submit" form="deleteQuestionForm">
                            <img class="detail--description--image" src="../web/svg/delete.svg" alt="delete">
                        </button>
                    </form>
                </div>
                <?php } ?>
            </div>
            <div class="detail--description--text">
                <?php echo $question->getDescription() ?>
            </div>
        </div>
        <?php
        foreach ($sections as $section) {
            echo $section->display();
        }
        ?>
        <div class="horizontal--sep"></div>
        <div class="detail--bottom flex--row">
            <div class="detail--bottom--left flex--row">
                <div class="flex--row detail--bottom--left--authors">
                    <img class="flex--row detail--bottom--left--authors--image" src="../web/svg/author.svg" alt="author" />
                    <div>
                        Auteur
                    </div>
                </div>

                <div class="detail--bottom--left--author rectangle rectangle--blue">
                    <div><?php echo $question->getAuthor() ?></div>
                </div>
            </div>
            <div class="flex--column detail--botom--right">
                <div class="detail--bottom--right flex--row">
                    <div class="flex--row detail--bottom--right--dates">
                        <img class="flex--row detail--bottom--right--dates--image" src="../web/svg/calendar.svg" alt="author" />
                        <div>
                            Dates de réponses
                        </div>
                    </div>
                    <div class="detail--bottom--right--date rectangle rectangle--blue">
                        <?php
                        $date = $question->getDateStartAnswer();
                        $dateFr= date('d / m / Y', strtotime($date));
                        echo $dateFr;
                        ?>
                    </div>
                    <div class="detail--bottom--right--date rectangle rectangle--blue">
                        <?php
                        $date = $question->getDateEndAnswer();
                        $dateFr= date('d / m / Y', strtotime($date));
                        echo $dateFr;
                        ?>
                    </div>

                </div>
                <div class="detail--bottom--right flex--row">
                    <div class="flex--row detail--bottom--right--dates">
                        <img class="flex--row detail--bottom--right--dates--image" src="../web/svg/calendar.svg" alt="author" />
                        <div>
                            Dates de votes
                        </div>
                    </div>
                    <div class="detail--bottom--right--date rectangle rectangle--blue">
                        <?php
                        $date = $question->getDateStartVote();
                        $dateFr= date('d / m / Y', strtotime($date));   
                        echo $dateFr;
                        ?>
                    </div>
                    <div class="detail--bottom--right--date rectangle rectangle--blue">
                        <?php
                        $date = $question->getDateEndVote();
                        $dateFr= date('d / m / Y', strtotime($date));
                        echo $dateFr;
                        ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <form method="POST" action="frontController.php?controller=answer&action=voted">

        <input type="hidden" name="id-question" value="<?php echo $question->getIdQuestion() ?>">

        <button id="send-votes" class="flex--row create--submit--button valid" type="submit">
            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="45" height="45" rx="10" fill="#7E84E7" />
                <path d="M26.5479 17.2665C27.2473 16.4116 27.1213 15.1515 26.2664 14.4521C25.4116 13.7526 24.1515 13.8786 23.4521 14.7335L15.6661 24.2496L13.2 22.4C12.3163 21.7373 11.0627 21.9163 10.4 22.8C9.73723 23.6837 9.91631 24.9373 10.8 25.6L14.0331 28.0248C15.3191 28.9894 17.1369 28.7687 18.1549 27.5245L26.5479 17.2665Z" stroke="white" stroke-width="2" stroke-linecap="round" />
                <mask id="path-3-outside-1_102_94" maskUnits="userSpaceOnUse" x="17.8694" y="13" width="18" height="17" fill="black">
                    <rect fill="white" x="17.8694" y="13" width="18" height="17" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8694 26.5761L21.603 27.163C22.4589 27.8477 23.7063 27.716 24.4003 26.8677L32.774 16.6332C33.1237 16.2058 33.0607 15.5758 32.6333 15.226C32.2058 14.8763 31.5758 14.9393 31.2261 15.3668L22.8524 25.6013L22.1359 25.0281L20.8694 26.5761Z" />
                </mask>
                <path d="M21.603 27.163L20.3536 28.7247L20.3536 28.7247L21.603 27.163ZM20.8694 26.5761L19.3215 25.3096L18.041 26.8746L19.62 28.1378L20.8694 26.5761ZM24.4003 26.8677L22.8524 25.6013H22.8524L24.4003 26.8677ZM32.774 16.6332L31.2261 15.3668V15.3668L32.774 16.6332ZM32.6333 15.226L31.3668 16.774H31.3668L32.6333 15.226ZM31.2261 15.3668L29.6782 14.1003L31.2261 15.3668ZM22.8524 25.6013L21.603 27.163L23.1477 28.3987L24.4003 26.8677L22.8524 25.6013ZM22.1359 25.0281L23.3853 23.4663L21.8407 22.2306L20.588 23.7616L22.1359 25.0281ZM22.8524 25.6013L22.1188 25.0143L19.62 28.1378L20.3536 28.7247L22.8524 25.6013ZM22.8524 25.6013L22.8524 25.6013L20.3536 28.7247C22.0653 30.0941 24.5602 29.8307 25.9482 28.1342L22.8524 25.6013ZM31.2261 15.3668L22.8524 25.6013L25.9482 28.1342L34.3219 17.8997L31.2261 15.3668ZM31.3668 16.774C30.9394 16.4242 30.8764 15.7942 31.2261 15.3668L34.3219 17.8997C35.3711 16.6174 35.1821 14.7273 33.8998 13.6781L31.3668 16.774ZM32.774 16.6332C32.4243 17.0607 31.7943 17.1237 31.3668 16.774L33.8998 13.6781C32.6174 12.6289 30.7274 12.818 29.6782 14.1003L32.774 16.6332ZM24.4003 26.8677L32.774 16.6332L29.6782 14.1003L21.3045 24.3348L24.4003 26.8677ZM20.8865 26.5898L21.603 27.163L24.1018 24.0395L23.3853 23.4663L20.8865 26.5898ZM20.588 23.7616L19.3215 25.3096L22.4173 27.8426L23.6839 26.2946L20.588 23.7616Z" fill="white" mask="url(#path-3-outside-1_102_94)" />
            </svg>
            <div>
                ENVOYER LES VOTES SAISIE
            </div>
        </button>


        <div class="interrogation flex--row">
            <div class="interrogation--rectangle">
                !
            </div>
            <div class="interrogation--text">
                Réponses<?php echo  " (" . count($answers) . ")" ?>
            </div>
        </div>

        <?php
        foreach ($answers as $answer) {
            echo $answer->display();
        }
        ?>
    </form>
    <script src="../web/js/voting.js"></script>
</main>