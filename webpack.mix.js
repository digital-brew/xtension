const mix = require('laravel-mix');

function findFiles(dir) {
  const fs = require('fs');
  return fs.readdirSync(dir).filter(file => {
    return fs.statSync(`${dir}/${file}`).isFile();
  });
}

function buildSass(dir, dest) {
  findFiles(dir).forEach(function (file) {
    if ( ! file.startsWith('_')) {
      mix.sass(dir + '/' + file, dest);
    }
  });
}

mix
  .setPublicPath('./dist')

mix
  .js('assets/scripts/app.js', 'dist/scripts')
  .autoload({ jquery: ['$', 'window.jQuery'] });

buildSass('assets/styles', 'dist/styles')

mix
  .copyDirectory('assets/images', 'dist/images')
  .copyDirectory('assets/fonts', 'dist/fonts');

mix
  .sourceMaps()
  .version();
