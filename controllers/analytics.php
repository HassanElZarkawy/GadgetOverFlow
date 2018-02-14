<?php

class AnalyticsController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
    }
    
    protected function crash()
    {
        $obj = $this->POST;
        $db = DbContext::connect('Analytics');
        $app = $db->query('SELECT * FROM App WHERE Name = ?', array($obj->App))->first();
        if ($app === null){
            $this->response->jsonResponse(array('success' => 'false', 'error' => 'App not found'));
        }
        $values = array($app->Id, time(), $obj->Exception, $obj->Stacktrace, $obj->Message, $obj->Type, $obj->Device, $obj->Version);
        $db->query('INSERT INTO `Crash`(`AppId`, `Time`, `Exception`, `Stacktrace`, `Message`, `Type`, `Device`, `Version`) VALUES (?,?,?,?,?,?,?,?)', $values);
        $this->response->jsonResponse(array('success' => 'true', 'error' => 'none'));
    }

    protected function view()
    {
        $obj = $this->POST;
        $db = DbContext::connect('Analytics');
        $app = $db->query('SELECT * FROM App WHERE Name = ?', array($obj->App))->first();
        if ($app === null){
            $this->response->jsonResponse(array('success' => 'false', 'error' => 'App not found'));
        }
        $values = array($app->Id, $obj->Name, 1);
        $record = $db->query('SELECT * FROM Views WHERE PageName = ? AND AppId = ?', array($obj->Name, $app->Id))->first();
        if ($record !== null) {
            $db->query('UPDATE Views SET ViewCount = ViewCount + 1 WHERE AppId = ? AND PageName = ?', array($app->Id, $obj->Name));
        } else {
            $db->query('INSERT INTO `Views`(`AppId`, `PageName`, `ViewCount`) VALUES (?,?,?)', $values);
        }
        $this->response->jsonResponse(array('success' => 'true', 'error' => 'none'));
    }

    protected function event()
    {
        $obj = $this->POST;
        $db = DbContext::connect('Analytics');
        $app = $db->query('SELECT * FROM App WHERE Name = ?', array($obj->App))->first();
        if ($app === null){
            $this->response->jsonResponse(array('success' => 'false', 'error' => 'App not found'));
        }
        $values = array($app->Id, $obj->Name, $obj->Message, $obj->Type, $obj->Device, $obj->Version, 1);
        $record = $db->query('SELECT * FROM Events WHERE AppId = ? AND EventName = ?', array($app->Id, $obj->Name))->first();
        if ($record !== null) {
            $db->query('UPDATE Events SET Count = Count + 1 WHERE AppId = ? AND EventName = ?', array($app->Id, $obj->Name));
        } else {
            $db->query('INSERT INTO `Events`(`AppId`, `EventName`, `Message`, `DeviceType`, `DeviceName`, `Version`, `Count`) VALUES (?,?,?,?,?,?,?)');
        }
        $this->response->jsonResponse(array('success' => 'true', 'error' => 'none'));
    }
}

?>