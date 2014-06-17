<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <body>
    <?php
    $scriptName = "ViewBidHistory.php";
    require "PHPprinter.php";
    $startTime = getMicroTime();

    $itemId = $_POST['itemId'];
    if ($itemId == null)
    {
      $itemId = $_GET['itemId'];
      if ($itemId == null)
      {
         printError($scriptName, $startTime, "Bid history", "You must provide an item identifier!<br>");
         exit();
      }
    }

    getDatabaseLink($link);

    // Get the item name
    $itemNameResult = mysql_query("SELECT name FROM items WHERE items.id=$itemId", $link) or die("ERROR: Query failed");
    if (mysql_num_rows($itemNameResult) == 0)
      $itemNameResult = mysql_query("SELECT name FROM old_items WHERE old_items.id=$itemId", $link) or die("ERROR: Query failed");
    if (mysql_num_rows($itemNameResult) == 0)
    {
      die("<h3>ERROR: Sorry, but this item does not exist.</h3><br>\n");
    }
    $itemNameRow = mysql_fetch_array($itemNameResult);
    $itemName = $itemNameRow["name"];


    // Get the list of bids for this item
    $bidsListResult = mysql_query("SELECT * FROM bids WHERE item_id=$itemId ORDER BY date DESC", $link) or die("ERROR: Bids list query failed");
    if (mysql_num_rows($bidsListResult) == 0)
      print ("<h2>There is no bid for $itemName. </h2><br>");
    else
      print ("<h2><center>Bid history for $itemName</center></h2><br>");

    printHTMLheader("RUBiS: Bid history for $itemName.");
    print("<TABLE border=\"1\" summary=\"List of bids\">\n".
                "<THEAD>\n".
                "<TR><TH>User ID<TH>Bid amount<TH>Date of bid\n".
                "<TBODY>\n");

    while ($bidsListRow = mysql_fetch_array($bidsListResult))
    {
        $bidAmount = $bidsListRow["bid"];
        $bidDate = $bidsListRow["date"];
        $userId = $bidsListRow["user_id"];
    // Get the bidder nickname
        if ($userId != 0)
    {
      $userNameResult = mysql_query("SELECT nickname FROM users WHERE id=$userId", $link) or die("ERROR: User nickname query failed");
      $userNameRow = mysql_fetch_array($userNameResult);
      $nickname = $userNameRow["nickname"];
        }
        else
      {
        print("Cannot lookup the user!<br>");
        printHTMLfooter($scriptName, $startTime);
        exit();
      }
        print("<TR><TD><a href=\"/PHP/ViewUserInfo.php?userId=".$userId."\">$nickname</a>"
          ."<TD>".$bidAmount."<TD>".$bidDate."\n");
    }
    print("</TABLE>\n");


    $link->close();

    printHTMLfooter($scriptName, $startTime);
    ?>
  </body>
</html>
