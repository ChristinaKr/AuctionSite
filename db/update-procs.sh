#!/usr/bin/env bash
# setup the database
mysql -u root -p ebay < proc_files/Admin_proc.sql;
mysql -u root -p ebay < proc_files/Bid_proc.sql;
mysql -u root -p ebay < proc_files/Category_proc.sql;
mysql -u root -p ebay < proc_files/Feedback_proc.sql;
mysql -u root -p ebay < proc_files/Item_proc.sql;
mysql -u root -p ebay < proc_files/ItemCategory_proc.sql;
mysql -u root -p ebay < proc_files/Recommendation_proc.sql;
mysql -u root -p ebay < proc_files/User_proc.sql;
mysql -u root -p ebay < proc_files/View_proc.sql;
mysql -u root -p ebay < proc_files/Watch_proc.sql;
