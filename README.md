# Silex rest simplex application

A simple silex skeleton application for writing RESTful API. Developed and maintained by [Christophe Soares](http://homepage.ufp.pt/~csoares).

**This project may be reused to write a REST api with Silex PHP micro-framework**

#### How do I run it?
After download the last [version](https://github.com/csoares/silexrest_template), from the root folder of the project, run the following command to install the php dependencies, and import some data to your mysql.
You may reused the vagrant configuration provided [here](https://github.com/csoares/vagrant-php7) to obtain a Linux virtual machine with PHP 7.0+MySQL.

```
sh EXECUTE_ME_FIRST.sh
```

#### What you will get
The api will respond to
```
*SELECT
GET -> curl -X GET -i http://api.dev/getbooks/{offset}/{limit} (default: 0 - offset || 10 - limit)
GET -> curl -X GET -i http://api.dev/obtain/{id}
POST -> curl -X POST -i http://api.dev/obtain/{id}
GET -> curl -X GET http://api.dev/books/{format}/{id} (id and format are optional)

*INSERT
POST -> curl -X POST -H "Content-Type: application/json" -d '{"title":"My New Book","author":"Douglas","isbn":"111-11-1111-111-1"}' -i http://api.dev/book

*UPDATE
PUT -> curl -X PUT -H "Content-Type: application/json" -d '{"title":"PHP2","author":"Douglas","isbn":"111-11-1111-111-1"}' -i http://api.dev/bookedit/6

*DELETE
DELETE -> curl -X DELETE -i http://api.dev/bookdel/{id}
```



#### Author


* [Twitter](https://twitter.com/soareschris)

* [Homepage](http://homepage.ufp.pt/~csoares)

* [Contact me](mailto:csoares@ufp.edu.pt)



