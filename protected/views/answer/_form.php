<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'answer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<?php
        if (isset($from_mr) and $from_mr){
        }
?>
            <?php if (!(isset($from_mr) and $from_mr)){ ?>
	php<p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php } ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
        <?php if (!(isset($from_mr) and $from_mr)){ ?>
		<?php echo $form->labelEx($model,'medical_record_id'); ?>
		<?php echo $form->textField($model,'medical_record_id'); ?>
		<?php echo $form->error($model,'medical_record_id'); ?>
        <?php } 
        else {
//            echo $form->labelEx($model,'medical_record_id'); 
            echo $form->hiddenField($model,'medical_record_id'); 
//            echo $form->error($model,'medical_record_id'); 
        }
        ?>
	</div>

	<div class="row">
        <?php if (!(isset($from_mr) and $from_mr)){ ?>
		<?php echo $form->labelEx($model,'question_id'); ?>
		<?php echo $form->textField($model,'question_id'); ?>
		<?php echo $form->error($model,'question_id'); ?>
        <?php } ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer'); ?>
		<?php echo $form->textArea($model,'answer',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'answer'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->