const minify = require('html-minifier').minify;
let inputHtml = process.argv[2];
console.log(minify(inputHtml, { collapseWhitespace: true, removeComments: true, minifyCSS: true, minifyJS: true, removeAttributeQuotes: true, removeRedundantAttributes: true, removeScriptTypeAttributes: true, removeStyleLinkTypeAttributes: true }));
