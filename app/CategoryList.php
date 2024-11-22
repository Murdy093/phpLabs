<?php
require_once('../app/Category.php');
require_once('../app/BaseList.php');
class CategoryList extends BaseList{
    public function add($params){
        $this->id++;
        $params['id']=$this->id;
        $elem=new Category($params);
        array_push($this->dataArray,$elem);
    }
    public function exportAsArray(){
        $result=array(['name']);
        foreach ($this->dataArray as $item){
            array_push($result,$item->getAsArray());
        }
        return $result;  
    }
    public function exportAsXML(){
        $result='<?xml version="1.0" encoding="UTF-8"?>';
        $result.='<categories>';
        foreach ($this->dataArray as $item) {
            $exData=$item->getAsAssocArray();
            $result.='<category>
            <id>'.$exData['id'].'</id>
            <name>'.$exData['name'].'</name>
            </category>';
        }
        $result.='</categories>';
        return $result;
    }
    public function exportAsJSON(){
        $result = array();
        foreach ($this->dataArray as $item){
            array_push($result,$item->getAsAssocArray());
        }
        return json_encode($result);  
    }
    public function readFromFile(){
        $row=0;
        if (($handle = fopen("../data/category.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              if($row>0){
                $dataArray=array('name'=>$data[0]);
                $this->add($dataArray);
              }
              $row++;
            }
            fclose($handle);
        }
    }
    public function saveToFile(){
        $fp = fopen('../data/category.csv', 'w');
        foreach ($this->exportAsArray() as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
}
?>