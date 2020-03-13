# Bike api

The Police want to be more efficient in resolving stolen bike cases. They decided to build a software that can automate their processes

## **Installation**

Make sure you have these requirements on your local machine please:
- PHP
- MySql
- Composer

You should **create two databases**, the second one is for the **test** purposes, define your main database connection config in `.env` file and the test database connection config in `phpunit.xml` file. 

Then follow below instruction:

- Install composer dependencies using `composer install`
- Copy the `.env.example` file to `.env`
- Define your secure `APP_KEY` in `.env` file
- Run `php artisan migrate` to create tables in your database
- Serve the app using `php -S localhost:8000 public/index.php` or any other port


## **Endpoints**
 
### Report new theft

- URL `/bikes`
- Method `POST`
- Params
    - licence_number `[ required | [10] integer ]`
    - type `[ required | string ]`
    - color `[ required | string ]`
    - owner `[ required | string ]`
    - theft_at `[ required | date ]`
    - description `[ optional | string ]`
- Success response

    If the system tries to assign your report to an idle officer, if the officer exists, the officer will be an object, otherwise it will be `null`
    - Status code `201`
    - Content 
    ```json
    {
      "id": 1,
      "licence_number": 1234567890,
      "type": "x",
      "color": "x",
      "theft_at": "xxxx-xx-xx",
      "description": "xxxx",
      "officer": {
        "id": 1,
        "name": "john"
      }
    }
    ```

- Error response
  - Status code `500`
  ```json
      {
        "message": "something went wrong"
      }
  ```


    
### Get list of stolen bikes

- URL `/bikes`
- Method `GET`
- Url Params (for filtering purposes)
    - color `[ string ]`
    - owner `[ string ]`
    - type `[ string ]`
    - theft_at `[ date ]`
    - licence_number `[ [10] integer ]`
- Success response

    - Status code `200`
    - Content 
    ```json
    {
        "current_page": 1,
        "data": [
            {
                "id": 21,
                "licence_number": 9212127202,
                "type": "a",
                "color": "red",
                "owner": "pretty",
                "description": "DF",
                "theft_at": "2020-02-02",
                "found": false
            },
            {
                "id": 20,
                "licence_number": 9212127222,
                "type": "a",
                "color": "red",
                "owner": "pretty",
                "description": "DF",
                "theft_at": "2020-02-02",
                "found": false
            }
        ],
        "first_page_url": "/bikes?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "/bikes?page=1",
        "next_page_url": null,
        "path": "/bikes",
        "per_page": 20,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
    ```

    
### Get specific bike 

- URL `/bikes/:id`
- Method `GET`
- Success response

    If there is no officer related to the bike, officer will be `null`

    - Status code `200`
    - Content 
    ```json
    {
        "id": 21,
        "licence_number": 9212127202,
        "type": "a",
        "color": "red",
        "owner": "pretty",
        "description": "DF",
        "theft_at": "2020-02-02",
        "found": false,
        "officer": {
            "id": 1,
            "name": "ali"
        }
    }
    ```

 
### Resolve a bike

- URL `/bikes/:id`
- Method `PATCH`

- Success response
    - Status code `204`

- Error response
  - Status code `500`
  ```json
      {
        "message": "something went wrong"
      }
  ```

### Add new officer

- URL `/officers`
- Method `POST`
- Params
    - name `[ required | string ]`
- Success response

    The system tries to assign a stolen bike to the officer, if the bike exists, the officer will be responsible of bike, and the bike will be object, otherwise the bike will be `null`
    - Status code `201`
    - Content 
    ```json
    {
      "id": 1,
      "name": "xx",
      "bike": {
        "id": 1,
        "licence_number": 1234567890,
        "type": "x",
        "color": "x",
        "theft_at": "xxxx-xx-xx",
        "description": "xxxx",
        "found": false
      }
    }
    ```

- Error response
  - Status code `500`
  ```json
      {
        "message": "something went wrong"
      }
  ```


### Remove an officer

- URL `/officers/:id`
- Method `DELETE`

- Success response
    - Status code `204`

- Error response
  - Status code `500`
  ```json
      {
        "message": "something went wrong"
      }
  ```


## **Roles/Requirements**

- Bike owners can report a stolen bike.
- A bike can have multiple characteristics: license number, color, type, full name of the owner, date, and description of the theft.
- The Police can increase or decrease the number of police officers.
- Each police officer should be able to search bikes by different characteristics in a database and see which police officer is responsible for a stolen bike case.
- New stolen bike cases should be automatically assigned to any free police officer.
- A police officer can only handle one stolen bike case at a time.
- When the Police find a bike, the case is marked as resolved and the responsible police officer becomes available to take a new stolen bike case.
- The system should be able to assign unassigned stolen bike cases automatically when a police officer becomes available.

- Scope

  - API Development (BP)
  - Transaction (CC)
  - Audit log
  - Unit / Integration

- Extra

  - publish client package (part of release)
  - stub
  - clean architecture
