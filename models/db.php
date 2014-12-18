function DbExecute($query, $params = null) {
    global $db;
    try {
        $statement = $db->prepare($query);

        if (is_array($params)) {
            
            foreach ($params as $key => $value) {
                $statement->bindValue($key, $value);
            }
        }

        $statement->Execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        error_log($e);
        exit();
    }
}

function DbInsert($query, $params = null) {
    global $db;
    $return = false;

    try {
        $statement = $db->prepare($query);

        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $statement->bindValue($key, $value);
            }
        }

        $statement->Execute();
        $return = $db->lastInsertId();
    } catch (PDOException $e) {
        echo $e->getMessage();
        error_log($e);
        exit();
    }

    return $return;
}

function DbSelect($query, $params = null) {
    global $db;
    $return = array();
    try {
        $statement = $db->prepare($query);

        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $statement->bindValue($key, $value);
            }
        }

        $statement->Execute();

        while ($row = $statement->fetch()) {
            $return[] = $row;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        error_log($e);
        exit();
    }

    return $return;
}
