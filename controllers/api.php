<?php

class ApiController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
    }

    public function fix()
    {
        $result = $this->database->query('SELECT Id FROM Questions LIMIT 200000, 100000')->results();
        foreach ($result as $item) {
            $r = $this->database->query('SELECT * FROM Answers WHERE QuestionId = ?', array($item->Id))->first();
            if ($r == NULL) {
                $this->database->query('DELETE FROM `Questions` WHERE Id = ?', array($item->Id));
                $this->database->query('DELETE FROM Body WHERE QuestionId = ?', array($item->Id));
                echo 'question has been deleted <br />';
            }
        }
    }

    public function charge()
    {
        $qs = $this->getQuestions();
        foreach ($qs->items as $item) {
            if ($item->answer_count > 0) {
                $result = $this->insertQuestion($item);
                echo 'question with id : ' . $result . ' has been added to the database <br />';
            }
        }
    }

    public function proxy() {
        $url = $this->POST->url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)');
        curl_setopt($curl, CURLOPT_REFERER,'http://www.google.com');  //just a fake referer
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 20);
        $html = curl_exec($curl);
        $this->response->textResponse($html);
    }

    protected function stats() {
        $this->response->jsonResponse(Repository::stats());
    }

    protected function tags() {
        $this->response->jsonResponse(Repository::advTags());
    }

    protected function tagDetails() {
        $this->response->jsonResponse($this->clearArray(Repository::tagDetails($_GET['id'])));
    }

    protected function mostViewed() {
        $this->response->jsonResponse($this->clearArray(Repository::mostViewed()));
    }

    protected function mostAnswered() {
        $this->response->jsonResponse($this->clearArray(Repository::mostAnswered()));
    }

    protected function users() {
        $this->response->jsonResponse($this->clearArray(Repository::users()));
    }

    protected function topUsers() {
        $this->response->jsonResponse($this->clearArray(Repository::topUsers()));
    }

    protected function user() {
        $this->response->jsonResponse($this->clearOne(Repository::user($_GET['id'])));
    }
    
    protected function home()
    {
        $skip = $_GET['id'] * 20;
        $this->response->jsonResponse($this->clearArray(Repository::home(20, $skip, TRUE)));
    }

    protected function question() 
    {
        $this->response->jsonResponse($this->clearOne(Repository::question($_GET['id'])));
    }

    protected function login() {
        $username = $_POST['uid'];
        $pass = $_POST['pwd'];
        $result = User::Instance()->login($username, $pass);
        if ($result) {
            $this->response->jsonResponse($this->clearOne(User::Instance()->Current()));
        } else {
            $this->response->jsonResponse(FALSE);
        }
    }

    private function clearArray($array) {
        foreach ($array as $item) {
            unset($item->Username, $item->Password, $item->Email);
        }
        return $array;
    }

    private function clearOne($item) {
        unset($item->Username, $item->Password, $item->Email);
        return $item;
    }

    private function getQuestions() {
        $url = "https://api.stackexchange.com/2.2/questions?pagesize=100&order=desc&sort=creation&site=superuser&filter=!)rfa0cFQTw)(v.WGPKHe&key=3BoLaYG6bQFDDNEGiZflyA((";
        $json = $this->getJson($url);
        $obj = json_decode($json);
        return $obj;
    }

    private function getJson($url) {
        $opts = array(
            'http'=>array(
                'method' => "GET",
                'header' => "Accept-Encoding: gzip;q=0, compress;q=0\r\n",
            )
        );

        $context = stream_context_create($opts);
        $json = file_get_contents($url, false, $context);
        return gzinflate(substr($json, 10, -8));
    }

    private function userExists($username) {
        $result = $this->database->query('SELECT UserId FROM User Where Username = ?', array($username))->first();
        if ($result == NULL) {
            return FALSE;
        }
        return $result->UserId;
    }

    private function addUser($user) {
        $id = rand(0, 9999999);
        $values = array($user->display_name, 'RandomPassword', $id, $user->profile_image, $user->display_name, 0, '', 0, 0, 0, date("Y-m-d H:m:s", time()));
        $this->database->query('INSERT INTO `User`(`Username`, `Password`, `UserId`, `UserImage`, `DisplayName`, `Type`, `Email`, `TotalQuestions`, `TotalAnswers`, `Points`, `Joined`) VALUES (?,?,?,?,?,?,?,?,?,?,?)', $values);
        $this->database->query('INSERT INTO `UserInfo`(`UserId`, `Website`, `Country`, `Description`) VALUES (?, ?, ?, ?)', array($id, 'N/A', 'WORLD', 'N/A'));
        return $id;
    }

    private function insertQuestion($item) {
        $exists = $this->database->query('SELECT * FROM Questions WHERE Title = ?', array($item->title))->first();
        if ($exists != NULL) {
            return 0;
        }
        $userId = 0;
        $r = $this->userExists($item->owner->display_name);
        if ($r == FALSE) {
            $userId = $this->addUser($item->owner);
        } else {
            $userId = $r;
        }
        $tagId = $this->insertTag($item->tags);
        $id = rand(0, 9999999);
        $values = array($id, $userId, $item->title, rand(0, 4321), $item->answer_count, rand(0, 10), rand(0, 5), $item->creation_date, $tagId);
        $this->database->query('INSERT INTO `Questions`(`Id`, `UserId`, `Title`, `ViewCount`, `AnswerCount`, `UpVotes`, `DownVotes`, `CreationDate`, `TagId`) VALUES (?,?,?,?,?,?,?,?,?)', $values);
        $this->insertBody($item->body, $id);
        foreach ($item->answers as $answer) {
            $this->insertAnswer($answer, $id);
        }
        return $id;
    }

    private function insertBody($body, $id) {
        $this->database->query('INSERT INTO `Body`(`QuestionId`, `Body`) VALUES (?,?)', array($id, $body));
    }

    private function insertAnswer($item, $id) {
        $userId = 5965725;
        $r = $this->userExists($item->owner->display_name);
        if ($r == FALSE) {
            $userId = $this->addUser($item->owner);
        } else {
            $userId = $r;
        }
        $values = array($id, $item->body, 3, 0, $item->creation_date, $userId);
        $err = $this->database->query('INSERT INTO `Answers`(`QuestionId`, `Body`, `UpVoteCount`, `IsAccepted`, `CreationDate`, `UserId`) VALUES (?,?,?,?,?,?)', $values)->error();
        print_r($this->database->errorInfo());
    }

    private function insertTag($tag) {
        $t = $tag[0];
        $result = $this->database->query('SELECT * FROM Tag WHERE Name = ?', array($t))->first();        
        $tagId = 1;
        if ($result == NULL) {
            $this->database->query('INSERT INTO Tag (Name) VALUES (?)', array($t));
            $r = $this->database->query('SELECT Id FROM Tag WHERE Name = ?', array($t))->first();
            $tagId = $r->Id;
        } else {
            $tagId = $result->Id;
        }
        return $tagId;
    }
}

?>
