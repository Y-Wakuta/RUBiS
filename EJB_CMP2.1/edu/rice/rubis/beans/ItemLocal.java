package edu.rice.rubis.beans;

import javax.ejb.*;
import java.rmi.*;
import java.util.Collection;

/**
 * This is the Local Interface of the Item Bean.
 * @author <a href="mailto:cecchet@rice.edu">Emmanuel Cecchet</a> and <a href="mailto:julie.marguerite@inrialpes.fr">Julie Marguerite</a>
 * @version 1.1
 */
public interface ItemLocal extends EJBLocalObject {
  /**
   * Get item id.
   *
   * @return item id
   * @since 1.0
   */
  public Integer getId();

  /**
   * Get item name. This description is usually a short description of the item.
   *
   * @return item name
   * @since 1.0
   */
  public String getName();

  /**
   * Get item description . This is usually an HTML file describing the item.
   *
   * @return item description
   * @since 1.0
   */
  public String getDescription();

  /**
   * Get item initial price set by the seller.
   *
   * @return item initial price
   * @since 1.0
   */
  public float getInitialPrice();

  /**
   * Get how many of this item are to be sold.
   *
   * @return item quantity
   * @since 1.0
   */
  public int getQuantity();

  /**
   * Get item reserve price set by the seller. The seller can refuse to sell if reserve price is not reached.
   *
   * @return item reserve price
   * @since 1.0
   */
  public float getReservePrice();

  /**
   * Get item Buy Now price set by the seller. A user can directly by the item at this price (no auction).
   *
   * @return item Buy Now price
   * @since 1.0
   */
  public float getBuyNow();

  /**
   * Get item maximum bid (if any) for this item. This value should be the same as doing <pre>SELECT MAX(bid) FROM bids WHERE item_id=?</pre>
   *
   * @return current maximum bid or 0 if no bid
   * @since 1.1
   */
  public float getMaxBid();

  /**
   * Get number of bids for this item. This value should be the same as doing <pre>SELECT COUNT(*) FROM bids WHERE item_id=?</pre>
   *
   * @return number of bids
   * @since 1.1
   */
  public int getNbOfBids();

  /**
   * Start date of the auction in the format 'YYYY-MM-DD hh:mm:ss'
   *
   * @return start date of the auction
   * @since 1.0
   */
  public String getStartDate();

  /**
   * End date of the auction in the format 'YYYY-MM-DD hh:mm:ss'
   *
   * @return end date of the auction
   * @since 1.0
   */
  public String getEndDate();

  /**
   * Give the seller of the item
   *
   * @return seller
   * @since 1.0
   */
  public UserLocal getSeller();

  /**
   * Give the category of the item
   *
   * @return item
   * @since 1.0
   */
  public CategoryLocal getCategory();

  /**
   * Get item bids.
   *
   * @return bids of the item
   */
  public Collection getBids();

  /**
   * Get item buyNows.
   *
   * @return buyNows of the item
   */
  public Collection getBuyNows();

  /**
   * Get item comments.
   *
   * @return comments of the item
   */
  public Collection getComments();

  /**
   * Get the seller's nickname by finding the Bean corresponding
   * to the user. 
   *
   * @return nickname
   * @since 1.0
   */
  public String getSellerNickname();

  /**
   * Get the category name by finding the Bean corresponding to the category Id.
   *
   * @return category name
   * @since 1.0
   */
  public String getCategoryName();


  /**
   * Set a new item name
   *
   * @param newName item name
   * @since 1.0
   */
  public void setName(String newName);

  /**
   * Set a new item description
   *
   * @param newDescription item description
   * @since 1.0
   */
  public void setDescription(String newDescription);

  /**
   * Set a new initial price for the item
   *
   * @param newInitialPrice item initial price
   * @since 1.0
   */
  public void setInitialPrice(float newInitialPrice);

  /**
   * Set a new item quantity
   *
   * @param qty item quantity
   * @since 1.0
   */
  public void setQuantity(int qty);

  /**
   * Set a new reserve price for the item
   *
   * @param newReservePrice item reserve price
   * @since 1.0
   */
  public void setReservePrice(float newReservePrice);

  /**
   * Set a new Buy Now price for the item
   *
   * @param newBuyNow item Buy Now price
   * @since 1.0
   */
  public void setBuyNow(float newBuyNow);

  /**
   * Set item maximum bid
   *
   * @param newMaxBid new maximum bid
   * @since 1.1
   */
  public void setMaxBid(float newMaxBid);

  /**
   * Set the number of bids for this item
   *
   * @param newNbOfBids new number of bids
   * @since 1.1
   */
  public void setNbOfBids(int newNbOfBids);

  /**
   * Add one bid for this item
   *
   * @exception RemoteException if an error occurs
   * @since 1.1
   */
  public void addOneBid();

  /**
   * Set a new beginning date for the auction
   *
   * @param newDate auction new beginning date
   * @since 1.0
   */
  public void setStartDate(String newDate);

  /**
   * Set a new ending date for the auction
   *
   * @param newDate auction new ending date
   * @since 1.0
   */
  public void setEndDate(String newDate);

  /**
   * Set a new seller.
   *
   * @param seller seller
   * @since 1.0
   */
  public void setSeller(UserLocal seller);

  /**
   * Set a new category.
   *
   * @param category category
   * @since 1.0
   */
  public void setCategory(CategoryLocal category);

  /**
   * Display item information as an HTML table row
   *
   * @return a <code>String</code> containing HTML code
   * @since 1.0
   */
  public String printItem();

  /**
   * Display item information for the AboutMe servlet
   *
   * @return a <code>String</code> containing HTML code
   * @since 1.0
   */
  public String printUserBoughtItem(int qty);

  /**
   * Display item information for the AboutMe servlet
   *
   * @return a <code>String</code> containing HTML code (Warning last link must be completed by servlet)
   * @since 1.0
   */
  public String printItemUserHasBidOn(float bidMaxBid);

  /**
   * Display item information as an HTML table row
   *
   * @return a <code>String</code> containing HTML code
   * @since 1.0
   */
  public String printSell();

  /**
   * Display item information for the AboutMe servlet
   *
   * @return a <code>String</code> containing HTML code
   * @since 1.0
   */
  public String printUserWonItem();

  /**
   * Display item information for the Buy Now servlet
   *
   * @return a <code>String</code> containing HTML code
   * @since 1.0
   */
  public String printItemDescriptionToBuyNow(int userId);

 /** 
   * Call the corresponding ejbSelect method.
   */
  public Collection getQtyMaxBid(int maxToCollect) throws FinderException;

 /** 
   * Call the corresponding ejbSelect method.
   */
  public Collection getBidHistory() throws FinderException;


}
