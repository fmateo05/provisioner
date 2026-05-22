```sql
COPY models(brand,family,model) FROM '/var/lib/postgresql/brand_family_model.csv' DELIMITER ','
CSV HEADER;
```
