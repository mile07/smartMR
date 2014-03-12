<?php
/* @var $this AnswerController */
/* @var $model Answer */

$this->breadcrumbs=array(
	'Answers'=>array('index'),
	$model->question_id,
);

$this->menu=array(
	array('label'=>'List Answer', 'url'=>array('index')),
	array('label'=>'Create Answer', 'url'=>array('create')),
	array('label'=>'Update Answer', 'url'=>array('update', 'id'=>$model->question_id)),
	array('label'=>'Delete Answer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->question_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Answer', 'url'=>array('admin')),
);
?>

<h1>View Answer #<?php echo $model->question_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'text',
		'question_id',
		'MR_id',
	),
)); ?>
