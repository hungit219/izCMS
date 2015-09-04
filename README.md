###TOOL
#### Atom
#### emmet package (html, css)
* Ho so : xa

CMND : xa

* Bang cap 3: xa

* So ho khau: xa

Giay kham suc khoe


###Create database & table
```sql
CREATE DATABASE db;
USE db;
CREATE TABLE tb(
     filed1 INT unsigned
        NOT NULL auto_increment,
     filedn ...,
     PRIMARY KEY (filed1),
     index(...);
     index(...)
);
```
###Insert
```sql
INSERT INTO table VALUES (NULL,vl1,vl2);
INSERT INTO table (clm1,clm2) VALUES (vl1,vl2), (vl3,vl4);
```
###Select
```sql
SELECT * FROM tb;
SELECT (a.f1, a.f2) FROM tb AS a
SELECT (cl1 AS 'x',cl2 AS 'y',...) FROM tb;
  WHERE (filed1 = 'value1'); [AND OR]
  ORDER BY field1 DESC|ASC LIMIT 1,2
```
###Select Inner Join
```sql
SELECT tb1.f1, tb2.f1,tb2.f2, tb3.f1, tb4.f1
FROM tb1 INNER JOIN tb2 USING tb?.id
INNER JOIN tb3 USING tb?.id
INNER JOIN tb4 USING tb?.id;
```
###FUNCTION
```sql
concat(f1,f2,...), concat_ws(' - ',...)
date_format(...)
left(f,n), right
upper(f)
```
###Update
UPDATE tb SET f = value WHERE f_id = value LIMIT 1
##Delete
DELETE FROM tb WHERE f_id = value LIMIT 1
