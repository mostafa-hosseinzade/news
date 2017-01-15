<?php

namespace app\controller;

use app\core\Controller;
use lib\JsonResponse;
use lib\Jalali;

/**
 * Description of DefaultController
 *
 * @author Mr.Mostafa
 */
class DefaultController extends Controller {

    public function index() {
        //read non subctg from view parent
        $data['parents'] = $this->DB()->getTable("parents")->findAll();
        //read subctg from view child
        foreach ($data['parents'] as $key => $value) {
            $data['parents'][$key]['child'] = $this->DB()->query("select * from child where subctg = '" . $value['id'] . "'");
        }
        return $this->View("index/index.php", $data);
    }

    public function data($type = 'slider') {
        if ($type == 'slider') {
            //read slider from view
            $data = $this->DB()->getTable("slider")->findAll();
        } else if ($type == 'mostlike') {
            //read most like from view
            $data = $this->DB()->getTable("mostlike")->findAll();
        } else {
            //read most visit from view
            $data = $this->DB()->getTable("mostvisit")->findAll();
        }
        return new JsonResponse($data);
    }

    public function portfolio($offset, $limit, $attr, $asc) {
        $limit = filter_var($limit, FILTER_VALIDATE_INT) == false ? 3 : $limit;
        $offset = filter_var($offset, FILTER_VALIDATE_INT) == false ? 0 : $offset;
        $attr = filter_var($attr, FILTER_SANITIZE_STRING) == false ? "id" : $attr;
        $asc = $asc == "asc" ? "asc" : "desc";

        $portfolio = $this->DB()->query(sprintf("select c.id,c.title,c.content,c.percent,c.url "
                        . "from Portfolio c order by c.%s %s limit %s offset %s", $attr, $asc, $limit, $offset));

        if (empty($portfolio)) {
            $data['msg'] = "محتوا;اطلاعاتی یافت نشد;warning;true";
            return new JsonResponse($data);
        }
        $Ids = [];
        foreach ($portfolio as $value) {
            $Ids[] = $value['id'];
        }
        $data['portfolioImg'] = $this->DB()->getTable("PortfolioImg")->findBy(array("portfolio_id" => $Ids));
        $data['portfolio'] = $portfolio;
        return new JsonResponse($data);
    }

    //@Route("/Default/isi/{id}/{filter}/{offset}/{limit}/{attr}/{asc}")
    public function isi($id, $filter, $offset, $limit, $attr, $asc) {
        $limit = filter_var($limit, FILTER_VALIDATE_INT) == false ? 3 : $limit;
        $offset = filter_var($offset, FILTER_VALIDATE_INT) == false ? 0 : $offset;
        $attr = filter_var($attr, FILTER_SANITIZE_STRING) == false ? "id" : $attr;
        $asc = $asc == "asc" ? "asc" : "desc";

        if ($filter == -1) {
            $isi = $this->DB()->query(sprintf("select c.id,c.title,c.visit,c.content,c.file from content c where ctg_id = '%s' "
                            . "order by c.%s %s  limit %s offset %s", $id, $attr, $asc, $limit, $offset));
        } else {
            $filter = filter_var($filter, FILTER_SANITIZE_STRING);
            $isi = $this->DB()->getTable("content")->search(array("id", "title", "visit", "content"), $filter, $id); //query(sprintf("select c.id,c.title,c.visit,c.content,c.file from content c where ctg_id = '%s'", $id));
        }
        if (empty($isi)) {
            $data['msg'] = "محتوا;اطلاعاتی یافت نشد;warning;true";
            return new JsonResponse($data);
        }
        $data['isi'] = $isi;
        return new JsonResponse($data);
    }

    /**
     * return one of content with id
     * @Route("/Default/ShowIsi/{id}")
     * @param type $id
     */
    public function ShowIsi($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $data = $this->DB()->getTable("content")->query(sprintf("select c.title,c.id,c.content,c.visit,c.file,c.ctg_id from content c where id = '%s'", $id));
        if (empty($data)) {
            $data['msg'] = "محتوا;اطلاعاتی یافت نشد;warning;true";
            return new JsonResponse($data);
        }
        $update = $data[0];
        $update['visit'] = $update['visit'] + 1;
        $this->DB()->getTable("content")->update($update);
        $data['isi'] = $data[0];
        $allIsi = $this->DB()->query(sprintf("select c.title,c.id,c.file from content c where c.ctg_id = '%s' order by c.visit desc limit 7", $update['ctg_id']));
        $data['allIsi'] = $allIsi;
        return new JsonResponse($data);
    }

    //@Route Default/news/"  + $scope.filter + "/" + after + "/3/id/desc
    public function news($filter, $offset, $limit, $attr, $asc) {
        $limit = filter_var($limit, FILTER_VALIDATE_INT) == false ? 3 : $limit;
        $offset = filter_var($offset, FILTER_VALIDATE_INT) == false ? 0 : $offset;
        $attr = filter_var($attr, FILTER_SANITIZE_STRING) == false ? "id" : $attr;
        $asc = $asc == "asc" ? "asc" : "desc";

        if ($filter == -1) {
            $news = $this->DB()->query(sprintf("select c.id,c.title,c.content,c.visit,c.created_at from content c where ctg_id = '1' "
                            . "order by c.%s %s  limit %s offset %s", $attr, $asc, $limit, $offset));
        } else {
            $filter = filter_var($filter, FILTER_SANITIZE_STRING);
            $news = $this->DB()->getTable("content")->search(array("id", "title", "visit", "content", "created_at"), $filter, 1);
        }
        if (empty($news)) {
            return new JsonResponse("NotInfo");
        }
        $data['news'] = [];
        foreach ($news as $value) {
            if (!empty($value['created_at'])) {
                $date = new \DateTime($value['created_at']);
                $date = $date->format("Y-m-d");
                $date = explode('-', $date);
                $date = Jalali::gregorian_to_jalali($date[0], $date[1], $date[2]);
                $value['created_at'] = $date[0] . "-" . $date[1] . "-" . $date[2];
                $data['news'][] = $value;
            }
        }
        return new JsonResponse($data);
    }

    public function Contact() {
        $data = $this->Request()->json()->request()->getAny(["name", "mobile", "email", "message"]);
        foreach ($data as $key => $value) {
            if (empty($value)) {
                return new \lib\Response("فیلد  $key نمی تواند خالی باشد");
            }
        }
        $result = $this->DB()->getTable("Contact")->insert($data);
        if ($result) {
            return new \lib\Response("اطلاعات با موفقیت ثبت شد و توسط ما بررسی خواهد شد ");
        }
    }

    public function Services() {
        $data = $this->DB()->query("select s.id,s.title from Services s");
        return new JsonResponse($data);
    }

    public function Service($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $data = $this->DB()->getTable("Services")->find($id);
        return new JsonResponse($data);
    }

}
