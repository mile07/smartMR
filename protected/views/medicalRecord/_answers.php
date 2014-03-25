<?php
     function in_padding($s,$padding,$offset=0){
         return "<div clas=\"row\" style=\"padding-left:".($padding-$offset)."%;\">".$s."</div>\n";
     }
    function run_tree(&$that,&$count,$node,$sec){
        
        if ($node->id != "1"){
            
            $padding = count($sec)*5;
            //echo "<div clas=\"row\" style=\"padding-left:".($padding-5)."%;\">section ".$this->mksec($sec)."</div>\n";
            if (sizeof($node->child) > 0){
                echo $that->in_padding("section ".$that->mksec($sec),$padding,5);
            }
            //$this->renderPartial('/answer/_form',array('model'=>$node->label,'from_mr'=>true));
            $ans = "[$count]answer";
            $questid = "[$count]question_id";
            echo $that->in_padding(Question::model()->findByPk($node->id)->label,$padding);
            //$ans = 'answer';
            if (!$node->label){
                echo $that->in_padding("No answer",$padding);
            }
            else {
                echo $that->in_padding($node->label->answer,$padding);
                $node->label->question_id = 5;
            }
//            echo "<div class=\"row\" style=\"padding-left:".$padding."%;\">".Question::model()->findByPk($node->id)->label."</div>\n";
            //echo "<div class=\"row\" style=\"padding-left:".($padding)."%;\">".$node->label->answer."</div>";
        }

        $sec_count = 1;
        foreach($node->child as $c){
            array_push($sec,$sec_count);
            $count += 1;
            run_tree($that,$count,$c,$sec);
            $sec_count += 1;
            array_pop($sec);
        }
    }
    
    $count = 0;
    $sec = array();
    
    run_tree($this,$count,$atree,$sec);
?>