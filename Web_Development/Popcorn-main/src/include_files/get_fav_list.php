<?php
require("DBConn.php");
require("IMDB_api_trans.php");
require("watchmode_trans.php");

if (isset($_SESSION['username'])) {

    $username = $_SESSION['username'];

    try {
        #SQL Query to Database
        $sth = $dbh->prepare('SELECT * FROM fav_list where username= ?');
        $sth->execute([$username]);

        $result = $sth->fetchAll();

        # Get row count
        $rownum = count($result);

        if ($rownum < 1) {
            echo '<h2>No favorites yet!</h2> <h3>Try adding some movies to your favorites list first!</h3>';
        } else {
            #Echo html to the page with title info in proper places.

            echo '<div class=fav_table> <table class="table table-bordered"><tbody>';

            /*	 
		    Use if other api (IMDB API) calls run out and pictures/ plot details stop appearing for movies
            To switch from IMDB to Watchmode:
			    Replace $json = get_details($row['movie_id']); with $json = wtch_get_details($row['movie_id']);  
			    Replace $json['image'] with $json['poster']
		    To switch the other direction, do the opposite.
            Use the imdb api to get plot details if they dont show using watchmodes (plot_overview instead of plot when using watchmode)
	        */
            foreach ($result as $row) {
                
                $json = wtch_get_details($row['movie_id']);
                $imdbjson = get_details($row['movie_id']);
                echo
                '<tr>' .
                    '<td>' .
                        '<div class="table-cell d-flex align-items-center">
                            <img class="poster" src="' . $json['poster'] . '"
                            style= "width: 145px; height: 145px"/>
                        </div>
                    </td>
                    <td>
                        <div class= "ms-3">
                            <p class= "title fw-bold mb-1">' . $json['title'] . '</p>
                            <p class="plot text-warning mb-0">' . $imdbjson['plot']  . '</p>
                            <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#linkModal" value="'. $row['movie_id'].'">
                                Where can I watch?
                            </button>
                        </div>
                    </td>
                    <td>
                        <form class="del-button" action="../../include_files/del_fav_list.php" method="post">
                            <button class="btn btn-link btn-sm btn-rounded" type="submit" name="del_button" value= "' . $row['movie_id'] . '" >
                                Delete from favorites list
                            </button>
                        </form>
                    </td>
                </tr>';
            }

            echo '</tbody></table></div>';
        }
    } catch (PDOException $e) {
        echo 'An error has occured. Please try again later';
    }
} else {
    header("Location:../pages/sign_in_page.php");
}
