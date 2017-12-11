<?php
require_once __DIR__ . '/../vendor/autoload.php';

// namespaces
use Silex\Application;
use Silex\Provider\SerializerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


// create the app
$app = new Silex\Application();

// using for serialize data for xml and json format
$app->register(new SerializerServiceProvider());


// connect to mysql atabase
$dsn = 'mysql:dbname=booksdb;host=127.0.0.1;charset=utf8';
try {
    $dbh = new PDO($dsn, 'root', 'root');
} catch (PDOException $e) {
    die('Connection failed: ');
}

// defining routes
// first route - this is an example - you can here define the API
$app->get('/', function () use ($app, $dbh) {
    return new Response('Thank you for your feedback!', 200);
});


// SELECT
// e.g., curl -X GET -i http://api.test/obtain/1 OR curl -X POST -i http://api.dev/obtain/1
$app->match('/obtain/{id}', function ($id) use ($app, $dbh) {
    $sth = $dbh->prepare('SELECT id, title, author, isbn FROM books WHERE id=?');
    $sth->execute(array($id));

    $book = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($book)) {
        return $app->json(array("result"=>"inexistant book id - $id"));
    }

    return $app->json($book);
})
->method('GET|POST') // you can use get or post for this route
->value("id", 1) //set a default value
->assert('id', '\d+'); // verify that id is a digit



// e.g., curl -X GET http://api.test/books/xml/1 OR curl -X GET http://api.dev/books/json
$app->get("/books/{_format}/{offset}", function (Request $request, $offset) use ($app, $dbh) {
    $sth = $dbh->prepare('SELECT id, title, author, isbn FROM books LIMIT 10 OFFSET :offset');
    $sth->bindValue(":offset", (int) $offset , PDO::PARAM_INT);
    $sth->execute();
    $books = $sth->fetchAll(PDO::FETCH_ASSOC);

    $format = $request->getRequestFormat();
    return new Response($app['serializer']->serialize($books, $format), 200, array(
        "Content-Type" => $request->getMimeType($format)
    ));
})
->value("_format", "xml")
->assert("_format", "xml|json") // check if format is XML or JSON
->value("offset", 0) // define the default value for offset
->assert("offset", "\d+"); // verify that id is a digit

// e.g., curl -X GET -i http://api.test/getbooks/2/5
$app->get('/getbooks/{offset}/{limit}', function ($offset, $limit) use ($app, $dbh) {
    // get all the books
    /*
    TODO
    */

    return $app->json($books);
})
->value("offset",0)
->value("limit",10)
->assert('offset', '\d+')
->assert('limit', '\d+');


// INSERT
// e.g., curl -X POST -H "Content-Type: application/json" -d '{"title":"My New Book","author":"Douglas","isbn":"111-11-1111-111-1"}' -i http://api.test/book
$app->post('/book', function(Request $request) use ($app, $dbh) {
    $data = json_decode($request->getContent(), true); // load the received json data

    $sth = $dbh->prepare('INSERT INTO books (title, author, isbn)
            VALUES(:title, :author, :isbn)');

    $sth->execute($data);
    $id = $dbh->lastInsertId();

    // response, 201 created
    $response = new Response('Ok', 201);
    $response->headers->set('Location', "/book/$id");
    return $response;
});


// UPDATE


// e.g., curl -X PUT -H "Content-Type: application/json" -d '{"title":"PHP2","author":"Douglas","isbn":"111-11-1111-111-1"}' -i http://api.test/bookedit/6
$app->put('/bookedit/{id}', function(Request $request, $id) use ($app, $dbh) {
    $data = json_decode($request->getContent(), true);
    /*
    TODO
    */
    return $app->json($data, 200);
})->assert('id', '\d+'); // verify that id is a digit



// DELETE


// e.g., curl -X DELETE -i http://api.test/bookdel/6
$app->delete('/bookdel/{id}', function($id) use ($app, $dbh) {
  /*
  TODO
  */

    if($books < 1) {
        // this books id does not exists, return 404 with Inexistant book id - $id
        return new Response("Inexistant book id - $id", 404);
    }
    // this books has been removed, return 204 with no content
    return new Response(null, 204);
})
->assert('id', '\d+'); // verify that id is a digit


// enable debug mode - optional this could be commented
$app['debug'] = true;
// execute the app
$app->run();
