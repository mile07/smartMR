<?php

foreach($answers as $answer){
    $q =  Question::model()->findByPk($answer->question_id);
    ?>    
    <div class="question">
        <?php echo $q->label;?>    
        <div class="question">
    <?php
    ?>
    <div class="answer">
        <?php echo $answer->answer; ?>
    </div>
    <?php 
}

?>