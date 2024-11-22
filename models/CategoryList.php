<?php
require_once('../models/BaseList.php');
require_once('../models/Category.php');

class CategoryList extends BaseList {
    public function add($params) {
        if (isset($params['id'])) {
            $this->id++;
        } else {
            $this->id++;
            $params['id'] = $this->id;
        }
        $newType = new Category($params);
        array_push($this->dataArray, $newType);
    }

    public function exportAsArray() {
        $result = array(['name']);
        foreach ($this->dataArray as $item) {
            array_push($result, $item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML() {
        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= '<categories>';
        for ($i = 0; $i < count($this->dataArray); $i++) {
            $typeData = $this->dataArray[$i]->getAsAssocArray();
            $result .= '<category>
                <id>'.$typeData['id'].'</id>
                <name>'.$typeData['name'].'</name>
            </category>';
        }
        $result .= '</categories>';
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
        if (($handle = fopen("../data/category.csv", "r")) !== false) {
            while (($data = fgetcsv($handle,1000,",")) !== false) {
                if ($row) {
                    $this->add(array('name'=>$data[0]));
                } else 
                $row = true;
            }
            fclose($handle);
        }
    }

    public function saveToFile() {
        $fp = fopen('../data/category.csv', 'w');
        foreach ($this->exportAsArray() as $item) {
        fputcsv($fp, $item);
        }
        fclose($fp);
    }

    public function getFromDatabase($conn) {
        $sql = "SELECT category_id id, category_name name FROM categories ORDER BY 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->add($row);
            }
        }
    }

    public function deleteFromDatabaseByID($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM categories WHERE category_id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return true;
    }

    public function addToDatabase($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name']) {
                return false;
            }
        }
        $stmt = $conn->prepare("INSERT INTO categories VALUES (DEFAULT, ?)");
        $name = $params['name'];
        $stmt->bind_param("s", $name);
        $stmt->execute();
        return true;
    }

    public function updateDatabaseRow($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name'] && $itemData['id'] != $params['id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
        $name = $params['name'];
        $id = $params['id'];
        $stmt->bind_param("ss", $name, $id);
        $stmt->execute();
        return true;
    }

    public function getBySearchQuery($conn, $query) {
        $stmt = $conn->prepare("SELECT category_id, category_name FROM categories WHERE category_name LIKE CONCAT ('%', ?, '%') ORDER BY 1");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $stmt->store_result();
        $id = null; $name = null;
        $stmt->bind_result($id, $name);
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch()) {
                $row = array();
                $row['id'] = $id;
                $row['name'] = $name;
                $this->add($row);
            }
        }
    }
}