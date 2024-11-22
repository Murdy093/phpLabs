<?php
require_once('../app/Operators.php');
require_once('../app/BaseList.php');
class OperatorsList extends BaseList{
    public function add($params){
        $this->id++;
        $params['id']=$this->id;
        $elem=new Operators($params);
        array_push($this->dataArray,$elem);
    }
    public function exportAsArray(){
        $result=array(['operator_name','description','category','example']);
        foreach ($this->dataArray as $item){
            array_push($result,$item->getAsArray());
        }
        return $result;  
    }
    public function exportAsXML(){
        $result='<?xml version="1.0" encoding="UTF-8"?>';
        $result.='<operators>';
        foreach ($this->dataArray as $item) {
            $opData=$item->getAsAssocArray();
            $result.='<operator>
            <id>'.$opData['id'].'</id>
            <operator_name>'.$opData['operator_name'].'</operator_name>
            <description>'.$opData['description'].'</description>
            <category>'.$opData['category'].'</category>
            <example>'.$opData['example'].'</example>
            </operator>';
        }
        $result.='</operators>';
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
        if (($handle = fopen("../data/operators.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              if($row>0){
                $dataArray=array('operator_name'=>$data[0],'description'=>$data[1], 'category'=>$data[2], 'example'=>$data[3] );
                $this->add($dataArray);
              }
              $row++;
            }
            fclose($handle);
        }
    }
    public function saveToFile(){
        $fp = fopen('../data/operators.csv', 'w');
        foreach ($this->exportAsArray() as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
}


?>