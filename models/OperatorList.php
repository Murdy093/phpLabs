<?php
require_once('../models/BaseList.php');
require_once('../models/Operator.php');

class OperatorList extends BaseList {
    public function add($params) {
        if (isset($params['id'])) {
            $this->id++;
        } else {
            $this->id++;
            $params['id'] = $this->id;
        }
        $newComm = new Operator($params);
        array_push($this->dataArray, $newComm);
    }

    public function exportAsArray() {
        $result = array(['name', 'description', 'category', 'category_id', 'example']);
        foreach ($this->dataArray as $item) {
            array_push($result, $item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML() {
        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= '<operators>';
        for ($i = 0; $i < count($this->dataArray); $i++) {
            $comData = $this->dataArray[$i]->getAsAssocArray();
            $result .= '<operator>
                <id>'.$comData['id'].'</id>
                <name>'.$comData['name'].'</name>
                <description>'.$comData['description'].'</description>
                <category>'.$comData['category'].'</category>
            </operator>';
        }
        $result .= '</operators>';
        return $result;
    }
    
    public function exportAsDropdownItems($activeItem) {
        $result = '';
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            $result .= '<option '.($activeItem == $itemData['name'] ? 'selected' : '').' value="'.$itemData['id'].'">'.$itemData['name'].'</option>';
        }
        return $result;
    }

    public function readFromFile() {
        $row = 0;
        if (($handle = fopen("../data/operators.csv", "r")) !== false) {
            while (($data = fgetcsv($handle,1000,",")) !== false) {
                if ($row) {
                    $this->add(array('name'=>$data[0], 'description'=>$data[1], 'category'=>$data[2]));
                } else
                $row = true;
            }
            fclose($handle);
        }
    }

    public function saveToFile() {
        $fp = fopen('../data/operators.csv', 'w');
        foreach ($this->exportAsArray() as $item) {
        fputcsv($fp, $item);
        }
        fclose($fp);
    }

    public function getFromDatabase($conn) {
        $sql = "SELECT o.operator_id id, o.operator_name name, o.description, c.category_name category, c.category_id FROM operators o INNER JOIN categories c ON c.category_id = o.category_id ORDER BY 2";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->add($row);
            }
        }
    }

    public function deleteFromDatabaseByID($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM operators WHERE operator_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return true;
    }

    public function addToDatabase($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name'] && $itemData['description'] == $params['description'] && $itemData['category_id'] == $params['category_id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("INSERT INTO operators VALUES (DEFAULT, ?, ?, ?)");
        $name = $params['name'];
        $desc = $params['description'];
        $category_id = $params['category_id'];
        $stmt->bind_param("sss", $name, $desc, $category_id);
        $stmt->execute();
        return true;
    }

    public function updateDatabaseRow($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name'] && $itemData['description'] == $params['description'] && $itemData['category_id'] == $params['category_id'] && $itemData['id'] != $params['id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("UPDATE operators SET operator_name = ?, description = ?, category_id = ? WHERE operator_id = ?");
        $name = $params['name'];
        $desc = $params['description'];
        $category_id = $params['category_id'];
        $id = $params['id'];
        $stmt->bind_param("ssss", $name, $desc, $category_id, $id);
        $stmt->execute();
        return true;
    }

    public function getBySearchQuery($conn, $query) {
        $stmt = $conn->prepare("
            SELECT o.operator_id, o.operator_name, o.description, c.category_name, o.category_id 
            FROM operators o 
            INNER JOIN categories c ON c.category_id = o.category_id 
            WHERE o.operator_name LIKE CONCAT ('%',?,'%') 
            OR o.description LIKE CONCAT ('%',?,'%')
            OR c.category_name LIKE CONCAT ('%',?,'%')
            ORDER BY 1");
        $stmt->bind_param("sss", $query, $query, $query);
        $stmt->execute();
        $stmt->store_result();
        $id = null; $name = null; $description = null; $category = null; $category_id = null;
        $stmt->bind_result($id, $name, $description, $category, $category_id);
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch()) {
                $row = array();
                $row['id'] = $id;
                $row['name'] = $name;
                $row['description'] = $description;
                $row['category'] = $category;
                $row['category_id'] = $category_id;
                $this->add($row);
            }
        }
    }   
}