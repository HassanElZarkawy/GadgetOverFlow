<?php

class QuestionController extends BaseController
{
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);

        require_once("models/question.php");
        $this->model = new QuestionModel();
    }
    
    protected function index()
    {
        $this->view->output($this->model->index());
    }

    protected function ask()
    {
        if (!User::Instance()->isLogged()) {
          return $this->response->redirectExternal('http://gadgetoverflow.ga/account/login');
        }
        $this->view->output($this->model->ask());
    }

    protected function postquestion() 
    {
        if (!User::Instance()->isLogged()) {
          return $this->response->redirectExternal('http://gadgetoverflow.ga/account/login');
        }
        $obj = Utility::Objectify($_POST);
        $tagName = explode(',', $obj->question_tags)[0];
        if (!($obj->questionTitle)) {
          Tokenizer::put('ask-error', '"Question Title" Question Title cannot be empty');
          return $this->response->redirectExternal('ask');              
        }

        if (strlen($obj->questionTitle) < 20){
          Tokenizer::put('ask-error', '"Question Title" Question Title cannot be less than 20 character');
          return $this->response->redirectExternal('ask');              
        }

        if (!($obj->body)){
          Tokenizer::put('ask-error', '"Question Description" Question Description cannot be empty');
          return $this->response->redirectExternal('ask');              
        }

        if (strlen($obj->body) < 10) {
          Tokenizer::put('ask-error', "$obj->body");
          return $this->response->redirectExternal('ask');              
        }

        $tag = $this->database->query('SELECT * FROM Tag WHERE Name = ?', array($obj->question_tags))->first();
        $tagId = 0;
        if ($tag === null) {
            $this->database->query("INSERT INTO `Tag`(`Name`) VALUES (?)", array($tagName));
            $tagId = $this->database->lastId();
        } else {
            $tagId = $tag->Id;
        }
        $user = User::Instance()->Current();
        $arr = array(rand(1000, 9999999), $user->UserId, $obj->questionTitle, 0, 0, 0, 0, time(), $tagId);
        $this->database->query('INSERT INTO `Questions`(`Id`, `UserId`, `Title`, `ViewCount`, `AnswerCount`, `UpVotes`, `DownVotes`, `CreationDate`, `TagId`) VALUES (?,?,?,?,?,?,?,?,?)', $arr);
        $questionId = $this->database->query('SELECT * FROM Questions WHERE Title = ? AND UserId = ? AND TagId = ?', array($obj->questionTitle, $user->UserId, $tagId))->first()->Id;
        $this->database->query('INSERT INTO `Body`(`QuestionId`, `Body`) VALUES (?,?)', array($questionId, $obj->body));
        Utility::pingGoogle();
        return $this->response->redirectExternal('http://gadgetoverflow.ga/question/' . $questionId);
    }

    protected function postanswer()
    {
        if (!$this->GET->id){
            return $this->response->redirectExternal('http://gadgetoverflow.ga');
        }

        if (!User::Instance()->isLogged()) {
          return $this->response->redirectExternal('http://gadgetoverflow.ga/account/login');
        }

        $obj = Utility::Objectify($_POST);

        if (!($obj->body)){
          Tokenizer::put('answer-error', '"Question Description" Question Description cannot be empty');
          return $this->response->redirectExternal('http://gadgetoverflow.ga/question/' . $this->GET->id);            
        }

        if (strlen($obj->body) < 10) {
          Tokenizer::put('answer-error', "$obj->body");
          return $this->response->redirectExternal('http://gadgetoverflow.ga/question/' . $this->GET->id);              
        }
        $user = User::Instance()->Current();
        Repository::addAnswer($this->GET->id, $user->UserId, $obj->body);
        return $this->response->redirectExternal('http://gadgetoverflow.ga/question/' . $this->GET->id);
    }

    protected function prepare()
    {
        $this->view->output($this->model->prepare());
    }
}

?>
