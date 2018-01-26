<?php 
  if ( !isset($_GET["id"]) ) {
    header('Content-Type: application/json');

    $ratings_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json");
    $ratings_data = json_decode($ratings_data_string, true);
    $ratings = $ratings_data["ratings"];

    $ratings_json = '{"ratings":' . json_encode($ratings) . '}';
    echo $ratings_json;
  }
  else if ( empty( $_GET["id"]) ) {
    http_response_code(400);
  }
  else if ( isset($_GET["id"]) && !empty($_GET["id"]) ) {
    header('Content-Type: application/json');
    
    $rating_id = $_GET["id"];
    $rating = NULL;

    $ratings_data_string = file_get_contents("/home/dh_gnk2re/fandor.ggproto.com/files/json/ratings.json");
    $ratings_data = json_decode($ratings_data_string, true);
    $ratings = $ratings_data["ratings"];
    
    // find the rating that specific rating from the request
    foreach($ratings as $r) {
      if ($rating_id == $r["id"]) {
        $rating = $r;
        break;
      }
    }

    // json encode the arrays
    $rating_json = '{"ratings":[' . json_encode($rating) . ']}';
    echo $rating_json;
  }
?>
