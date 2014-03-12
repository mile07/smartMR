<?php
/* @var $this MedicalRecordController */
/* @var $model MedicalRecord */

$this->breadcrumbs=array(
	'Medical Records'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MedicalRecord', 'url'=>array('index')),
	array('label'=>'Manage MedicalRecord', 'url'=>array('admin')),
);
?>

<h1>Create MedicalRecord</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>