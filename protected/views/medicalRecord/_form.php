<a href="view.php" id="" title="view">view</a><?php
/* @var $this MedicalRecordController */
/* @var $model MedicalRecord */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-record-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>
    <div class="row">
        <div class="row">
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
                    function run_tree($that,$node,$sec){
                        if ($node->id != "1"){
                            
                            $padding = count($sec)*5;
                            echo "<div clas=\"row\" style=\"padding-left:".($padding-5)."%;\">section ".mksec($sec)."</div>\n";
                            $that->renderPartial('/answer/_form',array('model'=>$node->label,'from_mr'=>true));
                            echo "<div class=\"row\" style=\"padding-left:".$padding."%;\">".Question::model()->findByPk($node->id)->label."</div>\n";
                            echo "<div class=\"row\" style=\"padding-left:".($padding)."%;\">".$node->label->answer."</div>";
                        }
        
                        $sec_count = 1;
                        foreach($node->child as $c){
                            array_push($sec,$sec_count);
                            run_tree($that,$c,$sec);
                            $sec_count += 1;
                            array_pop($sec);
                        }
                    }
                    run_tree($this,$atree,$sections);
                    ?>
        </div>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->