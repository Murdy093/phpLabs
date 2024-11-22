<?php
class Example {
    private $id;
    private $example_text;
    private $operator;
    private $operator_id;

    public function __construct($params) {
        $this->id=$params['id'];
        $this->example_text=$params['example_text'];
        $this->operator=$params['operator'];
        $this->operator_id=$params['operator_id'];
    }

    public function __destruct() {
        $this->id=null;
        $this->example_text=null;
        $this->operator=null;
        $this->operator_id=null;
    }

    public function update($params) {
        if (isset($params['id'])) {
            $this->id=$params['id'];
        }
        if (isset($params['example_text'])) {
            $this->example_text=$params['example_text'];
        }
        if (isset($params['operator'])) {
            $this->operator=$params['operator'];
        }
        if (isset($params['operator_id'])) {
            $this->operator_id=$params['operator_id'];
        }
    }

    public function displayInfo() {
        echo '<b>'.$this->id.'</b>. '.$this->example_text.'</br>'.$this->operator.'</br>';
    }

    public function getId() {
        return $this->id;
    }

    public function getAsArray() {
        return array($this->example_text, $this->operator, $this->operator_id);
    }

    public function getAsAssocArray() {
        return array('id'=>$this->id, 'example_text'=>$this->example_text, 'operator'=>$this->operator, 'operator_id'=>$this->operator_id);
    }

    public function getAsTableRow() {
        return '<tr>
                    <td>'.$this->example_text.'</td>
                    <td>'.$this->operator.'</td>
                    <td><a class="btn btn-secondary btn-sm" href="add-example.php?id='.$this->id.'">Редагувати</a><a class="btn btn-secondary btn-sm" href="example-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}