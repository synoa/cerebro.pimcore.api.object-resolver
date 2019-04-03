pimcore.registerNS("pimcore.plugin.ApiProductsBundle");

pimcore.plugin.ApiProductsBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.ApiProductsBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("ApiProductsBundle ready!");
    }
});

var ApiProductsBundlePlugin = new pimcore.plugin.ApiProductsBundle();
