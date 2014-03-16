<?php
/* @var $this MedicalRecordController */
/* @var $model MedicalRecord */
/* @var $qtree Node */

$this->breadcrumbs=array(
	'Medical Records'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MedicalRecord', 'url'=>array('index')),
	array('label'=>'Create MedicalRecord', 'url'=>array('create')),
	array('label'=>'Update MedicalRecord', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MedicalRecord', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MedicalRecord', 'url'=>array('admin')),
);
?>

<h1>View MedicalRecord #<?php echo $model->id; ?></h1>

<?php
/* $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
	),
));
*/
 ?>


<div  id="answers">
    <?php 
    if ($model->answerCount > 0){?>
         <h3>Answers:</h3>
         <?php $this->renderPartial('_answers',array(
            'medical_record'=>$model,
            'answers'=>$model->answers,
         )); ?>
     <?php } ?>
</div>
<!--comment
<div style="padding-top:10px">
    <?php
    $sections = Array();
    
    function mksec($sec){
        if (sizeof($sec)===0){
            return "_";
        }
        $ret = $sec[0];
        for ($i = 1; $i < sizeof($sec); $i += 1){
            $ret .= ".".$sec[$i];
        }
        
        return $ret;
    }
    
    function run_tree($node,$sec){
        if ($node->label != "/"){
            echo "section ".mksec($sec)."<br>";
            echo $node->label."<br>";
        }
        
        $sec_count = 1;
        foreach($node->child as $c){
            array_push($sec,$sec_count);
            run_tree($c,$sec);
            $sec_count += 1;
            array_pop($sec);
        }
    }
    run_tree($qtree,$sections);
    ?>
</div>
    
    -->