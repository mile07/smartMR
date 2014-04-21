<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle)?></title>
    <style>
    ol { counter-reset: item }
    ol li:before {font-weight: bold;
        font-size: 1.17em;
        color:black;
    }
    li { display: block }
    li:before { content: counters(item, ".") " "; counter-increment: item }
    h1 { font-size: 2em; }
    h2 { font-size: 1.5em; }
    h3 { font-size: 1.17em; }
    h5 { font-size: .83em; }
    h6 { font-size: .75em; }
    mlb{ font-size: 1.17em;}
    </style>
</head>

<body>
<div class="container" id="page">

<?php
         function in_padding($s,$padding,$offset=0){
             return str_repeat(" ",$padding-$offset)."<mlb>".$s."</h3>"."</mlb><br>\n";
             return "<div clas=\"row\" style=\"padding-left:".($padding-$offset)."%;\">".$s."</div>\n";
         }
        function run_tree(&$that,&$count,$node,$sec){
            $pcount = $count;
            if ($node->id != "1"){
            
                $padding = count($sec)*5;
                //echo "<div clas=\"row\" style=\"padding-left:".($padding-5)."%;\">section ".$this->mksec($sec)."</div>\n";
                //$this->renderPartial('/answer/_form',array('model'=>$node->label,'from_mr'=>true));
                $ans = "[$count]answer";
                $questid = "[$count]question_id";
                echo in_padding(Question::model()->findByPk($node->id)->label,$padding);
                //$ans = 'answer';
                if (!$node->label){
                    echo in_padding("No answer",$padding);
                }
                else {
                    echo in_padding($node->label->answer,$padding);
                    $node->label->question_id = 5;
                }
            }
            echo "<ol>";
            $sec_count = 1;
            foreach($node->child as $c){
                array_push($sec,$sec_count);
                $count += 1;
                echo "<li>\n";
                run_tree($that,$count,$c,$sec);
                echo "</li>\n";
                $sec_count += 1;
                array_pop($sec);
            }
            if ($pcount != 0)
            echo "</ol>\n";
        }
        ?>
        <div style="margin:50px">
        <?php
        $count = 0;
        $sec = array();
        run_tree($this,$count,$atree,$sec);
        echo"</div>";
        ?>
</body>