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
    public $answers;
    public $model;

	/**
	 * @return array action filters
	 */
    
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
    
    /**
     * Creates answers for models
     */
    
    public function createAnswers(&$atree,&$node){
        $atree->label = new Answer();
    //    echo $node->id;
        $atree->label->question_id = $node->id;
        $atree->child = Array();
        $atree->id = $node->id;
        $atree->parent_id="1";
        foreach ($node->child as $ch){
            $n_node = new Node();
            $this->createAnswers($n_node,$ch);
            array_push($atree->child, $n_node);
        }
    }
	
    public function createATree() {
        $atree = new Node();
        $this->createAnswers($atree,$this->qtree);
        return $atree;
    }

    
    
    
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
    
    // id parent_id label
    
    
	public function actionView($id)
	{
        $this->model = $this->loadModel($id);
        $this->answers = $this->model->answers;
        $this->qtree = $this->loadQTree();
		$this->render('view',array(
			'model'=>$this->model,
            'qtree'=>$this->qtree,
		));
	}

    function run_tree(&$count,$node,$sec,&$form){
        if ($node->id != "1"){
            
            $padding = count($sec)*5;
            echo "<div clas=\"row\" style=\"padding-left:".($padding-5)."%;\">section ".$this->mksec($sec)."</div>\n";
            //$this->renderPartial('/answer/_form',array('model'=>$node->label,'from_mr'=>true));
            $ans = "[$count]answer";
            $questid = "[$count]question_id";
            //$ans = 'answer';
            echo $form->labelEx($node->label,$ans);
            echo $form->textField($node->label,$ans);
            echo $form->error($node->label,$ans);
            echo $form->hiddenField($node->label,$questid,array('vaue'=>$node->label->question_id));
            $node->label->question_id = 5;
            echo "<div class=\"row\" style=\"padding-left:".$padding."%;\">".Question::model()->findByPk($node->id)->label."</div>\n";
            //echo "<div class=\"row\" style=\"padding-left:".($padding)."%;\">".$node->label->answer."</div>";
        }

        $sec_count = 1;
        foreach($node->child as $c){
            array_push($sec,$sec_count);
            $count += 1;
            $this->run_tree($count,$c,$sec,$form);
            $sec_count += 1;
            array_pop($sec);
        }
    }
   

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MedicalRecord;
        $this->qtree = $this->loadQTree();
        $atree = $this->createATree();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $all_answers_valid = true;
        
        $answers_to_save = array();
		if(isset($_POST['MedicalRecord']))
		{
			$model->attributes=$_POST['MedicalRecord'];
            if (isset($_POST['Answer'])){
                foreach($_POST['Answer'] as $index => $submitted_answer){
                    $answer = new Answer;
                    //$answer->attributes = $submitted_answer;
         //           echo "q_id = ";print_r($submitted_answer);//print_r($answer);
                    $answer->answer = $submitted_answer['answer'];
                    $answer->question_id = $submitted_answer['question_id'];
                    if (!$answer->validate()){
                        $all_answers_valid = false;
                    }
                    else {
                        array_push($answers_to_save,$answer);
                    }
                }
                if ($all_answers_valid && $model->validate()){
                    $trans = Yii::app()->db->beginTransaction();
                    try{
                        $model->save();
                        foreach($answers_to_save as $ans){
                            $ans->medical_record_id = $model->  id;
                            $ans->save();
                        }
                        $trans->commit();
                    } catch (Exception $e){
                        $trans->rollback();
                        Yii::log("Error occurred while saving. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
                                            $success_saving_all = false;
                    }
    				$this->redirect(array('view','id'=>$model->id));
                }
            }
			//if($model->save()){
            //}
		}
		$this->render('create',array(
			'model'=>$model,
            'qtree'=>$this->qtree,
            'atree'=>$atree,
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
        $this->qtree = $this->loadQTree();
        $atree = $this->createATree();
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
            'qtree'=>$this->qtree,
            'atree'=>$atree,
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