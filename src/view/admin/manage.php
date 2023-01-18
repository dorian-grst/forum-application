<div class="select container flex--column">
        <div class="select--head--title title flex--row">
            <div class="carre">
                <img class="select--head--title--image" src="../web/svg/add.svg">
            </div>
            <div>
                Ajout des auteurs
            </div>
        </div>

        <div class="select--head--research flex--row">
            <div class="select--head--research--searchbar">
                <form method="POST" action="frontController.php?action=addAutor&controller=user">
                <input class="select--head--research--input" type="text" placeholder="Pseudo" name="pseudo">
            </div>
            <div>
                <button id="open-tag-management" class="rectangle rectangle--green"  type="submit">
                    +
                </button>
                </form>
            </div>

        </div>
        <div class="select--head--exemple select--spacebetween flex--row">
            <label class="select--head--exemple--pseudo">
                Pseudo
            </label>
            <label>
                Supprimer
            </label>


        </div>
        <?php foreach ($autors as $autor){
            echo $autor->displayAutors();
        }?>


    </div>