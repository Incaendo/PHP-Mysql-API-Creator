<?php

/**
 * Description of database
 *
 * @author kapil
 */
class DatabaseManager {

  public function prepareTableList($app) {
    $getTablesQuery = "SHOW TABLES";
    $getTablesResult = $app['db']->fetchAll($getTablesQuery, array());
    $_dbTables = array();
    $dbTables = array();
    foreach ($getTablesResult as $getTableResult) {
      $_dbTables[] = reset($getTableResult);

      $dbTables[] = array(
        "name" => reset($getTableResult),
        "columns" => array()
      );
    }

    foreach ($dbTables as $dbTableKey => $dbTable) {
      $getTableColumnsQuery = "SHOW FULL COLUMNS FROM `" . $dbTable['name'] . "`";
      $getTableColumnsResult = $app['db']->fetchAll($getTableColumnsQuery, array());
      foreach ($getTableColumnsResult as $getTableColumnResult) {
        $dbTables[$dbTableKey]['columns'][] = $getTableColumnResult;
      }
    }

    $tables = array();
    foreach ($dbTables as $dbTable) {
      if (count($dbTable['columns']) <= 1) {
        continue;
      }
      $table_name = $dbTable['name'];
      $table_columns = array();
      $primary_key = false;
      $primary_keys = 0;
      $primary_keys_auto = 0;
      foreach ($dbTable['columns'] as $column) {
        if (isset($column['Comment']) && $column['Comment'] != "") {
          continue;
        }
        if ($column['Key'] == "PRI") {
          $primary_keys++;
        }
        if ($column['Extra'] == "auto_increment") {
          $primary_keys_auto++;
        }
      }
      if ($primary_keys === 1 || ($primary_keys > 1 && $primary_keys_auto === 1)) {
        foreach ($dbTable['columns'] as $column) {
          $external_table = false;
          if ($primary_keys > 1 && $primary_keys_auto == 1) {
            if ($column['Extra'] == "auto_increment") {
              $primary_key = $column['Field'];
            }
          } else if ($primary_keys == 1) {
            if ($column['Key'] == "PRI") {
              $primary_key = $column['Field'];
            }
          } else {
            continue 2;
          }
          if (substr($column['Field'], -3) == "_id") {
            $_table_name = substr($column['Field'], 0, -3);

            if (in_array($_table_name, $_dbTables)) {
              $external_table = $_table_name;
            }
          }

          $table_columns[] = array(
            "name" => $column['Field'],
            "primary" => $column['Field'] == $primary_key ? true : false,
            "nullable" => $column['Null'] == "NO" ? true : false,
            "auto" => $column['Extra'] == "auto_increment" ? true : false,
            "external" => $column['Field'] != $primary_key ? $external_table : false,
            "type" => $column['Type']
          );
        }
      } else {
        continue;
      }
      
      $tables[$table_name] = array(
        "primary_key" => $primary_key,
        "columns" => $table_columns
      );
    }
    return $tables;
  }

}
