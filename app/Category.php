<?php
class Category{
    private $id;
    private $name;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function __delete(){}
    public function update($params){
        if (isset($params['name'])){
            $this->name=$params['name'];
        }
    }
    public function display(){
        echo $this->id.'. '.$this->name.'</br>';
    }
    public function getId(){
        return $this->id;
      }
    public function getAsArray(){
        return array($this->name);
    }
    public function getAsAssocArray(){
        return array('id'=>$this->id,'name'=>$this->name);
    }
    public function getAsXML(){
        return '<category>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                </category>';
    }
    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td><a href="add-category.php?id='.$this->id.'">Редагувати</a><a href="category-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
  }
 
?>