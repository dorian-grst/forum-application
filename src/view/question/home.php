<?php
    $qs = isset($_GET['search']) ? array_filter($questions, function($v, $k) {
        return str_contains(strtolower($v->getAuthor()), strtolower($_GET['search'])) || str_contains(strtolower($v->getTitle()), strtolower($_GET['search']));
    }, ARRAY_FILTER_USE_BOTH) : $questions;
?>

<main class="flex--column home">
    <div class="counter flex--row home">
        <div>
            Nombre de questions :
        </div>
        <div id="number">
            <?php echo count($qs) ?>
        </div>
    </div>
    
    <?php

    foreach($qs as $question) {
        echo $question->displayPreview();
    }
    ?>
</main>