<?php
class Operator {
    private $id;
    private $name;
    private $description;
    private $category;
    private $category_id;
    
    public function __construct($params) {
        $this->id=$params['id'];
        $this->name=$params['name'];
        $this->description=$params['description'];
        $this->category=$params['category'];
        $this->category_id=$params['category_id'];
    }

    public function __destruct() {
        $this->id=null;
        $this->name=null;
        $this->description=null;
        $this->category=null;
        $this->category_id=null;
    }

    public function update($params) {
        if (isset($params['id'])) {
            $this->id=$params['id'];
        }
        if (isset($params['name'])) {
            $this->name=$params['name'];
        }
        if (isset($params['description'])) {
            $this->description=$params['description'];
        }
        if (isset($params['category'])) {
            $this->category=$params['category'];
        }
        if (isset($params['category_id'])) {
            $this->category_id=$params['category_id'];
        }
    }

    public function displayInfo() {
        echo '<b>'.$this->id.'</b>. '.$this->name.
        '</br><b>Опис:</b> '.$this->description.
        '</br><b>Категорія:</b> '.$this->category.'</br>';
    }

    public function getId() {
        return $this->id;
    }

    public function getAsArray() {
        return array($this->name, $this->description, $this->category, $this->category_id);
    }

    public function getAsAssocArray() {
        return array('id'=>$this->id, 'name'=>$this->name, 'description'=>$this->description, 'category'=>$this->category, 'category_id'=>$this->category_id);
    }

    public function getAsTableRow() {
        return '<tr>
                    <td>'.$this->name.'</td>
                    <td>'.$this->description.'</td>
                    <td>'.$this->category.'</td>
                    <td><a class="btn btn-secondary btn-sm" href="add-operator.php?id='.$this->id.'">Редагувати</a><a class="btn btn-secondary btn-sm" href="operator-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}