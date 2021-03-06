
DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users (
    "id" integer GENERATED BY DEFAULT AS IDENTITY PRIMARY KEY,
    "username" character varying(100),
    "pass" character varying(256),
    "age" integer
);

REVOKE ALL ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO facebook_user;

REVOKE ALL ON users FROM public;
GRANT ALL ON users TO facebook_user;