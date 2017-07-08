API MASTER API's Generator
===================
An api generator implemented with (PHP, silex, doctrine), this is help full to generate api's.

## Features

 - Validations
    - Provide validations in api generator defination.
    - Apply different different type or validations
    - Extendable
 - ORM (Doctrine)
 - Object Translations
 - Api Request and Response Objects
 - Object serialization and de serialization
 - Full OOP's based system generator
 - Easy getters, setters writing
 - Fully exception handling
 - Annotation based Object mapping
------------

## Step to setup

***

Clone the repository

    git clone repo url

    cd api_master

---------------------

Edit the file /path_to/api_master/src/app.php and set your database conection data:

    $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'dbs.options' => array(
            'db' => array(
                'driver'   => 'pdo_mysql',
                'dbname'   => 'DATABASE_NAME',
                'host'     => 'localhost',
                'user'     => 'DATABASE_USER',
                'password' => 'DATABASE_PASS',
                'charset'  => 'utf8',
            ),
        )
    ));


## Generate Apis

***

Update $config Provide api definations
---------------------
Update $config vars in /path_to/api_master/console file.

Example to setup an e-commerce:
```
    $config = array(
      "module" => "user",
      "apis" => array(
        "category" => array(
          "module" => "marketplace",
          "entity" => "category",
          "table" => "category_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "createCategory" => array(
              "method" => "POST",
              "request" => array(
                "categoryName" => "",
                "categoryDescription" => "",
                "type" => "simple",
                "categoryImage" => "",
                "metaTitle" => "",
                "metaDescription" => "",
                "roleCodes" => "",
                "status" => 1
              ),
              "response" => array(
                "status" => true,
                "category" => array(
                  "categoryName" => "",
                  "categoryDescription" => "",
                  "type" => "simple",
                  "categoryImage" => "",
                  "metaTitle" => "",
                  "metaDescription" => "",
                  "roleCodes" => "",
                  "status" => 1
                )
              ),
              "validators" => array(
                "required" => array("categoryName", "categoryDescription", "type", "roleCodes"),
                "email" => array("emailId"),
                "mobile" => array()
              )
            ),
            "getCategoryList" => array(
              "method" => "GET",
              "request" => array("roleCode" => "STU"),
              "response" => array("firstName" => "Kapil", "lastName" => "Chauhan"),
            )
          )
        ),
        "catalog" => array(
          "module" => "marketplace",
          "entity" => "product",
          "relation" => array(
            "profile_id" => array(
              "table" => "category_master",
              "type" => 'OneToOne(targetEntity="CategoryMasterModel", cascade={"persist", "remove"})'
            )
          ),
          "table" => "product_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "createProduct" => array(
              "method" => "POST",
              "request" => array(
                "productTitle" => "",
                "productSubtitle" => "",
                "productDescription" => "",
                "metaTitle" => "",
                "metaDescription" => "",
                "image" => "",
                "price" => "",
                "categoryCode" => "",
                "skuCode" => "9324324432",
                "minOrderQuantity" => "",
                "maxOrderQuantity" => "",
                "sortOrder" => "",
                "createdDate" => "",
                "updatedDate" => "",
                "schoolCode" => "",
                "classCode" => "",
                "classCode" => "",
                "status" => 1
              ),
              "response" => array("status" => true),
              "validators" => array(
                "required" => array("productTitle", "productDescription", "price", "categoryCode"),
                "email" => array(),
                "mobile" => array()
              )
            ),
            "getProductDetails" => array(
              "method" => "GET",
              "request" => array("skuCode" => 123),
              "response" => array(
                "productTitle" => "",
                "productSubtitle" => "",
                "productDescription" => "",
                "metaTitle" => "",
                "metaDescription" => "",
                "image" => "",
                "price" => "",
                "categoryCode" => "",
                "skuCode" => "9324324432",
                "minOrderQuantity" => "",
                "maxOrderQuantity" => "",
                "sortOrder" => "",
                "createdDate" => "",
                "updatedDate" => "",
                "schoolCode" => "",
                "classCode" => "",
                "classCode" => "",
                "status" => 1
              ),
            ),
          )
        ),
        "pincode" => array(
          "module" => "marketplace",
          "entity" => "pincode",
          "table" => "pincode_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "isServicablePincode" => array(
              "method" => "GET",
              "request" => array("pincode" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
        "address" => array(
          "module" => "marketplace",
          "entity" => "address",
          "table" => "user_address",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "getUserAddressList" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "addAddress" => array(
              "method" => "POST",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "updateAddress" => array(
              "method" => "PUT",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "deleteAddress" => array(
              "method" => "DELETE",
              "request" => array("addressCode" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
        "cart" => array(
          "module" => "marketplace",
          "entity" => "address",
          "table" => "user_cart",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "getUserCart" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "addItemToCart" => array(
              "method" => "POST",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "updateCartItemQuantity" => array(
              "method" => "PUT",
              "request" => array("itemId" => 12334, 'quantity' => 2),
              "response" => array("status" => true),
            ),
            "deleteCartItem" => array(
              "method" => "DELETE",
              "request" => array("itemId" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
        "order" => array(
          "module" => "marketplace",
          "entity" => "address",
          "table" => "order_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "getOrderList" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "getMyOrderList" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "getOrderDetails" => array(
              "method" => "GET",
              "request" => array("orderId" => 12334),
              "response" => array("status" => true),
            ),
            "addAddress" => array(
              "method" => "POST",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "updateAddress" => array(
              "method" => "PUT",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "deleteAddress" => array(
              "method" => "DELETE",
              "request" => array("addressCode" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
      )
    );

```

Now, execute the command that will generate the API's:

    php console generate:api

Author
------

* Kapil Kumar <kapil.kumar@incaendo.com>

