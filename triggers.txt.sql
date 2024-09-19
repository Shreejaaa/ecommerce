-- Drop sequences if they exist
DROP SEQUENCE cart_id_seq;
DROP SEQUENCE product_category_seq;
DROP SEQUENCE review_id_seq;
DROP SEQUENCE product_id_seq;
DROP SEQUENCE users_seq;
DROP SEQUENCE shop_seq;
DROP SEQUENCE cart_item_id_seq;
DROP SEQUENCE wishlist_id_seq;
DROP SEQUENCE wishlist_item_id_seq;
DROP SEQUENCE discount_id_seq;
DROP SEQUENCE discount_product_id_seq;
DROP SEQUENCE order_id_seq;
DROP SEQUENCE payment_id_seq;
DROP SEQUENCE report_id_seq;
DROP SEQUENCE order_product_id_seq;
DROP SEQUENCE coll_slot_id_seq;
DROP SEQUENCE CART_SEQ;
/*DROP FUNCTION IF EXISTS validate_order_collection_slot() CASCADE;*/


-- Create sequences and triggers
CREATE SEQUENCE cart_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER cart_id_trigger
BEFORE INSERT ON CART FOR EACH ROW
BEGIN
    :NEW.CART_ID := cart_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE product_category_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER product_category_trigger
BEFORE INSERT ON PRODUCT_CATEGORY FOR EACH ROW
BEGIN
    :NEW.PROD_CATEGORY_ID := product_category_seq.NEXTVAL;
END;
/

CREATE SEQUENCE review_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER review_id_trigger
BEFORE INSERT ON REVIEW FOR EACH ROW
BEGIN
    :NEW.REVIEW_ID := review_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE product_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER product_id_trigger
BEFORE INSERT ON PRODUCT FOR EACH ROW
BEGIN
    :NEW.PRODUCT_ID := product_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE users_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER users_id_trigger
BEFORE INSERT ON USERS FOR EACH ROW
BEGIN
    :NEW.USER_ID := users_seq.NEXTVAL;
END;
/

CREATE SEQUENCE shop_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER shop_id_trigger
BEFORE INSERT ON SHOP FOR EACH ROW
BEGIN
    :NEW.SHOP_ID := shop_seq.NEXTVAL;
END;
/

CREATE SEQUENCE cart_item_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER cart_item_id_trigger
BEFORE INSERT ON CART_ITEM FOR EACH ROW
BEGIN
    :NEW.CART_ITEM_ID := cart_item_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE wishlist_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER wishlist_id_trigger
BEFORE INSERT ON WISHLIST FOR EACH ROW
BEGIN
    :NEW.WISHLIST_ID := wishlist_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE wishlist_item_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER wishlist_item_id_trigger
BEFORE INSERT ON WISHLIST_ITEM FOR EACH ROW
BEGIN
    :NEW.WISHLIST_ITEM_ID := wishlist_item_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE discount_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER discount_id_trigger
BEFORE INSERT ON DISCOUNT FOR EACH ROW
BEGIN
    :NEW.DISCOUNT_ID := discount_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE discount_product_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER discount_product_id_trigger
BEFORE INSERT ON DISCOUNT_PRODUCT FOR EACH ROW
BEGIN
    :NEW.DISCOUNT_PRODUCT_ID := discount_product_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE order_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER order_id_trigger
BEFORE INSERT ON ORDERS FOR EACH ROW
BEGIN
    :NEW.ORDER_ID := order_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE payment_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER payment_id_trigger
BEFORE INSERT ON PAYMENT FOR EACH ROW
BEGIN
    :NEW.PAYMENT_ID := payment_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE report_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER report_id_trigger
BEFORE INSERT ON REPORT FOR EACH ROW
BEGIN
    :NEW.REPORT_ID := report_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE order_product_id_seq START WITH 1 INCREMENT BY 1;
CREATE TRIGGER order_product_id_trigger
BEFORE INSERT ON ORDER_PRODUCT FOR EACH ROW
BEGIN
    :NEW.ORDER_PRODUCT_ID := order_product_id_seq.NEXTVAL;
END;
/

CREATE SEQUENCE coll_slot_id_seq START WITH 1 INCREMENT BY 1;
CREATE OR REPLACE TRIGGER coll_slot_id_trigger
BEFORE INSERT ON COLLECTION_SLOT
FOR EACH ROW
BEGIN
    :NEW.COLL_SLOT_ID := coll_slot_id_seq.NEXTVAL;
END;
/


-- Triggers for setting CREATED_ON and UPDATED_ON automatically
CREATE OR REPLACE TRIGGER users_insert_trigger
BEFORE INSERT ON USERS FOR EACH ROW
BEGIN
    :NEW.CREATED_DATE := SYSDATE;
    :NEW.UPDATED_DATE := SYSDATE;
