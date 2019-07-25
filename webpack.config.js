var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    .copyFiles({
        from: './assets/images',
        to: 'images/[name].[ext]',
    })
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app    .addEntry('inspiration', './assets/scss/inspiration.js')
")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .enableReactPreset()
    .addEntry("destination", "./assets/scss/destination.scss")
    .addEntry("affiliateService", "./assets/scss/affiliateService.scss")
    .addEntry("cgu", "./assets/scss/cgu.scss")
    .addEntry("commitment", "./assets/scss/commitment.scss")
    .addEntry("bePartner", "./assets/scss/bePartner.scss")
    .addEntry('index', './assets/js/index.js')
    .addEntry('planner', './assets/js/react/Planner/Planner.js')
    .addEntry('formRegistration', './assets/js/formRegistration.js')
    .addEntry('homepage', './assets/scss/homepage.scss')
    .addEntry("travelerDetailForm", "./assets/scss/travelerDetailForm.scss")
    .addEntry('mailbox', './assets/js/react/Mailbox/Mailbox.js')
    .addEntry('inspiration', './assets/scss/inspiration.scss')
    .addEntry('stageDetails', './assets/scss/stageDetails.scss')
    .addEntry("login", "./assets/scss/login.scss")
    .addEntry("contactForm", "./assets/scss/contactForm.scss")
    .addEntry("editClientForm", "./assets/scss/editClientForm.scss")
    .addEntry("editAgencyForm", "./assets/scss/editAgencyForm.scss")
    .addEntry('stageDetailsJS', './assets/js/stageDetails.js')
    .addEntry('stageIndex', './assets/scss/stageIndex.scss')
    .addEntry('stageShow', './assets/scss/stageShow.scss')
    .addEntry('stageEdit', './assets/scss/stageEdit.scss')
    .addEntry('success', './assets/scss/success.scss')
    .addEntry('galery', './assets/js/galery.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    .enableLessLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
