<?php

class AccountController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        require("models/account.php");
        $this->model = new AccountModel();
    }
    
    protected function index()
    {
        $this->view->output($this->model->index());
    }

    protected function loguser() 
    {
        $obj = Utility::Objectify($_POST);
        if (Session::get('_token') !== $obj->Token){
            $this->response->redirectExternal('http://gadgetoverflow.ga');
        }
        $result = User::Instance()->login($obj->Username, $obj->Password);
        if ($result) {
            $this->response->redirectExternal('http://gadgetoverflow.ga');
        } else {
            Tokenizer::put('login-error', 'Username or Password are wrong. Please try again');
            $this->response->redirect('login');
        }
    }

    protected function logout() {
        if (User::Instance()->isLogged()) {
            User::Instance()->logout();
            $ref = $_SERVER['HTTP_REFERER'];
            $refData = parse_url($ref);
            if ($refData['host'] === 'gadgetoverflow.ga') {
                $this->response->redirectExternal($ref);
                return;
            }
            $this->response->redirectExternal('http://gadgetoverflow.ga');
        }
    }

    protected function login()
    {
        Session::put('_token', bin2hex(openssl_random_pseudo_bytes(16)));
        $this->view->output($this->model->login());
    }

    protected function register() 
    {
        Session::put('_token', bin2hex(openssl_random_pseudo_bytes(16)));
        $this->view->output($this->model->register());
    }

    protected function adduser()
    {
        $obj = Utility::Objectify($_POST);
        if ($obj->Password !== $obj->RePassword) {
            Tokenizer::put('register-error', 'Password fields doesnt match. Please try again');
            return $this->response->redirectExternal('register');
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $obj->Nickname)) {
          Tokenizer::put('register-error', '"Nickname" Only letters and white space allowed. Please try again');
          return $this->response->redirectExternal('register'); 
        }
        if (!filter_var($obj->Email, FILTER_VALIDATE_EMAIL)) {
          Tokenizer::put('register-error', '"Email" Invalid Email address. Please try again');
          return $this->response->redirectExternal('register');  
        }
        $db = DbContext::getInstance();
        
        $exist = $db->query('SELECT * FROM User WHERE Email = ? OR Username = ?', array($obk->Email, $obj->Nickname))->results();
        if (count($exist) > 0) {
          Tokenizer::put('register-error', '"Invalid" a User with the same details already exists. Please try again');
          return $this->response->redirectExternal('register');
        }
        
        $db->query('INSERT INTO User (Username, Password, UserImage, DisplayName, Type, Email, TotalQuestions, TotalAnswers, Points, UserId) VALUES (?,?,?,?,?,?,?,?,?,?)',
                   array($obj->Nickname, $obj->Password, "https://www.gravatar.com/avatar/51d623f33f8b83095db84ff35e15dbe8?s=128&d=identicon&r=PG",
                   $obj->Nickname, 0, $obj->Email, 0, 0, 0, rand(95462, 998765412)));
        $result = User::Instance()->login($obj->Nickname, $obj->Password);
        if ($result) {
            $this->response->redirectExternal('http://gadgetoverflow.ga');
        } else {
          Tokenizer::put('register-error', '"Oooops!" Something went wrong and we couldnt log you in. Please try again');
          return $this->response->redirectExternal('http//gadgetoverflow.ga/account/register');
        }
    }
}

?>
