<?php

class Node {
    public $label;
    public $id;
    public $child;
    
    function __construct(){
        $child = Array();
    }
    
    function insert($node){
        if ($node["parent_id"] == $this->id){
            $nnode = new Node();
            $nnode->id = $node["id"];
            $nnode->label= $node["label"];
            $nnode->child = Array();
            array_push($this->child,$nnode);
            return true;
        }
        else {
            foreach ($this->child as $ch){
                if ($ch->insert($node)){
                    return true;
                }
            }
            return false;
        }
    }
}

class MedicalRecordController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $qtree;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				//'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
    
    // id parent_id label
    public function loadQTree() {
        $qs = Question::model()->findAll();
        $qtree= new Node();
        $qtree->label = "/";
        $qtree->id = "1";
        $qtree->parent_id="1";
        $qtree->child = Array();
        foreach ($qs as $q){
            $n_node = $q->attributes;
            if ($q["parent_id"]==$q["id"]){
                $qtree->id = $q["parent_id"];
                $qtree->label = $q["label"];
            }
            else {
                $qtree->insert($n_node);
            }
        }
        //var_dump($qtree);
        return $qtree;
        
    }
    
	public function actionView($id)
	{
        $this->qtree = $this->loadQTree();
		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'qtree'=>$this->qtree,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MedicalRecord;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MedicalRecord']))
		{
			$model->attributes=$_POST['MedicalRecord'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MedicalRecord']))
		{
			$model->attributes=$_POST['MedicalRecord'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MedicalRecord');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MedicalRecord('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MedicalRecord']))
			$model->attributes=$_GET['MedicalRecord'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MedicalRecord the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MedicalRecord::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MedicalRecord $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='medical-record-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}