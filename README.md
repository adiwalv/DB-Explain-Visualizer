## Installation
> ### Prerequisites:
> 1. Install Mongo from https://nodejs.org/en/download/
> 2. Install php and apache server.

### Sample DB

I have included a sample DB for testing.
You can import it using :

```bash
mongoimport -v --file=sample_db/zips.json
```
This will create a Database named 'test' and using that db it will fill up collection 'zips'. Now you can fire up these commands below to parse Query Plan. For example:
```bash
mongo localhost/test --eval "db.zips.find().limit(10).explain()" > test.json
```
