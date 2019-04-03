# Description

This Extension for pimcore is adding a new route ```/webservice/rest/products``` which delivers multiple products with detailed information. The extension is returning the products data object which is created by the Coreshop extension for Pimcore.

# Installation

Install with composer

```
composer config repositories.synoa_productsapi git https://github.com/synoa/cerebro.pimcore.api.products.poc.git
COMPOSER_MEMORY_LIMIT=-1 composer require synoa/apiproducts
```

# Uninstall

```
COMPOSER_MEMORY_LIMIT=-1 composer remove synoa/apiproducts
composer config unset repositories.synoa_productsapi
```

# How to use

Go to ```http://<host>/webservice/rest/products```

## Params

| Param | Description | Type | Constrain | Default value |
| --- | --- | --- | --- | --- |
| last_modified | An timestamp for getting products where modification date is greater than given timestamp | int | <nobr>```value >= 0```</nobr> | 0 |
| limit | Limit the count of results in the response | int | <nobr>```value > 0```</nobr><br><nobr>```value < 100```</nobr>| 10 |
| offset | Skip results to get to next page | int | <nobr>```value >= 0```</nobr> | 0 |

# Dependencies

| Software | Version |
| --- | --- |
| Pimcore | 5.7.0 |
| Coreshop | 2.0 |
