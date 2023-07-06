## Zid Task 2 Explaining well!
##### (Get order details) web app
This task involves extracting values from Zid's API and exploring the Order Endpoint. The purpose is to identify and explain the differences in the order body for three specific features: bundle offer, discount coupon, and VAT configuration.

### Order with Bundle Offer
For orders with a bundle offer, we need to inspect the :

    data_from_api -> order -> products array.

Specifically, we look at the last product's metadata, which is located at :

    meta -> bundle_offer.

By checking the existence of metadata for the last product, we can determine if the order includes a bundle offer.

### Order with a Discount Coupon
To identify orders with a discount coupon, we examine the:

    data_from_api -> order -> coupon array.

We validate whether the coupon value is null or not. If it's null, the order doesn't use a coupon.
If it has a value, the order utilizes a coupon.
In such cases, we can extract the coupon code from :

    data_from_api -> order -> coupon -> code 

and the coupon value from :

    data_from_api -> order -> coupon -> discount_string.

### Order with VAT Configuration
Determining the VAT configuration depends on whether the order has a bundle offer or not.
If the order includes a bundle offer, we retrieve the VAT value from:

    data_from_api -> order -> payment -> invoice[4] -> value.

However, if the order doesn't have a bundle offer, we still retrieve the VAT value using a similar path, but we modify the array element: 

    data_from_api -> order -> payment -> invoice[2] -> value.

###### To help you understand the implementation, I have provided a sample PHP code in the index.php file, which is included in the project. Follow the steps below to use the file:

* Create a project folder on your Apache or PHP server and name it, for example, "zid-test".
* Copy the index.php file into the project folder.
* Open your web browser and enter the URL for your host and project, e.g., "yourHost/projectName".
* Start using the application and enjoy!

Please note that the code is only a sample, and you may need to modify it to fit your specific requirements and environment.