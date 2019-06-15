<?php
include 'conec.php';

class _MysqliDB
{
    public function _count($query, $dataTypes, $values)
    {
        global $conn;
        $rows = [];
        $sentencia = $conn->prepare($query);
        $sentencia->bind_param($dataTypes, ...$values);
        if ($sentencia->execute()) {
            $result = $sentencia->get_result()->num_rows;
            header('Content-type: application/json');
            return $result;
        } else httpCode(400, 'No se pudo realizar la búsqueda');
    }

    public  function _create($query, $dataTypes, $values)
    {

        global $conn;
        $sentencia = $conn->prepare($query);
        $conn->autocommit(FALSE);
        $sentencia->bind_param($dataTypes, ...$values);
        if ($sentencia->execute()) {
            $conn->commit();
            httpCode(200, "Actualizado correctamente");
            return true;
        } else {
            $conn->rollback();
            httpCode(400, "No se pudo agregar, {$sentencia->error}");
            return false;
        }
    }

    public function _read($query, $dataTypes, $values)
    {
        global $conn;
        $rows = [];
        $sentencia = $conn->prepare($query);
        if (!empty($values)) {
            $sentencia->bind_param($dataTypes, ...$values);
        }
        if ($sentencia->execute()) {
            $result = $sentencia->get_result()->fetch_all(MYSQLI_ASSOC);
            header('Content-type: application/json');

            return $result;
        } else httpCode(400, 'No se pudo realizar la búsqueda');
    }

    public function _update($query, $dataTypes, $values)
    {
        $this->_create($query, $dataTypes, $values);
    }
    public function _delete($query, $dataTypes, $values)
    {
        $this->_create($query, $dataTypes, $values);
    }


    public function _lastInsertId()
    {
        global $conn;
        return mysqli_insert_id($conn);
    }
}


function validateSessionId(string $sessionElement, $value, $customMessage)
{
    if ($_SESSION[$sessionElement] !== $value) {
        httpCode(401, $customMessage);
        die();
        return false;
    } else {
        return true;
    }
}
function printJSON($array)
{
    return print_r(json_encode($array));
}

function httpCode($codigo, $mensaje)
{
    $error['codigo'] = $codigo;
    $error['mensaje'] = $mensaje;
    header('Content-Type: application/json');
    print_r(json_encode($error, JSON_UNESCAPED_UNICODE));
    http_response_code((int)$codigo);
}
?>
