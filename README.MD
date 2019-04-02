This is back-end
===
**Front-end domain:** https://f-imhio.geekhare.me
*repository:* https://github.com/GeekHare/imhio-frontend

**Back-end domain:** https://b-imhio.geekhare.me
*repository:* https://github.com/GeekHare/imhio-backend

Description
===

**Request format:** http://{domain}/{object_name}/{method}/{args}

Endpoint "Check email"
===

Request:
---
url: {domain}/email/check
method: POST
body:
```json
{
  "email": "test@domain.com"
}
```
Response:
---
**Email valid**
```json
{
  "validation":true, "code":200
}
```
**Email invalid**
```json
{
  "err":"EMAIL_BAD", "code":200
}
```
**Email required**
```json
{
  "err":"EMAIL_REQUIRED", "code":400
}
```
Generate documentation (phpDocumentor):
---
```bash
./vendor/phpdocumentor/phpdocumentor/bin/phpdoc -d ./ -t ./phpdoc/ --ignore ".apache/,.nginx/,node_modules/,vendor/,phpdoc/"
```
Run tests (PHPUnit):
---
```bash
 ./vendor/phpunit/phpunit/phpunit
```
How to create new endpoint:
---
1. Create new file (php class) in folder Api/objects/
2. Declare new route in file config.php and set allowed methods