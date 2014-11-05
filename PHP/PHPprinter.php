<?php

require "vendor/autoload.php";

set_time_limit(0);

use phpcassa\Connection\ConnectionPool;
use phpcassa\ColumnFamily;

class ColumnFamilies {
  private $pool;
  private $cfs;

  public function __construct($pool) {
    $this->pool = $pool;
    $this->cfs = array();
  }

  public function __isset($offset) {
    return array_key_exists($offset, $this->cfs);
  }

  public function __get($offset) {
    if (!$this->__isset($offset)) {
      $cfs[$offset] = new ColumnFamily($this->pool, $offset);
    }

    return $cfs[$offset];
  }

  public function close() {
    $this->pool->close();
  }
}

abstract class SchemaType {
    const RELATIONAL = 1;
    const UNCONSTRAINED = 2;
    const HALF = 3;
}

$CURRENT_SCHEMA = SchemaType::HALF;
$USE_MULTIGET = true;

function getDatabaseLink(&$link)
{
  $pool = new ConnectionPool('RUBiS');
  $link = new ColumnFamilies($pool);
}

$link = null;
getDatabaseLink($link);

function getMicroTime() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function printHTMLheader($title) {
    include "header.html";
    print("<title>$title</title>");
}

function printHTMLHighlighted($msg) {
    print("<table width=\"100%\" bgcolor=\"#CCCCFF\">\n");
    print(
        "<tr><td align=\"center\" width=\"100%\">".
        "<font size=\"4\" color=\"#000000\"><b>$msg</b></font></td></tr>\n"
    );
    print("</table><p>\n");
}

function printHTMLfooter($scriptName, $startTime) {
    $endTime = getMicroTime();
    $totalTime = $endTime - $startTime;
    printf(
        "<br><hr>RUBiS (C) Rice University/INRIA<br>".
        "<i>Page generated by $scriptName in %.3f seconds</i><br>\n",
        $totalTime
    );
    print("</body>\n</html>\n");
}

function printError($scriptName, $startTime, $title, $error) {
    printHTMLheader("RUBiS ERROR: $title");
    print(
        "<h2>We cannot process your request due to the following error: ".
        "</h2><br>\n"
    );
    print($error);
    printHTMLfooter($scriptName, $startTime);
}

function authenticate($nickname, $password, $link) {
    $result = mysql_query(
        "SELECT id FROM users WHERE nickname=\"$nickname\" ".
        "AND password=\"$password\"", $link
    )
        or die("ERROR: Authentification query failed");
    if (mysql_num_rows($result) == 0) {
        return -1;
    }
    $row = mysql_fetch_array($result);
    return $row["id"];
}
