-- 1. Add the column (if not already added)
ALTER TABLE geo_data
ADD COLUMN coordinates_count INT(11) DEFAULT NULL;

-- 2. Update column with coordinate counts
UPDATE geo_data
SET coordinates_count = JSON_LENGTH(coordinates);

-- 3. Make column NOT NULL
ALTER TABLE geo_data
MODIFY COLUMN coordinates_count INT(11) NOT NULL;
