<?php

namespace app\controller;

use app\core\Controller;
use app\model\HelloWorld;
use lib\Response;

/**
 * Description of HelloWorld
 *
 * @author Mr.Mostafa Hosseinzade
 */
class HelloWorldController extends Controller{

    public function index() {
        $db = $this->DB();
        $r = $db->getTable("test")->removeBy(array("name"=>"m","family"=>"m"));
        var_dump($r);
    }

    public function Show() {
        $requesst2 = $this->Request();
        var_dump($requesst2->json()->getAll());
    }

}
