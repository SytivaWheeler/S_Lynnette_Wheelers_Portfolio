<?php
        require("watchmode_trans.php");
        require("IMDB_api_trans.php");
        require("DBConn.php");

        if (isset($_SESSION['username'])) {

            $username = $_SESSION['username'];

            try {
                #SQL Query to Database. Assign number of rows to rownum
                $sth = $dbh->prepare('SELECT * FROM user_profiles where username= ?');
                $sth->execute([$username]);

                $result = $sth->fetchAll();

                # String to hold all users preferred genres
                $genre_string = "";

                foreach ($result as $row) {
                    $genre_string .= '%2C';
                    $genre_string .= $row['genre_id'];
                }

                # Remove initial %2C separator
                $genre_string = substr($genre_string, 3);
                
                # Get movies based on genres
                $titles = pop_homepage($genre_string);
                $titles = $titles['titles'];

                # Populate each movie card with movie details from pop_homepage
                foreach ($titles as $key1 => $value1) {
        
                    /*	 
		                Use if other api (IMDB API) calls run out and pictures/ plot details stop appearing for movies
                        To switch from IMDB to Watchmode:
		                    Replace $details = get_details($titles[$key1]['imdb_id']); with $details = wtch_get_details($titles[$key1]['imdb_id']);  
		                    replace $details['image'] with $details['poster']
                        To switch the other direction, do the opposite.
	                */
                    $details = wtch_get_details($titles[$key1]['imdb_id']);

                    echo '<div class = "card" style="width: 18rem;">
                        <img class="card-img-top" src= "' . $details['poster'] . '" alt = "img">
                        <div class="card-body">
                            <h1 class = "titles"> ' . $titles[$key1]['title'] . '</h1>
                            <form action="../include_files/insert_list.php" method="POST">
                            <button type="submit" class= "btn btn-primary" name="favbtn" value="' . $titles[$key1]['imdb_id'] . '"> Favorite</button>
                            <button type="submit" class= "btn btn-primary" name="watchbtn" value="' . $titles[$key1]['imdb_id'] . '"> Watch List</button>
                            </form>
                        </div>
                        </div>';
                }

            } catch (PDOException $e) {
                echo 'An error has occured. Please try again later';
            }
        } else {
            header("Location:../pages/sign_in_page.php");
        }
