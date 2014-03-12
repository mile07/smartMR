<?php
/* @var $this MedicalRecordController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Medical Records',
);

$this->menu=array(
	array('label'=>'Create MedicalRecord', 'url'=>array('create')),
	array('label'=>'Manage MedicalRecord', 'url'=>array('admin')),
);
?>

<h1>Medical Records</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
