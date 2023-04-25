// shared config (dev and prod)
const { resolve } = require("path");
const HtmlWebpackPlugin = require("html-webpack-plugin");
const path = require('path');
const webpack = require('webpack'); // to access built-in plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const autoprefixer = require('autoprefixer');
const fs = require('fs');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const IconfontPlugin = require('iconfont-plugin-webpack');
const ImageMinPlugin = require('imagemin-webpack-plugin').default;
const appDirectory = fs.realpathSync(process.cwd());

function resolveApp(relativePath) {
  return path.resolve(appDirectory, relativePath);
}

const paths = {
  appSrc: resolveApp('src'),
  appBuild: resolveApp('static'),
  appIndexJs: resolveApp('src/js/app.js'),
  appAdminJs: resolveApp('src/js/admin.js'),
  appNodeModules: resolveApp('node_modules'),
};

module.exports = {
  target: 'web',
  context: resolve(__dirname),
  entry: {
    app: paths.appIndexJs,
    admin: paths.appAdminJs
  },
  output: {
    filename: 'js/[name].bundle.js',
    path: paths.appBuild
  },
  devtool: 'cheap-eval-source-map',
  externals: {
    jquery: 'jQuery',
    $: 'jQuery'
  },
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.(js|s?[ca]ss)$/,
        include: path.resolve(__dirname, 'src'),
        loader: 'import-glob',
      },
      {
        test: /\.js?$/,
        loader: 'babel-loader',
        include: paths.appSrc,
        options: {
          presets: ['@babel/preset-env']
        }
      },
      {
        test: /.s(a|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: "css-loader",
          },
          {
            loader: "postcss-loader",
            options: {
              ident: "postcss", // https://webpack.js.org/guides/migrating/#complex-options
              plugins: () => [
                autoprefixer({
                  browsers: [
                    ">1%",
                    "last 4 versions",
                    "Firefox ESR",
                    "not ie < 9" // React doesn't support IE8 anyway
                  ]
                })
              ]
            }
          },
          "sass-loader"
        ],
      },
      {
        test: /\.(png|jpg)$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              limit: 5000
            }
          }
        ]
      },
      {
        test: /\.(svg|eot|ttf|woff|woff2)$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              limit: 5000000
            }
          }
        ]
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/[name].bundle.css',
    }),
    new ImageMinPlugin({ test: /\.(jpg|jpeg|png|gif|svg)$/i }),
    // new CleanWebpackPlugin({
    //     verbose: true,
    // }),
    new CopyWebpackPlugin([
      {
        from: './../src/img/',
        to: path.join(__dirname, '../static/img')
      },
    ], {})
  ],
  performance: {
    maxEntrypointSize: 1512000,
    maxAssetSize: 1512000
  },
};
