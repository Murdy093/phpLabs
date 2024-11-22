<?php
require_once('../models/BaseList.php');
require_once('../models/Example.php');

class ExampleList extends BaseList {
    public function add($params) {
        if (isset($params['id'])) {
            $this->id++;
        } else {
            $this->id++;
            $params['id'] = $this->id;
        }
        $newExample = new Example($params);
        array_push($this->dataArray, $newExample);
    }

    public function exportAsArray() {
        $result = array(['example_text', 'operator', 'operator_id']);
        foreach ($this->dataArray as $item) {
            array_push($result, $item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML() {
        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= '<examples>';
        for ($i = 0; $i < count($this->dataArray); $i++) {
            $exampleData = $this->dataArray[$i]->getAsAssocArray();
            $result .= '<example>
                <id>'.$exampleData['id'].'</id>
                <example_text>'.$exampleData['example_text'].'</example_text>
                <operator>'.$exampleData['operator'].'</operator>
            </example>';
        }
        $result .= '</examples>';
        return $result;
    }

    public function readFromFile() {
        $row = 0;
        if (($handle = fopen("../data/examples.csv", "r")) !== false) {
            while (($data = fgetcsv($handle,1000,",")) !== false) {
                if ($row) {
                    $this->add(array('example_text'=>$data[0], 'operator'=>$data[1]));
                } else 
                $row = true;
            }
            fclose($handle);
        }
    }

    public function saveToFile() {
        $fp = fopen('../data/examples.csv', 'w');
        foreach ($this->exportAsArray() as $item) {
            fputcsv($fp, $item);
        }
        fclose($fp);
    }

    public function getFromDatabase($conn) {
        $sql = "SELECT e.example_id id, e.example_text, o.operator_name operator, e.operator_id FROM examples e INNER JOIN operators o ON e.operator_id = o.operator_id ORDER BY 3";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->add($row);
            }
        }
    }

    public function deleteFromDatabaseByID($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM examples WHERE example_id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return true;
    }

    public function addToDatabase($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['example_text'] == $params['example_text'] && $itemData['operator_id'] == $params['operator_id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("INSERT INTO examples VALUES (DEFAULT, ?, ?)");
        $code = $params['example_text'];
        $com = $params['operator_id'];
        $stmt->bind_param("ss", $com, $code);
        $stmt->execute();
        return true;
    }

    public function updateDatabaseRow($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['example_text'] == $params['example_text'] && $itemData['operator_id'] == $params['operator_id'] && $itemData['id'] != $params['id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("UPDATE examples SET example_text = ?, operator_id = ? WHERE example_id = ?");
        $code = $params['example_text'];
        $com = $params['operator_id'];
        $id = $params['id'];
        $stmt->bind_param("sss", $code, $com, $id);
        $stmt->execute();
        return true;
    }

    public function getBySearchQuery($conn, $query) {
        $stmt = $conn->prepare("SELECT e.example_id, e.example_text, o.operator_name, e.operator_id FROM examples e INNER JOIN operators o ON e.operator_id = o.operator_id WHERE example_text LIKE CONCAT ('%', ?, '%') ORDER BY 1");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $stmt->store_result();
        $id = null; $example_code = null; $command = null; $command_id = null;
        $stmt->bind_result($id, $example_code, $command, $command_id);
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch()) {
                $row = array();
                $row['id'] = $id;
                $row['example_text'] = $example_code;
                $row['operator'] = $command;
                $row['operator_id'] = $command_id;
                $this->add($row);
            }
        }
    }
}