# ourEdu_task
#how to run

create database edu_task

composer install

php artisan key:generate

php artisan migrate

php artisan serve



# i use repository design structure 

and api for insert and retrieve data 


#for cache data i use

"laragear/cache-query": "^3.0"

# Api
 
i use a magic filteration method index

you can filter with any column you need or order or 
limit or paginate i develop this algorithm to serve general use of any module


just add it at query params body at postman request

her is an example to filter with id bigger than 7

and limit to 2 with offset 1 

and order by id asc

and return all resource not just id with name 

and select paginate wihtout soft deleted items


{

"limit": 2,

"offset": 1,

"field": "id",

"sort": "ASC",

"resource": "all",

"deleted": "false",

"paginate":"true",

"columns": [
"id"
],

"operand": [
">"
],

"column_values": [
7
]

}
