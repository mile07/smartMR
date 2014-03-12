<?php
/* @var $this AnswerController */
/* @var $model Answer */

$this->breadcrumbs=array(
	'Answers'=>array('index'),
	$model->question_id=>array('view','id'=>$model->question_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Answer', 'url'=>array('index')),
	array('label'=>'Create Answer', 'url'=>array('create')),
	array('label'=>'View Answer', 'url'=>array('view', 'id'=>$model->question_id)),
	array('label'=>'Manage Answer', 'url'=>array('admin')),
);
?>

<h1>Update Answer <?php echo $model->question_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>