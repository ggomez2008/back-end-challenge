<?php
  if ( !isset($_GET["id"]) ) {
    header('Content-Type: application/json');

    $films_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/films.json");
    $films_data = json_decode($films_data_string, true);
    
    $films = $films_data["films"];
    
    $counter = 0;
    
    foreach ( $films as $f ) {
      // find all the ratings for each film
      $ratings_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json");
      $ratings_data = json_decode($ratings_data_string, true);
      $ratings = $ratings_data["ratings"];    
      
      $average_film_rating = NULL;
      $sum_of_ratings_for_the_film = NULL;
      $number_of_ratings_for_the_film = NULL;      
      
      $ratings_ids = array();
      
      foreach ( $ratings as $r ) {
        // if the primary key from the film object matches the foreign key of ratings object, 
        // then add the value to the sum of ratings and increment the number of ratings for the films
        // so we can calculate the average rating for the film
        if ( $r["films_id"] == $f["id"] ) {
          if ($sum_of_ratings_for_the_film == NULL) {
            $sum_of_ratings_for_the_film = 0;
          }
          
          $rating_id = $r["id"];
          
          array_push($ratings_ids, $rating_id);
          
          ++$number_of_ratings_for_the_film;
          
          $sum_of_ratings_for_the_film = $sum_of_ratings_for_the_film + $r["rating"];
        }
      }  
      
      if ( $sum_of_ratings_for_the_film != NULL && $number_of_ratings_for_the_film != NULL ) {
        $average_film_rating = ( $sum_of_ratings_for_the_film / $number_of_ratings_for_the_film );
      }
      
      $f["ratings_ids"] = $ratings_ids;
      $f["average_rating"] = $average_film_rating;
      
      $films[$counter]["average_rating"] = $f["average_rating"];
      $films[$counter]["ratings_ids"] = $f["ratings_ids"];
      
      ++$counter;
    }  
    
    $films_json = '{"films":' . json_encode($films) . '}';
    echo $films_json;
  }
  else if ( empty($_GET["id"]) ) {
    http_response_code(400);
  }
  else if ( isset($_GET["id"]) && !empty($_GET["id"]) ) {
    header('Content-Type: application/json');

    $film = NULL;
    
    $film_id = $_GET["id"];

    $films_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/films.json");
    $films_data = json_decode($films_data_string, true);

    $films = $films_data["films"];

    $count = count($films);

    foreach ( $films as $f ) {
      if ( $f["id"] == $film_id ) {
        $film = $f;
        break;
      }
    }
    
    // find all the ratings for this film
    $ratings_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json");
    $ratings_data = json_decode($ratings_data_string, true);

    $ratings = $ratings_data["ratings"];    
    
    $average_film_rating = NULL;
    $sum_of_ratings_for_the_film = NULL;
    $number_of_ratings_for_the_film = NULL;    
    
    $ratings_ids = array();
    
    foreach ( $ratings as $r ) {
      // if the primary key from the film object matches the foreign key of ratings object, 
      // then add the value to the sum of ratings and increment the number of ratings for the films
      // so we can calculate the average rating for the film
      if ( $r["films_id"] == $film["id"] ) {
        if ($sum_of_ratings_for_the_film == NULL) {
          $sum_of_ratings_for_the_film = 0;
        }
        
        $rating_id = $r["id"];
        
        array_push($ratings_ids, $rating_id);
        
        ++$number_of_ratings_for_the_film;
        
        $sum_of_ratings_for_the_film = $sum_of_ratings_for_the_film + $r["rating"];
      }
    }
    
    $average_film_rating = ( $sum_of_ratings_for_the_film / $number_of_ratings_for_the_film );
    
    $film["average_rating"] = $average_film_rating;
    $film["ratings_ids"] = $ratings_ids;
    
    $film_json = '{"films":[' . json_encode($film) . ']}';
    echo $film_json;
  }
?>
