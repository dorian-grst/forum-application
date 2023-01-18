<?php 

use App\Nig\Model\Repository\SectionRepository;
use App\Nig\Model\DataObject\Section;
?>
<main class="flex--column">
    <form method="POST" action="frontController.php?action=<?php echo $pageTitle == "create" ? "tryToCreate" : "tryToUpdate" ?>">
        <input name="idQuestion" type="hidden" value=<?php echo $pageTitle == "create" ? "" : $question->getIdQuestion() ?>>
        <div class="flex--column container">
            <div class="flex--row create--head">
                <div class="flex--row create--head--title title">
                    <div class="carre">
                        <img class="create--head--title--image" src="../web/svg/question.svg" alt="question">
                    </div>
                    <div>
                        <?php echo $pageTitle == "create" ? "Création de la question" : "Edition de la question" ?>
                    </div>
                </div>
                <div class="flex--row create--head--visibility">
                    <label>
                        Visibilité:
                    </label>
                    <div id="visibility-switcher" class="flex--row create--head--visibility--value">
                        <div>
                            Public
                        </div>
                        <img src="../web/svg/public.svg">
                        <input id="visibility-input" type="hidden" name="visibility" value="public">
                    </div>
                </div>
            </div>
            <div id="tag" class="flex--row create--votants">
                <label>
                    Ajouter des votant(s):
                </label>
                <button id="add-owo" class="rectangle rectangle--green" type="button">
                    + Ajouter
                </button>
                <?php
                    if ($pageTitle != "create") {
                        foreach (array_merge($voters, $collaborators) as $voter) {
                            echo '<div class="rectangle rectangle--blue" id="' . $voter . 'Tag">' . $voter . '</div>';
                        }
                    }
                ?>
            </div>
            <div class="horizontal--sep "></div>
            <section class="flex--row create--infos">
                <div class="flex--column create--infos--metadata">
                    <div class="flex--column input">
                        <label>Titre</label>
                        <input type="text" placeholder="Le titre est..." name="title" required value="<?php echo $pageTitle == "create" ? '' : $question->getTitle() ?>">
                    </div>

                    <div class="flex--column create--infos--tags">
                        <label>Tag(s)</label>
                        <div class="flex--row create--infos--tags--list">
                            <div id="tag-preview--list">
                                <div id="tag-example-1" class="rectangle tag-example" <?php if ($pageTitle != "create") echo 'style="display: none;"' ?>>
                                    Exemple de tag : Sport
                                </div>
                                <?php
                                    if ($pageTitle != "create") {
                                        foreach ($tags as $i => $tag) {
                                            $i += 1;
                                            echo '<div class="rectangle rectangle--blue tag-rectangle" id="small-tag-' . $i . '">';
                                            echo $tag->getName();
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </div>
                            <button id="tags--count" class="rectangle--3--points rectangle--blue" type="button">
                                ...
                            </button>
                            <button id="open-tag-management" class="rectangle rectangle--green" type="button">
                                +
                            </button>
                        </div>
                        <div id="tag-management">
                            <input id="nb-tags-input" type="hidden" name="nb-tags" value="<?php echo ($pageTitle == "create" ? 0 : count($tags)) ?>">
                            <div class="tag-management--top">
                                <div class="tag-management--tag-list">
                                    <div id="tag-example-2" class="rectangle tag-example" <?php if ($pageTitle != "create") echo 'style="display: none;"' ?>>
                                        Exemple de tag : Sport
                                    </div>
                                    <?php
                                        if ($pageTitle != "create") {
                                            foreach ($tags as $i => $tag) {
                                                $i += 1;
                                                echo '<div class="rectangle rectangle--blue tag-rectangle" id="tag-' . $i . '">';
                                                echo $tag->getName();
                                                echo '</div>';
                                            }
                                        }
                                    ?>
                                </div>
                                <img id="close-tag-management" src="../web/svg/delete-section.svg" class="tag-management--close-button" alt="tag-management">
                            </div>
                            <div class="tag-management--add-tag">
                                <input id="tag-input" class="tag-management--tag-input input" type="text" value="" placeholder="Enter a tag">
                                <button id="add-tag-button" class="rectangle rectangle--green" type="button">
                                    + Ajouter
                                </button>
                            </div>
                            <?php
                                if ($pageTitle != "create") {
                                    foreach ($tags as $i => $tag) {
                                        $i += 1;
                                        echo '<input type="hidden" name="tag-' . $i . '" id="input-tag-' . $i . '" value="' . $tag->getName() . '">';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="vertical--sep"></div>
                <div class="flex--column create--infos--responsables">
                    <label>Ajouter des responsable(s):</label>
                    <div id="listCollaborator" class="flex--row create--infos--responsables--list">
                        <button id="add-uwu" class="rectangle rectangle--green" type="button">
                            + Ajouter
                        </button>
                        <?php
                            if ($pageTitle != "create") {
                                foreach ($collaborators as $collaborator) {
                                    echo '<div id="' . $collaborator . '_TagR" class="rectangle rectangle--purple">' . $collaborator .  '</div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </section>
            <div class="horizontal--sep"></div>
            <section class="flex--column create--dates">
                <div class="flex--row create--dates--title section--title">
                    <img class="create--dates--title--image" src="../web/svg/date.svg" alt="date">
                    <div>
                        VOTES & RÉPONSES
                    </div>
                </div>
                <div class="flex--row create--date--inputs">
                    <div class="flex--column create--date--input--open input">
                        <label>Date d'ouverture des réponses</label>
                        <input type="date" name="dateStartAnswer" required value=<?php echo $pageTitle == "create" ? "" : $question->getDateStartAnswer() ?>>
                    </div>
                    <div class="flex--column create--date--input--close input">
                        <label>Date de clôture des réponses</label>
                        <input type="date" name="dateEndAnswer" required value=<?php echo $pageTitle == "create" ? "" : $question->getDateEndAnswer() ?>>
                    </div>
                </div>
                <div class="flex--row create--date--inputs">
                    <div class="flex--column create--date--input--open input">
                        <label>Date d'ouverture des votes</label>
                        <input type="date" name="dateStartVote" required value=<?php echo $pageTitle == "create" ? "" : $question->getDateStartVote() ?>>
                    </div>
                    <div class="flex--column create--date--input--close input">
                        <label>Date de clôture des votes</label>
                        <input type="date" name="dateEndVote" required value=<?php echo $pageTitle == "create" ? "" : $question->getDateEndVote() ?>>
                    </div>
                </div>

            </section>
            <div class="horizontal--sep"></div>
            <section class="flex--column create--description">
                <div class="flex--row create--description--title section--title">
                    <img class="create--description--title--image" src="../web/svg/description.svg" alt="description">
                    <div>DESCRIPTION</div>
                </div>
                <div class="input">
                    <label>
                        Décrivez votre question en quelques mots
                    </label>
                    <textarea class="create--description--textarea" name="description" placeholder="Description de la question" rows="10" cols="50" required><?php echo $pageTitle == "create" ? "" : $question->getDescription() ?></textarea>
                </div>
            </section>
            <div class="horizontal--sep"></div>
            <section class="flex--column create--section">
                <div class="flex--row creation--section--title section--title">
                    <img class="creation--section--title--image" src="../web/svg/section.svg" alt="section">
                    <div>SECTION(S)</div>
                </div>
                <?php
                $nbSections = 0;
                if ($pageTitle != "create") {
                    $sections = SectionRepository::getSectionsByQuestionId($question->getIdQuestion());
                    $nbSections = count($sections);
                    $i = 0;
                    foreach ($sections as $section) {
                        $i++;
                        $desc = count($sections) == 0 ? "" : $section->getContent();
                        $titre = count($sections) == 0 ? "" : $section->getTitle();
                        $sectionHTML = <<<XYZ
                        <div id="section-$i" class="flex--column create--section--container">
                            <div class="flex--column input">
                                <div class="top-section">
                                    <label>Titre de la section n°$i</label>
                                    <span class="delete-section-span">
                                        <svg id="delete-section-$i" class="delete-section" xmlns="http://www.w3.org/2000/svg" height="48" width="48">
                                            <path d="m16.5 33.6 7.5-7.5 7.5 7.5 2.1-2.1-7.5-7.5 7.5-7.5-2.1-2.1-7.5 7.5-7.5-7.5-2.1 2.1 7.5 7.5-7.5 7.5ZM24 44q-4.1 0-7.75-1.575-3.65-1.575-6.375-4.3-2.725-2.725-4.3-6.375Q4 28.1 4 24q0-4.15 1.575-7.8 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24 4q4.15 0 7.8 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Zm0-3q7.1 0 12.05-4.975Q41 31.05 41 24q0-7.1-4.95-12.05Q31.1 7 24 7q-7.05 0-12.025 4.95Q7 16.9 7 24q0 7.05 4.975 12.025Q16.95 41 24 41Zm0-17Z" />
                                        </svg>
                                    </span>
                                </div>
                                <input name="titre-section-$i" type="text" placeholder="Titre de la section" required value="$titre"/>
                            </div>
                            <div class="flex--column">
                                <label>Description de la section</label>
                                <textarea class="create--section--textarea" name="description-section-$i" rows="10" cols="50" placeholder="Description de la section" required>$desc</textarea>
                            </div>
                        </div>
                        XYZ;
                        echo $sectionHTML;
                    }
                }
                if ($pageTitle == "create" || $nbSections == 0) {
                ?>
                    <div id="section-1" class="flex--column create--section--container">
                            <div class="flex--column input">
                                <div class="top-section">
                                    <label>Titre de la section n°1</label>
                                    <span class="delete-section-span">
                                        <svg id="delete-section-1" class="delete-section" xmlns="http://www.w3.org/2000/svg" height="48" width="48">
                                            <path d="m16.5 33.6 7.5-7.5 7.5 7.5 2.1-2.1-7.5-7.5 7.5-7.5-2.1-2.1-7.5 7.5-7.5-7.5-2.1 2.1 7.5 7.5-7.5 7.5ZM24 44q-4.1 0-7.75-1.575-3.65-1.575-6.375-4.3-2.725-2.725-4.3-6.375Q4 28.1 4 24q0-4.15 1.575-7.8 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24 4q4.15 0 7.8 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Zm0-3q7.1 0 12.05-4.975Q41 31.05 41 24q0-7.1-4.95-12.05Q31.1 7 24 7q-7.05 0-12.025 4.95Q7 16.9 7 24q0 7.05 4.975 12.025Q16.95 41 24 41Zm0-17Z" />
                                        </svg>
                                    </span>
                                </div>
                                <input name="titre-section-1" type="text" placeholder="Titre de la section" required>
                            </div>
                            <div class="flex--column">
                                <label>Description de la section</label>
                                <textarea class="create--section--textarea" name="description-section-1" rows="10" cols="50" placeholder="Description de la section" required></textarea>
                            </div>
                        </div>
                <?php
                }
                ?>
            </section>
            <input type="hidden" id="nb-sections" name="nb-sections" value="<?php echo $nbSections == 0 ? 1 : $nbSections ?>">
            <button id="add-section" class="flex--row create--add--section">
                + Ajouter une section
            </button>
        </div>
        <button id="create-question" class="flex--row create--submit--button not-valid" type="submit">
            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="45" height="45" rx="10" fill="#C7CFFA" />
                <path d="M26.5479 17.2665C27.2473 16.4116 27.1213 15.1515 26.2664 14.4521C25.4116 13.7526 24.1515 13.8786 23.4521 14.7335L15.6661 24.2496L13.2 22.4C12.3163 21.7373 11.0627 21.9163 10.4 22.8C9.73723 23.6837 9.91631 24.9373 10.8 25.6L14.0331 28.0248C15.3191 28.9894 17.1369 28.7687 18.1549 27.5245L26.5479 17.2665Z" stroke="white" stroke-width="2" stroke-linecap="round" />
                <mask id="path-3-outside-1_102_94" maskUnits="userSpaceOnUse" x="17.8694" y="13" width="18" height="17" fill="black">
                    <rect fill="white" x="17.8694" y="13" width="18" height="17" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8694 26.5761L21.603 27.163C22.4589 27.8477 23.7063 27.716 24.4003 26.8677L32.774 16.6332C33.1237 16.2058 33.0607 15.5758 32.6333 15.226C32.2058 14.8763 31.5758 14.9393 31.2261 15.3668L22.8524 25.6013L22.1359 25.0281L20.8694 26.5761Z" />
                </mask>
                <path d="M21.603 27.163L20.3536 28.7247L20.3536 28.7247L21.603 27.163ZM20.8694 26.5761L19.3215 25.3096L18.041 26.8746L19.62 28.1378L20.8694 26.5761ZM24.4003 26.8677L22.8524 25.6013H22.8524L24.4003 26.8677ZM32.774 16.6332L31.2261 15.3668V15.3668L32.774 16.6332ZM32.6333 15.226L31.3668 16.774H31.3668L32.6333 15.226ZM31.2261 15.3668L29.6782 14.1003L31.2261 15.3668ZM22.8524 25.6013L21.603 27.163L23.1477 28.3987L24.4003 26.8677L22.8524 25.6013ZM22.1359 25.0281L23.3853 23.4663L21.8407 22.2306L20.588 23.7616L22.1359 25.0281ZM22.8524 25.6013L22.1188 25.0143L19.62 28.1378L20.3536 28.7247L22.8524 25.6013ZM22.8524 25.6013L22.8524 25.6013L20.3536 28.7247C22.0653 30.0941 24.5602 29.8307 25.9482 28.1342L22.8524 25.6013ZM31.2261 15.3668L22.8524 25.6013L25.9482 28.1342L34.3219 17.8997L31.2261 15.3668ZM31.3668 16.774C30.9394 16.4242 30.8764 15.7942 31.2261 15.3668L34.3219 17.8997C35.3711 16.6174 35.1821 14.7273 33.8998 13.6781L31.3668 16.774ZM32.774 16.6332C32.4243 17.0607 31.7943 17.1237 31.3668 16.774L33.8998 13.6781C32.6174 12.6289 30.7274 12.818 29.6782 14.1003L32.774 16.6332ZM24.4003 26.8677L32.774 16.6332L29.6782 14.1003L21.3045 24.3348L24.4003 26.8677ZM20.8865 26.5898L21.603 27.163L24.1018 24.0395L23.3853 23.4663L20.8865 26.5898ZM20.588 23.7616L19.3215 25.3096L22.4173 27.8426L23.6839 26.2946L20.588 23.7616Z" fill="white" mask="url(#path-3-outside-1_102_94)" />
            </svg>
            <div>
                <?php echo $pageTitle == "create" ? "CRÉER LA QUESTION" : "MODIFIER LA QUESTION" ?>
            </div>
        </button>
        <div id="popup" style="display: none" class="select container flex--column">
                        <div class="select--head--title title flex--row">
                            <div class="carre">
                                <img class="select--head--title--image" src="../web/svg/add.svg">
                            </div>
                            <div>
                                Ajout des participants
                            </div>
                        </div>
                        <div class="select--head--exemple flex--row">
                            <label class="select--head--exemple--pseudo">
                                Pseudo
                            </label>
                            <div class="select--head--exemple--votant flex--row">
                                <label>
                                    Votant
                                </label>
                                <img class="select--head--exemple--votant--image" src="../web/svg/addmultiple.svg" alt="addmultiple">
                            </div>
                            <div class="select--head--exemple--responsable flex--row">
                                <label>
                                    Responsable
                                </label>
                                <img class="select--head--exemple--responsable--image" src="../web/svg/addmultiple.svg" alt="addmultiple">
                            </div>
                        </div>
                        <input type="hidden" name="allVoters" id="allVoters" value=<?php echo $pageTitle != "create" ? '"' . implode('_', array_merge($collaborators, $voters)) . '"' : '""' ?>>
                        <input type="hidden" name="allContributors"  id="allContributors" value=<?php echo $pageTitle != "create" ? '"' . implode('_', $collaborators) . '"' : '""' ?>>
                        <div class="horizontal--sep"></div>
                        <?php
                        foreach ($users as $user){
                            echo $user->displayVoters($pageTitle != 'create' ? $collaborators : [], $pageTitle != 'create' ? $voters : []);    
                        }?>
                        <input type="hidden" id="nb-voters-collaborators" value="<?php echo $pageTitle == "create" ? 0 : count($voters) . '-' . count($collaborators) ?>">
                        <div class="horizontal--sep"></div>
                        <img id="close-voters-adding" src="../web/svg/delete-section.svg" class="tag-management--close-button" alt="tag-management">
                    </div>
    </form>
    <input type="hidden" id="type-of-page" value="create">
    <script src="../web/js/main.js"></script>
    <script src="../web/js/switch-visibility.js"></script>
    <script src="../web/js/create-question-validity.js"></script>
    <script src="../web/js/duplicatesection.js"></script>
    <script src="../web/js/tag-management.js"></script>
    <script src="../web/js/addVoter.js"></script>
</main>