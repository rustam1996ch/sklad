<?php

use yii\db\Migration;

/**
 * Class m200310_123347_create_procedures
 */
class m200310_123347_create_procedures extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->execute("
        
            DROP FUNCTION IF EXISTS `getProductBalance`;
            
            CREATE DEFINER=`root`@`localhost` FUNCTION `getProductBalance`(productId INT UNSIGNED, date1 DATE, isDayOfEnd TINYINT) RETURNS int(11)
            BEGIN
                DECLARE res INT;
                SET isDayOfEnd = IFNULL(isDayOfEnd, 1);
                
                if isDayOfEnd = 1 then
                
                SET res = IFNULL((Select sum(receipt.amount) from receipt
                where receipt.product_id=productId and receipt.date <= date1), 0);
                
                SET res = res - IFNULL((Select sum(rasxod.amount) from rasxod
                left join sell on sell.id=rasxod.sell_id
                where rasxod.product_id=productId and sell.date <= date1), 0);
                
                else
                
                SET res = IFNULL((Select sum(receipt.amount) from receipt
                where receipt.product_id=productId and receipt.date < date1), 0);
                
                SET res = res - IFNULL((Select sum(rasxod.amount) from rasxod
                left join sell on sell.id=rasxod.sell_id
                where rasxod.product_id=productId and sell.date < date1), 0);
                
                end if;
                
                return res;
            END;
        
        ");

        $this->execute("
        
            DROP FUNCTION IF EXISTS `getProductPrixod`;
            
            CREATE DEFINER=`root`@`localhost` FUNCTION `getProductPrixod`(productId int, date1 date) RETURNS int(11)
            BEGIN
            
            RETURN ifnull((select (sum(receipt.amount))from receipt where receipt.product_id=productId and receipt.date = date1), 0);
            
            END;
        ");


        $this->execute("
        
            DROP FUNCTION IF EXISTS `getProductRasxod`;
            
            CREATE DEFINER=`root`@`localhost` FUNCTION `getProductRasxod`(productId int, date1 date) RETURNS int(11)
            BEGIN
            
            RETURN IFNULL(
                (
                    Select sum(rasxod.amount) from rasxod
                    left join sell on sell.id=rasxod.sell_id
                    where
                        rasxod.product_id=productId and
                        ( sell.date = date1 or (rasxod.sell_id is null and rasxod.date =date1) )
                )
                , 0);
            END;

        ");


        $this->execute("
        
            DROP FUNCTION IF EXISTS `generateDates`;
            
            CREATE DEFINER=`root`@`localhost` FUNCTION `generateDates`(date1 DATE, date2 DATE) RETURNS text CHARSET latin1
            BEGIN
            
            declare res TEXT;
            declare cDate TEXT;
            
            set cDate = date1;
            set res = '';
            
            while cDate <= date2 DO
            
            set res = concat(res, ',', cDate);
            
            set cDate = DATE_ADD(cDate, Interval 1 Day);
            
            end while;
            
            
            RETURN trim(LEADING ',' from res);
            END;
        ");


        $this->execute("
        
            DROP FUNCTION IF EXISTS `generatePRDates`;
        
            CREATE DEFINER=`root`@`localhost` FUNCTION `generatePRDates`(date1 DATE, date2 DATE) RETURNS text CHARSET latin1
            BEGIN
            
            declare res TEXT;
            declare cDate TEXT;
            
            set cDate = date1;
            set res = '';
            
            while cDate <= date2 DO
            
            set res = concat(res, \",
                    '\",cDate,\"P', getProductPrixod(product.id, '\", cDate, \"'),
                    '\",cDate,\"R', getProductRasxod(product.id, '\", cDate, \"'),
                    '\",cDate,\"S', getProductBalance(product.id, '\", cDate, \"', 1)\");
            
            set cDate = DATE_ADD(cDate, Interval 1 Day);
            
            end while;
            
            RETURN concat('JSON_OBJECT(', trim(LEADING ',' from res), ')');
            
            RETURN '';
            END;

        ");


        $this->execute("
        
            DROP FUNCTION IF EXISTS `checkForEmptyBP`;
            
            CREATE DEFINER=`root`@`localhost` FUNCTION `checkForEmptyBP`(input_object JSON, B1 int) RETURNS tinyint(1)
            BEGIN
                DECLARE array_length INTEGER(11);
                DECLARE input_array JSON;
                DECLARE is_empty tinyint(1);
                DECLARE cell_value INTEGER(11);
                DECLARE idx INT(11);
                
                set is_empty = 1;
                
                SELECT json_extract(input_object, '$.*') INTO input_array;
            
                SELECT json_length( input_array ) INTO array_length;
            
                SET idx = 0;
            
                myloop: WHILE idx < array_length DO
                    SELECT json_extract( input_array, concat( '$[', idx, ']' ) )
                        INTO cell_value;
                        
                    if cell_value > 0 then
                        set is_empty = 0;
                        LEAVE myloop;
                    end if;
            
                    SET idx = idx + 1;
                END WHILE;
                
                return is_empty and B1 = 0;
            END;

        ");


        $this->execute("
        
            DROP PROCEDURE IF EXISTS `balanceProduct`;
            
            CREATE DEFINER=`root`@`localhost` PROCEDURE `balanceProduct`(IN date1 DATE, IN date2 DATE, IN skipEmpties TINYINT(1))
            BEGIN
            
            SET @queryString = (
            SELECT CONCAT(
                'Select 
                    product.id,
                    product.name,
                    product.vendor_code,
                    getProductBalance(product.id, \"',date1,'\", 0) as B1,',
                    generatePRDates(date1, date2), ' as actions,',
                    \"checkForEmptyBP( (select actions) , (select B1) ) as is_empty\",
                \" from product
                group by product.id\",
                if(skipEmpties = 1, ' having is_empty = 0', '')
                )
                as res
            );
            
            -- select @queryString;
             PREPARE stmt FROM @queryString;
             EXECUTE stmt;
             DEALLOCATE PREPARE stmt;
            
            END;

        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200310_123347_create_procedures cannot be reverted.\n";

        return false;
    }

}
