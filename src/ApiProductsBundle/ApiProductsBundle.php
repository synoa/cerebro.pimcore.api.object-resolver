<?php

namespace ApiProductsBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class ApiProductsBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/bundles/apiproducts/js/pimcore/startup.js'
        ];
    }
}
