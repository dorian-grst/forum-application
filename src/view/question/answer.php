<main>
    <form method="POST" action="frontController.php?controller=answer&action=tryToAnswer">
        <div class="container flex--column">
            <div class="flex--column answer--head">
                <div class="flex--row answer--head--title title">
                    <div class="carre">
                        <img class="answer--head--title--image" src="../web/svg/question.svg" alt="question">
                    </div>
                    <div>
                        Question : <br>
                        <?php echo $question->getTitle(); ?>
                    </div>
                </div>
                <div class="answer--head--description">
                    <?php echo $question->getDescription(); ?>
                </div>
            </div>
            <div class="horizontal--sep"></div>
            <section class="flex--column answer--section">
                <div class="flex--row answer--section--title section--title">
                    <img class="answer--section--title--image" src="../web/svg/section.svg" alt="section">
                    <div>Section : <?php echo $section->getTitle() ?> </div>
                </div>
                <input type="hidden" name="idSection" value="<?php echo $section->getIdSection() ?>">
                <div class="answer--section--description">
                    <?php echo $section->getContent() ?>
                </div>

                <div class="flex--column">
                    <label>Votre réponse à cette section</label>
                    <textarea class="answer--section--textarea" name="content" rows="10" cols="50"
                        placeholder="Entrer votre réponse pour cette section" required value="$desc"></textarea>
                </div>
            </section>
            <div class="horizontal--sep"></div>
            <button id="answer-question" class="flex--row answer--submit--button not-valid">
                <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="45" height="45" rx="10" fill="#C7CFFA" />
                    <path
                        d="M26.5479 17.2665C27.2473 16.4116 27.1213 15.1515 26.2664 14.4521C25.4116 13.7526 24.1515 13.8786 23.4521 14.7335L15.6661 24.2496L13.2 22.4C12.3163 21.7373 11.0627 21.9163 10.4 22.8C9.73723 23.6837 9.91631 24.9373 10.8 25.6L14.0331 28.0248C15.3191 28.9894 17.1369 28.7687 18.1549 27.5245L26.5479 17.2665Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" />
                    <mask id="path-3-outside-1_102_94" maskUnits="userSpaceOnUse" x="17.8694" y="13" width="18"
                        height="17" fill="black">
                        <rect fill="white" x="17.8694" y="13" width="18" height="17" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M20.8694 26.5761L21.603 27.163C22.4589 27.8477 23.7063 27.716 24.4003 26.8677L32.774 16.6332C33.1237 16.2058 33.0607 15.5758 32.6333 15.226C32.2058 14.8763 31.5758 14.9393 31.2261 15.3668L22.8524 25.6013L22.1359 25.0281L20.8694 26.5761Z" />
                    </mask>
                    <path
                        d="M21.603 27.163L20.3536 28.7247L20.3536 28.7247L21.603 27.163ZM20.8694 26.5761L19.3215 25.3096L18.041 26.8746L19.62 28.1378L20.8694 26.5761ZM24.4003 26.8677L22.8524 25.6013H22.8524L24.4003 26.8677ZM32.774 16.6332L31.2261 15.3668V15.3668L32.774 16.6332ZM32.6333 15.226L31.3668 16.774H31.3668L32.6333 15.226ZM31.2261 15.3668L29.6782 14.1003L31.2261 15.3668ZM22.8524 25.6013L21.603 27.163L23.1477 28.3987L24.4003 26.8677L22.8524 25.6013ZM22.1359 25.0281L23.3853 23.4663L21.8407 22.2306L20.588 23.7616L22.1359 25.0281ZM22.8524 25.6013L22.1188 25.0143L19.62 28.1378L20.3536 28.7247L22.8524 25.6013ZM22.8524 25.6013L22.8524 25.6013L20.3536 28.7247C22.0653 30.0941 24.5602 29.8307 25.9482 28.1342L22.8524 25.6013ZM31.2261 15.3668L22.8524 25.6013L25.9482 28.1342L34.3219 17.8997L31.2261 15.3668ZM31.3668 16.774C30.9394 16.4242 30.8764 15.7942 31.2261 15.3668L34.3219 17.8997C35.3711 16.6174 35.1821 14.7273 33.8998 13.6781L31.3668 16.774ZM32.774 16.6332C32.4243 17.0607 31.7943 17.1237 31.3668 16.774L33.8998 13.6781C32.6174 12.6289 30.7274 12.818 29.6782 14.1003L32.774 16.6332ZM24.4003 26.8677L32.774 16.6332L29.6782 14.1003L21.3045 24.3348L24.4003 26.8677ZM20.8865 26.5898L21.603 27.163L24.1018 24.0395L23.3853 23.4663L20.8865 26.5898ZM20.588 23.7616L19.3215 25.3096L22.4173 27.8426L23.6839 26.2946L20.588 23.7616Z"
                        fill="white" mask="url(#path-3-outside-1_102_94)" />
                </svg>
                <div>
                    CRÉER LA RÉPONSE
                </div>
            </button>
        </div>
    </form>
    <input type="hidden" id="type-of-page" value="answer">
    <script src="../web/js/create-question-validity.js"></script>
</main>