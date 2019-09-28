'use strict';

exports.config = {
    paths: {
        public: 'public',
        watched: ['assets/']
    },
    files: {
        javascripts: {
            joinTo: {
                'js/vendors.js': /^assets\/js\/vendor/,
                'js/app.js': /^assets\/js\/app/
            }
        },
        stylesheets: {
            joinTo: {
                'css/vendors.css': /^assets\/css\/vendor/,
                'css/app.css': /^assets\/css\/app/,
            }
        }
    },
    conventions: {
        assets: /^app\/Resources\/assets/
    },
    watcher: {
        awaitWriteFinish: true
    },
    modules: {
        wrapper: (path, data) => {
            return path.indexOf('vendors') === -1 ? `
                require.define({'${path}': function(exports, require, module) {
                  ${data}
                }});\n\n
            ` : `${data}`
        }
    }
};
