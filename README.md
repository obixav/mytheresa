## Instruction

- To Run the project, clone the project with

```
git clone https://github.com/obixav/mytheresa.git
```
- Inside the project folder run this in your bash terminal

```
bash setup-container.sh
```
- As a fall back if this fails you may manually run the commands which are domiciled in the setup-container.sh file
```

docker-compose up -d --build

# Run Composer install
docker-compose exec php composer install

# create .env file
docker-compose exec php cp .env.example .env

# generate application key
docker-compose exec php php artisan key:generate

# Run Migration and Seed
docker-compose exec php php artisan migrate --seed

```
  
- To Run Test, after installation,in your bash terminal run 
```
docker-compose exec php php artisan test
```

- Access the application via the URL 
```
http://localhost:8080/products
```
- You may run other query parameters too


## Reasons for Decision

- I used the Laravel Framework as I have experience using it and it is a great framework for writing APIs. It has the API Resource feature which I used to implement the business logic.

- I used MYSQL because I am comfortable with the RDBMS. It is also great when using the laravel eloquent ORM which I used to model the product and category data.

- I used Docker because it is a tool that allows you to write your code and run on any machine.


