<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <body>
    <?php
    $scriptName = "BrowseCategories.php";
    require "PHPprinter.php";
    $startTime = getMicroTime();

    $region = @$_GET['region'];
    $username = @$_GET['nickname'];
    $password = @$_GET['password'];

    getDatabaseLink($link);

    $userId = -1;
    if (($username != null && $username !="") || ($password != null && $password !="")) {
        // Authenticate the user
        $userId = authenticate($username, $password, $link);
        if ($userId == -1) {
            printError($scriptName, $startTime, "Authentication", "You don't have an account on RUBiS!<br>You have to register first.<br>\n");
            exit();
        }
    }

    printHTMLheader("RUBiS available categories");

    if ($CURRENT_SCHEMA == SchemaType::RELATIONAL) {
      $categories = $link->categories->get_range();
      if (!!current($categories))
        print("<h2>Sorry, but there is no category available at this time. Database table is empty</h2><br>\n");
      else
        print("<h2>Currently available categories</h2><br>\n");

      foreach ($categories as $id => $row) {
        if ($region != NULL)
          print("<a href=\"/PHP/SearchItemsByRegion.php?category=".$id."&categoryName=".urlencode($row["name"])."&region=$region\">".$row["name"]."</a><br>\n");
        else if ($userId != -1)
          print("<a href=\"/PHP/SellItemForm.php?category=".$row["id"]."&user=$userId\">".$row["name"]."</a><br>\n");
        else
          print("<a href=\"/PHP/SearchItemsByCategory.php?category=".$id."&categoryName=".urlencode($row["name"])."\">".$row["name"]."</a><br>\n");
      }
    }

    $link->close();

    printHTMLfooter($scriptName, $startTime);
    ?>
  </body>
</html>
