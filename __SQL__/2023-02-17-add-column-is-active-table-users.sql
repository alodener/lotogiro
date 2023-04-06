ALTER TABLE users
ADD is_active boolean
default false;

UPDATE lotogiro2.users
SET is_active=1;

ALTER TABLE users
ADD contact_made boolean;

UPDATE lotogiro2.users
SET contact_made=0;
