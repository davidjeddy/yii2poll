<?php

namespace davidjeddy\yii2poll;

use yii;
use yii\base\Widget;
use yii\helpers\Html;

class Poll extends Widget {
    
    private $answerOptionsData;
    private $params = array(
        'backgroundLinesColor' => '#D3D3D3',
        'linesColor'           => '#4F9BC7',
        'linesHeight'          => 15,
        'maxLineWidth'         => 300,
    );
    private $pollData;
    private $pollName     ='';
    private $usersIPs     = array();
    public $answerOptions =array();
    public $answers       = array();
    public $isExist;
    public $isVote;
    public $sumOfVoices   = 0;
    
    public function setPollName($name) {

        $this->pollName = $name;
    }
    
    public function getDbData() {
        
            $db = Yii::$app->db;
            
            $command = $db->createCommand('SELECT * FROM poll_question WHERE poll_name=:pollName')->
            bindParam(':pollName',$this->pollName);
            
            $this->pollData = $command->queryOne();
            $this->answerOptionsData = unserialize($this->pollData['answer_options']);
    }
    
    private function setDbData() {
        return Yii::$app->db->createCommand()->insert('poll_question', [
            'answer_options' => $this->answerOptionsData,
            'poll_name'      => $this->pollName,
        ])->execute();
    }
    
    public function setParams($params) {

        $this->params = array_merge($this->params, $params);
    }
    
    public function getParams($param) {

        return $this->params[$param];
    }

    public function init() {
        
        parent::init();
        
        $pollDB = new PollDb;
        $this->isExist = $pollDB->isTableExists();

        if(count($this->isExist)==0){
            $pollDB->createTables();
        }
        if($this->answerOptions != null){
            $this->answerOptionsData = serialize($this->answerOptions);
        }
        if(!$pollDB->isPollExist($this->pollName)){
            $this->setDbData();
            $pollDB->setVoicesData($this->pollName, $this->answerOptions);
        }
        if(Yii::$app->request->isAjax){
            if(isset($_POST['VoicesOfPoll'])){
                if($_POST['poll_name']==$this->pollName){
                   $pollDB->updateAnswers($this->pollName, $_POST['VoicesOfPoll']['voice'], 
                    $this->answerOptions);
                    $pollDB->updateUsers($this->pollName);
                }    
            }
            
        }
        $this->getDbData();
        $this->answers = $pollDB->getVoicesData($this->pollName);
        
        for($i=0; $i<count($this->answers); $i++){
             $this->sumOfVoices = $this->sumOfVoices + $this->answers[$i]['value'];
        }
        $this->isVote = $pollDB->isVote($this->pollName);
    }
    
    public function run() {
        $model = new VoicesOfPoll;
        return  $this->render('index', [
            'pollData'=> $this->pollData,
            'answersData' => $this->answers,
            'params' => $this->params,
            'model' => $model,
            'answers' => $this->answerOptions,
            'sumOfVoices' => $this->sumOfVoices,
            'isVote' => $this->isVote,
        ]);
    }
}