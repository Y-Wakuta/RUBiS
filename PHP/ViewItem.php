<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <body>
    <?php
    use phpcassa\ColumnFamily;
    use phpcassa\ColumnSlice;

    $scriptName = "ViewItem.php";
    require "PHPprinter.php";
    $startTime = getMicroTime();

    $itemId = @$_GET['itemId'];
    if ($itemId == null) {
         printError($scriptName, $startTime, "Viewing item", "You must provide an item identifier!<br>");
         exit();
    }

    getDatabaseLink($link);

    // Q: SELECT name FROM items WHERE items.id = ?
    // Q: SELECT name FROM olditems WHERE olditems.id = ?
    if ($CURRENT_SCHEMA >= SchemaType::UNCONSTRAINED) {
        if ($USE_CANNED) {
            $nameResult =  array ( 0 => array ( 0 => array ( 0 => '500561', 1 => 'buy_now', ), 1 => '0', ), 1 => array ( 0 => array ( 0 => '500561', 1 => 'category', ), 1 => '7', ), 2 => array ( 0 => array ( 0 => '500561', 1 => 'description', ), 1 => 'This incredible item is exactly what you need !
                It has a lot of ', ), 3 => array ( 0 => array ( 0 => '500561', 1 => 'end_date', ), 1 => '2002-04-02 01:35:59', ), 4 => array ( 0 => array ( 0 => '500561', 1 => 'initial_price', ), 1 => '4607', ), 5 => array ( 0 => array ( 0 => '500561', 1 => 'max_bid', ), 1 => '4625', ), 6 => array ( 0 => array ( 0 => '500561', 1 => 'name', ), 1 => 'RUBiS automatically generated item #33007', ), 7 => array ( 0 => array ( 0 => '500561', 1 => 'nb_of_bids', ), 1 => '4', ), 8 => array ( 0 => array ( 0 => '500561', 1 => 'quantity', ), 1 => '2', ), 9 => array ( 0 => array ( 0 => '500561', 1 => 'reserve_price', ), 1 => '0', ), 10 => array ( 0 => array ( 0 => '500561', 1 => 'seller', ), 1 => '243745', ), 11 => array ( 0 => array ( 0 => '500561', 1 => 'start_date', ), 1 => '2002-03-26 01:35:59', ), );
        } else {
        try {
            $cf = $link->I2115247770;
            $cf->return_format = ColumnFamily::ARRAY_FORMAT;
            $nameResult = $cf->get($itemId);
        } catch (cassandra\NotFoundException $e) {
            try {
              $cf = $link->I810361528;
              $cf->return_format = ColumnFamily::ARRAY_FORMAT;
              $nameResult = $cf->get($itemId);
            } catch (cassandra\NotFoundException $e) {
                die("<h3>ERROR: Sorry, but this item does not exist.</h3><br>\n");
            }
        }
        }
        $row = call_user_func_array('array_merge', array_map(function ($elem) {
            return array($elem[0][1] => $elem[1]);
        }, $nameResult));
    } elseif ($CURRENT_SCHEMA >= SchemaType::RELATIONAL) {
        if ($USE_CANNED) {
          $row = array ( 'buy_now' => '0', 'category' => '7', 'description' => 'This incredible item is exactly what you need !
                It has a lot of ', 'end_date' => '2002-04-02 01:35:59', 'initial_price' => '4607', 'max_bid' => '4625', 'name' => 'RUBiS automatically generated item #33007', 'nb_of_bids' => '4', 'quantity' => '2', 'reserve_price' => '0', 'seller' => '243745', 'start_date' => '2002-03-26 01:35:59', );
        } else {
        try {
            $row = $link->items->get($itemId);
        } catch (cassandra\NotFoundException $e) {
            try {
                $row = $link->old_items->get($itemId);
            } catch (cassandra\NotFoundException $e) {
                die("<h3>ERROR: Sorry, but this item does not exist.</h3><br>\n");
            }
        }
        }
    }

    // Q: SELECT bid FROM bids WHERE bids.item_id = ? ORDER BY bids.bid LIMIT 1
    if ($CURRENT_SCHEMA >= SchemaType::HALF) {
        $maxBid = 0;
        if ($USE_CANNED) {
          $bidResults =  array ( 0 => array ( 0 => array ( 0 => '5054860', 1 => 'bid', ), 1 => '4616', ), 1 => array ( 0 => array ( 0 => '5054860', 1 => 'date', ), 1 => '2001-10-19 01:07:33', ), 2 => array ( 0 => array ( 0 => '5054860', 1 => 'qty', ), 1 => '2', ), 3 => array ( 0 => array ( 0 => '5054860', 1 => 'user_id', ), 1 => '243745', ), 4 => array ( 0 => array ( 0 => '5058956', 1 => 'bid', ), 1 => '4621', ), 5 => array ( 0 => array ( 0 => '5058956', 1 => 'date', ), 1 => '2001-10-19 01:26:40', ), 6 => array ( 0 => array ( 0 => '5058956', 1 => 'qty', ), 1 => '2', ), 7 => array ( 0 => array ( 0 => '5058956', 1 => 'user_id', ), 1 => '243745', ), 8 => array ( 0 => array ( 0 => '5059993', 1 => 'bid', ), 1 => '11', ), 9 => array ( 0 => array ( 0 => '5059993', 1 => 'date', ), 1 => '2001-10-19 01:35:29', ), 10 => array ( 0 => array ( 0 => '5059993', 1 => 'qty', ), 1 => '1', ), 11 => array ( 0 => array ( 0 => '5059993', 1 => 'user_id', ), 1 => '243745', ), 12 => array ( 0 => array ( 0 => '5060247', 1 => 'bid', ), 1 => '6', ), 13 => array ( 0 => array ( 0 => '5060247', 1 => 'date', ), 1 => '2001-10-19 01:37:13', ), 14 => array ( 0 => array ( 0 => '5060247', 1 => 'qty', ), 1 => '1', ), 15 => array ( 0 => array ( 0 => '5060247', 1 => 'user_id', ), 1 => '243745', ), );
        } else {
        try {
          $cf = $link->I2589792665;
          $cf->return_format = ColumnFamily::ARRAY_FORMAT;
          $bidResults = $cf->get($itemId);
        } catch (cassandra\NotFoundException $e) {
          $bidResults = array();
        }
        }

        foreach ($bidResults as $bid) {
            if (strcmp($bid[0][1], 'bid') === 0) {
              $maxBid = max($maxBid, intval($bid[1]));
            }
        }
    } elseif ($CURRENT_SCHEMA >= SchemaType::UNCONSTRAINED) {
        try {
            if ($USE_CANNED) {
              $maxBid = array ( 0 => array ( 0 => array ( 0 => '11', ), 1 => ' ', ), );
            } else {
              $cf = $link->I2744950719;
              $cf->return_format = ColumnFamily::ARRAY_FORMAT;
              $slice = new ColumnSlice('', '', $count=1);
              $maxBid = $cf->get($itemId, $slice);
            }

            $maxBid = intval($maxBid[0][0][0]);
        } catch (cassandra\NotFoundException $e) {
            $maxBid = 0;
        }
    } elseif ($CURRENT_SCHEMA >= SchemaType::RELATIONAL) {
        try {
            if ($USE_CANNED) {
              $bid_ids = array ( 0 => 5054860, 1 => 5058956, 2 => 5059993, 3 => 5060247, );
            } else {
              $bid_ids = array_keys($link->bid_item->get($itemId));
            }

            if ($USE_CANNED) {
              $bids = array ( 5054860 => array ( 'bid' => '4616', ), 5058956 => array ( 'bid' => '4621', ), 5059993 => array ( 'bid' => '11', ), 5060247 => array ( 'bid' => '6', ), );
            } elseif ($USE_MULTIGET) {
              $bids = $link->bids->multiget($bid_ids, $column_slice=null, $column_names=array("bid"));
            } else {
              $bids = array_combine($bid_ids, array_map(function($bid_id) use ($link) { return $link->bids->get($bid_id, $column_slice=null, $column_names=array("bid")); }, $bid_ids));
            }
            $bids = call_user_func_array('array_merge', array_map('array_values', $bids));
            $maxBid = count($bids) > 0 ? max($bids) : 0;
        } catch (cassandra\NotFoundException $e) {
            $maxBid = 0;
        }
    }

    if ($maxBid == 0) {
        $maxBid = $row["initial_price"];
        $buyNow = $row["buy_now"];
        $firstBid = "none";
        $nbOfBids = 0;
    } else {
        if ($row["quantity"] > 1) {
            // Q: SELECT bid, qty FROM bids WHERE bids.item_id = ? ORDER BY bids.bid LIMIT 5
            if ($CURRENT_SCHEMA == SchemaType::UNCONSTRAINED) {
                if ($USE_CANNED) {
                    $bidResult = array ( 0 => array ( 0 => array ( 0 => '11', 1 => '5059993', ), 1 => '1', ), 1 => array ( 0 => array ( 0 => '4616', 1 => '5054860', ), 1 => '2', ), 2 => array ( 0 => array ( 0 => '4621', 1 => '5058956', ), 1 => '2', ), 3 => array ( 0 => array ( 0 => '6', 1 => '5060247', ), 1 => '1', ), );
                } else {
                    $cf = $link->I2203934753;
                    $cf->return_format = ColumnFamily::ARRAY_FORMAT;
                    $bidResult = $cf->get($itemId);
                }

                $nb = 0;
                foreach ($bidResult as $bid) {
                    $nb += $bid[1];
                    if ($nb > $row["quantity"]) {
                        $maxBid = $row["max_bid"];
                        break;
                    }
                }
            } elseif ($CURRENT_SCHEMA >= SchemaType::HALF) {
                if ($USE_CANNED) {
                  $bidResult = array ( 0 => array ( 0 => array ( 0 => '5054860', 1 => 'bid', ), 1 => '4616', ), 1 => array ( 0 => array ( 0 => '5054860', 1 => 'date', ), 1 => '2001-10-19 01:07:33', ), 2 => array ( 0 => array ( 0 => '5054860', 1 => 'qty', ), 1 => '2', ), 3 => array ( 0 => array ( 0 => '5054860', 1 => 'user_id', ), 1 => '243745', ), 4 => array ( 0 => array ( 0 => '5058956', 1 => 'bid', ), 1 => '4621', ), 5 => array ( 0 => array ( 0 => '5058956', 1 => 'date', ), 1 => '2001-10-19 01:26:40', ), 6 => array ( 0 => array ( 0 => '5058956', 1 => 'qty', ), 1 => '2', ), 7 => array ( 0 => array ( 0 => '5058956', 1 => 'user_id', ), 1 => '243745', ), 8 => array ( 0 => array ( 0 => '5059993', 1 => 'bid', ), 1 => '11', ), 9 => array ( 0 => array ( 0 => '5059993', 1 => 'date', ), 1 => '2001-10-19 01:35:29', ), 10 => array ( 0 => array ( 0 => '5059993', 1 => 'qty', ), 1 => '1', ), 11 => array ( 0 => array ( 0 => '5059993', 1 => 'user_id', ), 1 => '243745', ), 12 => array ( 0 => array ( 0 => '5060247', 1 => 'bid', ), 1 => '6', ), 13 => array ( 0 => array ( 0 => '5060247', 1 => 'date', ), 1 => '2001-10-19 01:37:13', ), 14 => array ( 0 => array ( 0 => '5060247', 1 => 'qty', ), 1 => '1', ), 15 => array ( 0 => array ( 0 => '5060247', 1 => 'user_id', ), 1 => '243745', ), );
                } else {
                  $cf = $link->I2589792665;
                  $cf->return_format = ColumnFamily::ARRAY_FORMAT;
                  $bidResult = $cf->get($itemId);
                }

                $bids = array();
                foreach ($bidResult as $bid) {
                    $id = $bid[0][0];
                    if (!isset($bids[$id])) {
                        $bids[$id] = array();
                    }
                    $bids[$id][$bid[0][1]] = $bid[1];
                }
                uasort($bids, function($bida, $bidb) { return $bidb["bid"] - $bida["bid"]; });

                $nb = 0;
                foreach ($bids as $bid) {
                    $nb += $bid["qty"];
                    if ($nb > $row["quantity"]) {
                        $maxBid = $row["max_bid"];
                        break;
                    }
                }
            } elseif ($CURRENT_SCHEMA >= SchemaType::RELATIONAL) {
                // Fetch bids, sort, and take the top "quantity" number
                if ($USE_CANNED) {
                  $bid_ids = array ( 0 => 5054860, 1 => 5058956, 2 => 5059993, 3 => 5060247, );
                } else {
                  $bid_ids = array_keys($link->bid_item->get($itemId));
                }

                if ($USE_CANNED) {
                  $bids = array ( 5054860 => array ( 'bid' => '4616', 'date' => '2001-10-19 01:07:33', 'item_id' => '500561', 'max_bid' => '4624', 'qty' => '2', 'user_id' => '243745', ), 5058956 => array ( 'bid' => '4621', 'date' => '2001-10-19 01:26:40', 'item_id' => '500561', 'max_bid' => '4625', 'qty' => '2', 'user_id' => '243745', ), 5059993 => array ( 'bid' => '11', 'date' => '2001-10-19 01:35:29', 'item_id' => '500561', 'max_bid' => '21', 'qty' => '1', 'user_id' => '243745', ), 5060247 => array ( 'bid' => '6', 'date' => '2001-10-19 01:37:13', 'item_id' => '500561', 'max_bid' => '11', 'qty' => '1', 'user_id' => '243745', ), );
                } elseif ($USE_MULTIGET) {
                  $bids = $link->bids->multiget($bid_ids);
                } else {
                  $bids = array_combine($bid_ids, array_map(function ($bid_id) use($link) { return $link->bids->get($bid_id); }, $bid_ids));
                }

                uasort(
                    $bids,
                    function ($a, $b) {
                        return $a["bid"] - $b["bid"];
                    }
                );
                $xRes = array_slice($bids, 0, $row["quantity"]);

                $nb = 0;
                foreach ($xRes as $xRow) {
                    $nb += $xRow["qty"];
                    if ($nb > $row["quantity"]) {
                        $maxBid = $row["bid"];
                        break;
                    }
                }
            }
        }
        $firstBid = $maxBid;

        // Q: SELECT id FROM bids WHERE bids.item_id = ?
        if ($USE_CANNED) {
            $nbOfBids = 4;
        } else {
        if ($CURRENT_SCHEMA == SchemaType::UNCONSTRAINED) {
            $nbOfBids = $link->I4004689239->get_count($itemId);
        } elseif ($CURRENT_SCHEMA >= SchemaType::HALF) {
            $nbOfBids = $link->I2589792665->get_count($itemId);
        } elseif ($CURRENT_SCHEMA >= SchemaType::RELATIONAL) {
            $nbOfBids = $link->bid_item->get_count($itemId);
        }
        }
    }

    printHTMLheader("RUBiS: Viewing ".$row["name"]);
    printHTMLHighlighted($row["name"]);
    print("<TABLE>\n".
          "<TR><TD>Currently<TD><b><BIG>$maxBid</BIG></b>\n");

    // Check if the reservePrice has been met (if any)
    $reservePrice = $row["reserve_price"];
    if ($reservePrice > 0) {
        if ($maxBid >= $reservePrice) {
            print("(The reserve price has been met)\n");
        } else {
            print("(The reserve price has NOT been met)\n");
        }
    }

    if ($CURRENT_SCHEMA == SchemaType::RELATIONAL) {
        if ($USE_CANNED) {
          $sellerNameRow = array ( 'nickname' => 'user243745', );
        } else {
          $sellerNameRow = $link->users->get($row["seller"], $column_slice=null, $column_names=array("nickname"));
        }
        $sellerName = $sellerNameRow["nickname"];
    } else {
        if ($USE_CANNED) {
          $sellerName = array ( 0 => 'user243745', );
        } else {
          $sellerName = array_values($link->I3318501374->get($row["seller"]));
        }
        $sellerName = $sellerName[0];
    }

    print("<TR><TD>Quantity<TD><b><BIG>".$row["quantity"]."</BIG></b>\n");
    print("<TR><TD>First bid<TD><b><BIG>$firstBid</BIG></b>\n");
    print("<TR><TD># of bids<TD><b><BIG>$nbOfBids</BIG></b> (<a href=\"/PHP/ViewBidHistory.php?itemId=".$itemId."\">bid history</a>)\n");
    print("<TR><TD>Seller<TD><a href=\"/PHP/ViewUserInfo.php?userId=".$row["seller"]."\">$sellerName</a> (<a href=\"/PHP/PutCommentAuth.php?to=".$row["seller"]."&itemId=".$itemId."\">Leave a comment on this user</a>)\n");
    print("<TR><TD>Started<TD>".$row["start_date"]."\n");
    print("<TR><TD>Ends<TD>".$row["end_date"]."\n");
    print("</TABLE>\n");

    // Can the user by this item now ?
    if ($buyNow > 0)
    print("<p><a href=\"/PHP/BuyNowAuth.php?itemId=".$itemId."\">".
              "<IMG SRC=\"/PHP/buy_it_now.jpg\" height=22 width=150></a>".
              "  <BIG><b>You can buy this item right now for only \$$buyNow</b></BIG><br><p>\n");

    print("<a href=\"/PHP/PutBidAuth.php?itemId=".$itemId."\"><IMG SRC=\"/PHP/bid_now.jpg\" height=22 width=90> on this item</a>\n");

    printHTMLHighlighted("Item description");
    print($row["description"]);
    print("<br><p>\n");

    $link->close();

    printHTMLfooter($scriptName, $startTime);
    ?>
  </body>
</html>
