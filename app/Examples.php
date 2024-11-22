<?php
class Examples{
    private $id;
    private $example_text;
    public function __construct($params){
        $this->id=$params['id'];
        $this->example_text=$params['example_text'];
    }
    public function __delete(){}
    public function update($params){
        if (isset($params['example_text'])){
            $this->example_text=$params['example_text'];
        }
    }
    public function display(){
        echo $this->id.'. '.$this->example_text.'</br>';
    }
    public function getId(){
        return $this->id;
      }
    public function getAsArray(){
        return array($this->example_text);
    }
    public function getAsAssocArray(){
        return array('id'=>$this->id,'example_text'=>$this->example_text);
    }
    public function getAsXML(){
        return '<example>
                    <id>'.$this->id.'</id>
                    <example_text>'.$this->example_text.'</example_text>
                </example>';
    }
    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->example_text.'</td>
                    <td><a href="add-example.php?id='.$this->id.'">Редагувати</a><a href="examples-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}
?>
