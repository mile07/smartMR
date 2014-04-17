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
        <div class="row">
    <?php
        $sections = Array();
        
        $count = 0;
        $this->run_tree($count,$atree,array(),$form);
    ?>
        </div>
    </div>
        <?php
        if (Yii::app()->user->hasFlash('helpers')){
            ?>
            <div class="flash-error">
                <?php Yii::ap()->user->getFlash('helpers'); ?>
            </div><?php
        }
        
        ?>
        <?php echo CHtml::label("Helpers",'helpers'); ?>
   		<?php echo CHtml::textField('helpers',$this->getHelpersAsString($model)); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->