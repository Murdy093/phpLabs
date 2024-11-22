<?php
require_once('../app/Examples.php');
require_once('../app/BaseList.php');
class ExamplesList extends BaseList{
    public function add($params){
        $this->id++;
        $params['id']=$this->id;
        $elem=new Examples($params);
        array_push($this->dataArray,$elem);
    }
    public function exportAsArray(){
        $result=array(['example_text']);
        foreach ($this->dataArray as $item){
            array_push($result,$item->getAsArray());
        }
        return $result;  
    }
    public function exportAsXML(){
        $result='<?xml version="1.0" encoding="UTF-8"?>';
        $result.='<examples>';
        foreach ($this->dataArray as $item) {
            $exData=$item->getAsAssocArray();
            $result.='<example>
            <id>'.$exData['id'].'</id>
            <example_text>'.$exData['example_text'].'</example_text>
            </example>';
        }
        $result.='</examples>';
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
        if (($handle = fopen("../data/examples.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              if($row>0){
                $dataArray=array('example_text'=>$data[0]);
                $this->add($dataArray);
              }
              $row++;
            }
            fclose($handle);
        }
    }
    public function saveToFile(){
        $fp = fopen('../data/examples.csv', 'w');
        foreach ($this->exportAsArray() as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
}
?>