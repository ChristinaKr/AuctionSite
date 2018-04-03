DELETE FROM oso_user_ratings;
INSERT INTO oso_user_ratings (user_id, item_id, rating)
  SELECT
    View.UserID,
    View.ItemID,
    View.Count / maxView.MaxView
  FROM View
    LEFT JOIN (SELECT
                 View.UserID,
                 MAX(Count) AS MaxView
               FROM View
               GROUP BY View.UserID) maxView ON View.UserID = maxView.UserId;