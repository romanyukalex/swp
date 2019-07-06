<?php

class CnGetResult
{
    public static function go($statement)
    {
        $result = array();
        $statement->store_result();
        for ($i = 0; $i < $statement->num_rows; $i++) {
            $metadata = $statement->result_metadata();
            $params = array();
            while ($Field = $metadata->fetch_field()) {
                $params[] = &$result[$i][$Field->name];
            }
            call_user_func_array(array($statement, 'bind_result'), $params);
            $statement->fetch();
        }
        return $result;
    }
}