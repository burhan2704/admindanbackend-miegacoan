drop table gms_products;
drop table gms_boms;
drop table gms_bom_details;

CREATE SEQUENCE gms_products_id_seq;
CREATE TABLE gms_products (
    id bigint NOT NULL DEFAULT nextval('gms_products_id_seq'),
    prd_code varchar,
    prd_desc varchar,
    type_desc varchar,
    uom_desc varchar,
    sales_price decimal(20,4) default 0,
    qoh decimal(20,4) default 0,
    is_active boolean default true,
    created_at timestamp without time zone,
	updated_at timestamp without time zone,
	created_by bigint,
	updated_by bigint,
	deleted_by bigint,
    deleted_at timestamp without time zone

);
ALTER SEQUENCE gms_products_id_seq OWNED BY gms_products.id;


CREATE SEQUENCE gms_boms_id_seq;
CREATE TABLE gms_boms (
    id bigint NOT NULL DEFAULT nextval('gms_boms_id_seq'),
    bom_code varchar,
    bom_desc varchar,
    prd_id bigint,
    is_active boolean default true,
    created_at timestamp without time zone,
	updated_at timestamp without time zone,
	created_by bigint,
	updated_by bigint,
	deleted_by bigint,
    deleted_at timestamp without time zone

);
ALTER SEQUENCE gms_boms_id_seq OWNED BY gms_boms.id;


CREATE SEQUENCE gms_bom_details_id_seq;
CREATE TABLE gms_bom_details (
    id bigint NOT NULL DEFAULT nextval('gms_bom_details_id_seq'),
    bom_id bigint,
    rm_id bigint,
    qty decimal(20,4) default 0,
    created_at timestamp without time zone,
	updated_at timestamp without time zone,
	created_by bigint,
	updated_by bigint,
    deleted_at timestamp without time zone

);
ALTER SEQUENCE gms_bom_details_id_seq OWNED BY gms_bom_details.id;



CREATE SEQUENCE gms_pos_id_seq;
CREATE TABLE gms_pos (
    id bigint NOT NULL DEFAULT nextval('gms_pos_id_seq'),
    trans_no varchar,
    trans_date date,
    store_name varchar,
    shift_name varchar,
    station_name varchar,
    beginning_amount decimal(20,4) default 0,
    ending_amount decimal(20,4) default 0,
    total_payment decimal(20,4) default 0,
    trans_status bigint default 1,
    seat_no varchar,
    cust_name varchar,
    created_at timestamp without time zone,
	updated_at timestamp without time zone,
	created_by bigint,
	updated_by bigint,
	deleted_by bigint,
    deleted_at timestamp without time zone

);
ALTER SEQUENCE gms_pos_id_seq OWNED BY gms_pos.id;


CREATE SEQUENCE gms_pos_details_id_seq;
CREATE TABLE gms_pos_details (
    id bigint NOT NULL DEFAULT nextval('gms_pos_details_id_seq'),
    trans_id bigint,
    prd_id bigint,
    qty decimal(20,4) default 0,
    price decimal(20,4) default 0,
    sub_total decimal(20,4) default 0,
    created_at timestamp without time zone,
	updated_at timestamp without time zone,
	created_by bigint,
	updated_by bigint,
    deleted_at timestamp without time zone

);
ALTER SEQUENCE gms_pos_details_id_seq OWNED BY gms_pos_details.id;

