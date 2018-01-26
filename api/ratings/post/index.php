<?php 
if ( ( isset($_GET["films_id"]) && !empty($_GET["films_id"]) ) && ( isset($_GET["users_id"]) && !empty($_GET["users_id"]) ) && ( isset($_GET["rating"]) && !empty($_GET["rating"]) ) ) {
  header('Content-Type: application/json');
  
  $films_id = $_GET["films_id"];
  $users_id = $_GET["users_id"];
  $rating = $_GET["rating"];
  
  $ratings_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json");
  $ratings_data = json_decode($ratings_data_string, true);
  $ratings = $ratings_data["ratings"]; 

  $number_of_ratings = count($ratings);
  
  if ($number_of_ratings != NULL && $number_of_ratings > 0) {
    $new_rating_id = ++$number_of_ratings;
  }
  else {
    $new_rating_id = 1;
  }
  
  $new_rating = array();

  $new_rating["id"] = $new_rating_id;
  $new_rating["films_id"] = intval($films_id);
  $new_rating["users_id"] = intval($users_id);
  $new_rating["rating"] = intval($rating);

  array_push($ratings, $new_rating);

  // delete the file before we write to it, so we don't duplicate data
  unlink("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json");
  
  $ratings_json = '{"ratings":' . json_encode($ratings) . '}';

  // save all the ratings in the json file
  file_put_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json", $ratings_json);
  
  $ratings_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json");
  $ratings_data = json_decode($ratings_data_string, true);
  $ratings = $ratings_data["ratings"];   
  
  // Resave the $ratings_json variable with the data that was saved to the json file
  $ratings_json = '{"ratings":' . json_encode($ratings) . '}';
  echo $ratings_json;
}
?>
