<?php
class Operators{
    private $id;
    private $operator_name;
    private $description;
    private $category;
    private $example;
    public function __construct($params){
        $this->id=$params['id'];
        $this->operator_name=$params['operator_name'];
        $this->description=$params['description'];
        $this->category=$params['category'];
        $this->example=$params['example'];
    }
    public function __delete(){}
    public function update($params){
        if(isset($params['id'])){
			$this->id=$params['id'];
		}
        if (isset($params['operator_name'])){
            $this->operator_name=$params['operator_name'];
        }
        if (isset($params['description'])){
            $this->description=$params['description'];
        }
        if (isset($params['category'])){
            $this->category=$params['category'];
        }
        if (isset($params['example'])){
            $this->example=$params['example'];
        }
    }

    public function display(){
        echo '<b>'.$this->id.'. '.$this->operator_name.', опис оператора: '.$this->description.'</b>
        </br>Категорія: '.$this->category.'</br>Приклад: '.$this->example.'</br>';
    }

    public function __destruct(){
		$this->id=null;
		$this->operator_name=null;
		$this->description=null;
		$this->category=null;
		$this->example=null;
	}

    public function getId(){
        return $this->id;
      }

    public function getAsArray(){
        return array($this->operator_name,$this->description,$this->category,$this->example);
    }
    public function getAsAssocArray(){
        return array('id'=>$this->id,'operator_name'=>$this->operator_name,'description'=>$this->description,'category'=>$this->category,'example'=>$this->example);
    }
    public function getAsXML(){
        return '<operator>
                    <id>'.$this->id.'</id>
                    <operator_name>'.$this->operator_name.'</operator_name>
                    <description>'.$this->description.'</description>
                    <category>'.$this->category.'</category>
                    <example>'.$this->example.'</example>
                </operator>';
    }
    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->operator_name.'</td>
                    <td>'.$this->description.'</td>
                    <td>'.$this->category.'</td>
                    <td>'.$this->example.'</td>
                    <td><a href="add-operator.php?id='.$this->id.'">Редагувати</a><a href="operators-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}
?>