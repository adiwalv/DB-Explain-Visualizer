## Installation
> ### Prerequisites:
> 1. Install Node from https://nodejs.org/en/download/
> 2. Install php and apache server.
> 3. Install mongo php driver from https://docs.mongodb.com/ecosystem/drivers/php/

### Sample DB

I have included a sample DB for testing.
You can import it using :

```bash
mongoimport -v --file=sample_db/zips.json
```
This will create a Database named 'test' and using that db it will fill up collection 'zips'. Now you can fire up these commands below to parse Query Plan. For example:
```bash
mongo localhost/test --eval "db.zips.find().limit(10).explain('allPlansExecution')" > test.json
```


# Screenshots

## Homepage

![alt text](src/screenshots/h.png "Homepage")

## Create a .json file for your database query. Press ? on the homepage

![alt text](src/screenshots/he.png "File")

## Explain a custom query

![alt text](src/screenshots/te.png "Custom Query")

## Result of Explain

![alt text](src/screenshots/qu.png "Detailed Results")
