<?php
/* @var $this MedicalRecordController */
/* @var $model MedicalRecord */

$this->breadcrumbs=array(
	'Medical Records'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MedicalRecord', 'url'=>array('index')),
	array('label'=>'Create MedicalRecord', 'url'=>array('create')),
	array('label'=>'View MedicalRecord', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MedicalRecord', 'url'=>array('admin')),
);
?>

<h1>Update MedicalRecord <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>