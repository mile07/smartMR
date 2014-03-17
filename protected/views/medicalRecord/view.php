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
 <?php $atree= $this->loadATree($model->id); ?>
<div  id="answers">
    <?php 
    if ($model->answerCount > 0){?>
         <h3>Answers:</h3>
         <?php $this->renderPartial('_answers',array(
            'medical_record'=>$model,
            'answers'=>$model->answers,
            'atree'=>$atree
         )); ?>
     <?php } ?>
</div>