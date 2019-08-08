# Description

This Extension for pimcore is adding a new route ```/webservice/rest/products``` which delivers multiple objects with detailed information.

# Installation

Install with composer

```
composer config repositories.synoa_apiproducts git https://github.com/synoa/cerebro.pimcore.api.object-resolver.git
COMPOSER_MEMORY_LIMIT=-1 composer require synoa/apiproducts
```

# Uninstall

```
COMPOSER_MEMORY_LIMIT=-1 composer remove synoa/apiproducts
composer config unset repositories.synoa_apiproducts
```

# How to use

## Create a static route

| Name | Pattern | Bundle | Controller | Action |
| --- | --- | --- | --- | --- |
| choose a meaningfull name like ```synoa REST``` | ```#/webservice/rest/synoa/objects#``` | ApiProductsBundle | Index | Index |

:point_right: The ```#``` sign is important in the Pattern

Go to your static route ```http://<host>/webservice/rest/synoa/objects```

## Params

| Param | Description | Type | Constrain | Default value |
| --- | --- | --- | --- | --- |
| objectClass | The object class, eg. product | string | | |
| last_modified | An timestamp for getting products where modification date is greater than given timestamp | int | <nobr>```value >= 0```</nobr> | 0 |
| limit | Limit the count of results in the response | int | <nobr>```value > 0```</nobr><br><nobr>```value < 100```</nobr>| 10 |
| offset | Skip results to get to next page | int | <nobr>```value >= 0```</nobr> | 0 |
| q | Please look up in [Pimcore Filter documentation](https://pimcore.com/docs/5.x/Development_Documentation/Web_Services/Query_Filters.html) |

# Dependencies

| Software | Version |
| --- | --- |
| Pimcore | 5.7.0 |
