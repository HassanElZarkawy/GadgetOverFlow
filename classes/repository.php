<?php

require_once("DbContext.php");

class Repository
{
    private static $database;

    private static function init() {
        if (self::$database == NULL) {
            self::$database = DbContext::getInstance();
        }
    }

    public static function stats() {
        $cached = FileCache::Instance()->get('stats');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query('SELECT (SELECT COUNT(*) FROM Questions) as totalQuestions, (SELECT COUNT(*) FROM Answers) as totalAnswers, (SELECT COUNT(*) FROM User) as totalUsers')->first();
        FileCache::Instance()->save('stats', $result, 300);
        return $result;
    }

    public static function home($count = null, $skip = null, $forceNew = FALSE) {
        $param = 20;
        if ($count !== null) {
            $param = $count;
        }
        if (!$forceNew) {
            $cached = NULL;//FileCache::Instance()->get("home.$param");
            if ($cached) {
                return array_slice($cached, 0, $param);
            }
        }
        self::init();
        $join = "LIMIT $param";        
        if ($skip !== null) {
            $join = "LIMIT $skip, $param";
        }
        
        $result = self::$database->query("SELECT *, Questions.Id AS qId FROM Questions INNER JOIN User ON Questions.UserId = User.UserId INNER JOIN Body On Questions.Id = Body.QuestionId INNER JOIN Tag On Tag.Id = Questions.TagId ORDER BY CreationDate DESC $join")->results();
        if (!$forceNew) {
            FileCache::Instance()->save("home.$param", $result, 300);
        }
        return $result;
    }

    public static function mostViewed() {
        $cached = FileCache::Instance()->get('viewed');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query('SELECT * FROM `Questions` INNER JOIN User ON Questions.UserId = User.UserId INNER JOIN Body On Questions.Id = Body.QuestionId ORDER BY ViewCount DESC LIMIT 50')->results();
        FileCache::Instance()->save('viewed', $result, 300);
        return $result;
    }

    public static function mostAnswered() {
        $cached = FileCache::Instance()->get('answered');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query('SELECT * FROM `Questions` INNER JOIN User ON Questions.UserId = User.UserId INNER JOIN Body On Questions.Id = Body.QuestionId ORDER BY AnswerCount DESC LIMIT 50')->results();
        FileCache::Instance()->save('answered', $result, 300);
        return $result;
    }

    public static function question($id) {
        self::init();
        self::updateViews($id);
        $q = self::$database->query('SELECT * FROM Questions INNER JOIN User ON Questions.UserId = User.UserId INNER JOIN Body On Questions.Id = Body.QuestionId INNER JOIN Tag On Questions.TagId = Tag.Id WHERE Questions.Id = ? LIMIT 1', array($id))->first();
        $q->Answers = self::$database->query("SELECT * FROM Answers JOIN User ON Answers.UserId = User.UserId WHERE Answers.QuestionId = ?", array($id))->results();
        return $q;
    }

    public static function hot() {
        $cached = FileCache::Instance()->get('hot');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query('SELECT * FROM `Questions` ORDER BY ViewCount DESC LIMIT 5')->results();
        FileCache::Instance()->save('hot', $result, 300);
        return $result;
    }

    public static function unAnswered() {
        $cached = FileCache::Instance()->get('unAnswered');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query('SELECT * FROM `Questions` WHERE AnswerCount = 0 LIMIT 5')->results();
        FileCache::Instance()->save('unAnswered', $result, 300);
        return $result;
    }

    public static function user($id) {
        self::init();
        $user = self::$database->query('SELECT * FROM User INNER JOIN UserInfo ON UserInfo.UserId = User.UserId WHERE User.UserId = ?', array($id))->first();
        $user->questions = self::$database->query('SELECT * FROM Questions WHERE UserId = ? LIMIT 10' , array($id))->results();
        return $user;
    }

    public static function topUsers() {
        $cached = FileCache::Instance()->get('topUsers');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query('SELECT * FROM `User` ORDER BY Points DESC LIMIT 3')->results();
        FileCache::Instance()->save('topUsers', $result, 300);
        return $result;
    }

    public static function userStats($id) {
        self::init();
        return self::$database->query('SELECT (SELECT COUNT(*) FROM Questions WHERE UserId = ?) as totalQuestions, (SELECT COUNT(*) FROM Answers WHERE UserId = ?) as totalAnswers', array($id, $id))->first();
    }

    public static function users($count = null) {
        $param = 50;
        if ($count !== null) {
            $param = $count;
        }
        $cached = FileCache::Instance()->get('users');
        if ($cached) {
            return array_slice($cached, 0, $param);
        }
        self::init();
        $result = self::$database->query("SELECT * FROM `User` ORDER BY Points Desc LIMIT $param")->results();
        FileCache::Instance()->save('users', $result, 300);
        return $result;
    }

    public static function tags($take = 6, $skip = 0) {
        $cached = FileCache::Instance()->get('tags');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query("SELECT DISTINCT * FROM `Tag` WHERE Tag.Name NOT LIKE '%.%' LIMIT $skip, $take")->results();
        FileCache::Instance()->save('tags', $result, 300);
        return $result;
    }

    public static function advTags() {
        $cached = FileCache::Instance()->get('advTags');
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query("SELECT Tag.Id, Tag.Name, COUNT(Questions.TagId) AS Has, Questions.Title, Questions.Id AS QuestionId FROM Tag INNER JOIN Questions ON (Tag.Id = Questions.TagId) WHERE Tag.Name NOT LIKE '%.%' GROUP BY Tag.Name ORDER BY `Has` DESC LIMIT 80")->results();
        FileCache::Instance()->save('advTags', $result, 300);
        return $result;
    }

    public static function tagDetails($id) {
        $cached = FileCache::Instance()->get("tagDetails.$id");
        if ($cached) {
            return $cached;
        }
        self::init();
        $result = self::$database->query("SELECT *, Questions.Id AS qId FROM Questions INNER JOIN User ON Questions.UserId = User.UserId INNER JOIN Body On Questions.Id = Body.QuestionId INNER JOIN Tag On Tag.Id = Questions.TagId WHERE Questions.TagId = ? LIMIT 30", array($id))->results();
        FileCache::Instance()->save("tagDetails.$id", $result, 300);
        return $result;
    }

    public static function addAnswer($questionId, $userId, $body) 
    {
        self::init();
        $arr = array(rand(1000, 9999999), $questionId, $body, 0, 0, time(), $userId);
        self::$database->query('INSERT INTO `Answers`(`AnswerId`, `QuestionId`, `Body`, `UpVoteCount`, `IsAccepted`, `CreationDate`, `UserId`) VALUES (?,?,?,?,?,?,?)', $arr);
        self::$database->query('UPDATE `Questions` SET AnswerCount = AnswerCount + 1 WHERE Id = ?', array($questionId));
        self::$database->query('UPDATE User SET TotalAnswers = TotalAnswers + 1, Points = Points + 5 WHERE UserId = ?', array($userId));
    }

    public static function updateViews($id)
    {
        self::init();
        self::$database->query('UPDATE Questions SET ViewCount = ViewCount + 1 WHERE Id = ?', array($id));
    }

    public  static function userQuestions($id)
    {
        self::init();
        return self::$database->query('SELECT * FROM Questions Join User On Questions.UserId = User.UserId JOIN Body ON Body.QuestionId = Questions.Id WHERE Questions.UserId = ? LIMIT 50', array($id))->results();
    }
}