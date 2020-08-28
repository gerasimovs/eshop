module.exports = {
    presets: [
        ['@vue/app', {
            polyfills: [
                'es.object.to-string',
                'es.promise',
                'es.symbol'
            ]
        }]
    ]
}