END;
/

CREATE OR REPLACE TRIGGER shop_insert_trigger
BEFORE INSERT ON SHOP FOR EACH ROW
BEGIN
    :NEW.CREATED_ON := SYSDATE;
END;
/

CREATE OR REPLACE TRIGGER product_cat_insert_trigger
BEFORE INSERT ON PRODUCT_CATEGORY FOR EACH ROW
BEGIN
    :NEW.CREATED_ON := SYSDATE;
    :NEW.UPDATED_ON := SYSDATE;
END;
/

CREATE OR REPLACE TRIGGER cart_insert_trigger
BEFORE INSERT ON CART FOR EACH ROW
BEGIN
    :NEW.CREATED_ON := SYSDATE;
    :NEW.UPDATED_ON := SYSDATE;
END;
/

CREATE OR REPLACE TRIGGER wishlist_insert_trigger
BEFORE INSERT ON WISHLIST FOR EACH ROW
BEGIN
    :NEW.CREATED_ON := SYSDATE;
    :NEW.UPDATED_ON := SYSDATE;
END;
/

CREATE OR REPLACE TRIGGER discount_insert_trigger
BEFORE INSERT ON DISCOUNT FOR EACH ROW
BEGIN
    :NEW.CREATED_ON := SYSDATE;
    :NEW.UPDATED_ON := SYSDATE;
END;
/



CREATE SEQUENCE CART_SEQ START WITH 1 INCREMENT BY 1;
-- Create a trigger to automatically assign CART_ID and check the product count
CREATE OR REPLACE TRIGGER CART_TRIGGER
BEFORE INSERT ON CART
FOR EACH ROW
DECLARE
    product_count INT;
BEGIN
    -- Check the number of products in the cart
    SELECT COUNT(*) INTO product_count FROM CART WHERE USER_ID = :NEW.USER_ID;

    -- If the product count exceeds 20, raise an exception
    IF product_count >= 20 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Cart is full. Maximum 20 products allowed.');
    END IF;

    -- Assign the next value from the sequence to CART_ID
    :NEW.CART_ID := CART_ID_SEQ.NEXTVAL;
END;
/

/*-- Create the trigger function to validate the collection slot
CREATE OR REPLACE FUNCTION validate_order_collection_slot()
RETURNS TRIGGER AS $$
DECLARE
    order_count INT;
    order_time TIMESTAMP;
    collection_date DATE;
    slot_time VARCHAR2(10);
    slot_start_time TIMESTAMP;
    slot_end_time TIMESTAMP;
BEGIN
    -- Fetch the collection date and time details
    SELECT SLOT_DATE, TIME_DETAILS INTO collection_date, slot_time
    FROM COLLECTION_SLOT
    WHERE COLL_SLOT_ID = NEW.COLL_SLOT_ID;

    -- Determine the start and end time based on the slot time details
    IF slot_time = '10-13' THEN
        slot_start_time := collection_date + INTERVAL '10 hours';
        slot_end_time := collection_date + INTERVAL '13 hours';
    ELSIF slot_time = '13-16' THEN
        slot_start_time := collection_date + INTERVAL '13 hours';
        slot_end_time := collection_date + INTERVAL '16 hours';
    ELSIF slot_time = '16-19' THEN
        slot_start_time := collection_date + INTERVAL '16 hours';
        slot_end_time := collection_date + INTERVAL '19 hours';
    ELSE
        RAISE EXCEPTION 'Invalid collection slot time.';
    END IF;

    -- Ensure the collection day is Wednesday, Thursday, or Friday
    IF EXTRACT(DOW FROM collection_date) NOT IN (3, 4, 5) THEN
        RAISE EXCEPTION 'Collection day must be Wednesday, Thursday, or Friday.';
    END IF;

    -- Ensure the collection time is at least 24 hours after the order time
    order_time := NEW.ORDER_DATE_TIME;
    IF order_time + INTERVAL '24 hours' > slot_start_time THEN
        RAISE EXCEPTION 'Collection slot must be at least 24 hours after placing the order.';
    END IF;

    -- Ensure the slot is not already fully booked
    SELECT COUNT(*)
    INTO order_count
    FROM ORDERS
    WHERE COLL_SLOT_ID = NEW.COLL_SLOT_ID;

    IF order_count >= 20 THEN
        RAISE EXCEPTION 'Collection slot is fully booked.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create the trigger on the ORDERS table
CREATE TRIGGER validate_collection_slot
BEFORE INSERT ON ORDERS
FOR EACH ROW
EXECUTE FUNCTION validate_order_collection_slot();*/