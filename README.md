# back-end-challenge
My solution for the back-end challenge.

API URL: http://fandor.ggproto.com/api/

Films:

You can retrieve a collection of JSON objects or a single JSON object.

The objects contain information about the film, such as film id, average rating, title, etc.

To return all films, you would send a GET request to: http://fandor.ggproto.com/api/films/get/. 

To return just a single film, you would pass the ID of the film as a query string parameter to: http://fandor.ggproto.com/api/films/get/.

For example: http://http://fandor.ggproto.com/api/films/get/?id=3


Ratings:

You can retrieve a collection of JSON objects or a single JSON object.

The objects contain information about the rating, such as who submiited the rating (users_id), which film the rating is for (films_id), and the actual rating (rating).

You can also rate a particular film by passing three query string parameters with values to: http://fandor.ggproto.com/api/ratings/post/.

They are:

1) users_id 
2) films_id
3) rating

For example:
http://fandor.ggproto.com/api/ratings/post/?users_id=1&films_id=3&rating=5
