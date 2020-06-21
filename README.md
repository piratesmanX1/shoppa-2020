# shoppa-2020
 A group assignment that required us to apply the knowledge of AJAX and Bootstrap 4 that's been taught in this course. On this assessment we've chose to create a website that focused on selling the technological products such as phone and laptop. The assessment is not much of a hard task to handle with as I've self-learned the concept of AJAX and Bootstrap 4 in my previous project like Meal-Debit System in 2019. With that, the assessment allowed me to obtain more experience from implementing these concepts, and deepened my knowledge of AJAX and Bootstrap 4 from this course.

**The uploaded project file is only for references and comparison, the project file will not be used in any profit-oriented activities without my permission. The user that downloaded the said project will be responsible for any outcomes of their future implementation on the project, and I will not held any legal responsibilities upon your action. However, any users are welcomed to suggest any changes or improvements upon the project if they want to.**

**===================================INSTRUCTIONS===================================**
1. Import Database into phpMyAdmin. (File name: ```fwddlab.sql```)
2. Go to SQL tab in phpMyAdmin and type this (before that enable event scheduler, type in SQL tab with this: ```SET GLOBAL event_scheduler="ON"; ```):

```
CREATE DEFINER=`root`@`localhost` EVENT `generate_report` ON SCHEDULE EVERY 1 MONTH STARTS '2020-04-30 23:59:55' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Automatically generates Monthly Report at the end of the month.' DO INSERT INTO monthly_report
(report_name, product_id, product_name, product_cost, product_quantity_total, product_category_id, product_cost_total, month_report, year_report, generated_time)
SELECT MONTHNAME(CURRENT_TIMESTAMP()), cart_item.product_id, product.product_name, product.product_price, SUM(cart_item.cart_item_quantity),
product.category_id, ((SUM(cart_item_quantity)) * product.product_price), MONTH(CURRENT_TIMESTAMP()), YEAR(CURRENT_TIMESTAMP()), CURRENT_TIMESTAMP()
FROM product INNER JOIN cart_item
ON product.product_id = cart_item.product_id
INNER JOIN cart ON cart_item.cart_id = cart.cart_id
WHERE cart.cart_status = 1
GROUP BY cart_item.product_id
```

3. Download the files, put all the files into the folder named ```FWDD_Shoppa``` inside it and place it in ```www``` in WAMP.

with the directory like this: ```www\APU\ASSIGNMENT\FWDD_Shoppa\homepage.html```

4. Change some setting in WAMP to let HTML run the PHP code as well: 

Follow the instruction in this link:
https://stackoverflow.com/questions/11312316/how-do-i-add-php-code-file-to-html-html-files

**===================================INSTRUCTIONS===================================**
