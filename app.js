/**
 * 因为用的是express框架,当然要先引用喽!
 * 后面所有app.* 都是引用的express的API
 * 另外NodeJS你可以理解它就是某人把Google Chrome改了改当服务器用了,哦哈哈哈哈哈!
 * 所以,古语云: 没有Chromium, 怎么种庄稼?? 要了解更多见下面的链接
 * 另外, 请记住修改非 **./public 和 views** 下的文件,可能需要重启服务令其生效
 * everything is based on express! so of course it should be imported first :)
 * if you want to know more about express & nodejs & Chormium, see the links below
 * @see http://www.expressjs.com/
 * @see https://nodejs.org/
 * @see http://www.chromium.org (GFW BANNED)
 *
 * @author bcli 2017-10-19
 * @email relidin@126.com
 * @music  Eminem -- Mockingbird
 * */

var express = require('express');
var app = express();

/**
 * 使用morgan做服务器日志记录, 要更改版本,修改package.json并运行npm install
 * use morgan as server logger, modify package.json & run $npm install to change its version
 * @see https://www.npmjs.com/package/morgan
 */

var logger = require('morgan');
app.use(logger('dev'));

/**
 * 使用cookie-parser来解析HTTP头中的COOKIE信息, 要更改版本,修改package.json并运行npm install
 * use cookie-parser as ......cookie parser, modify package.json & run $npm install to change its version
 */

var cookieParser = require('cookie-parser');
app.use(cookieParser());

/**
 * 使用body-parser来解析HTTP POST中的表单信息, 要更改版本,修改package.json并运行npm install
 * use body-parser as body parser of HTTP header, modify package.json & run $npm install to change its version
 * https://www.npmjs.com/package/body-parser
 */

var bodyParser = require('body-parser');
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));

/**
 * 让public文件夹下的内容可以让用户直接通过路径访问,比如:
 * <img src="/img/2333.jpg">
 *  实际上请求的是./public/img/2333.jpg
 *  make folder/files under ./public ........public......to public
 *  so now you can use <img src="/img/2333.jpg>" to display ./public/img/2333.jpg
 */
var path = require('path');
app.use(express.static(path.join(__dirname, 'public')));

/**
 * 使用public/favicon.ico 作为页面标签上的小图标, 要更改serve-favicon版本,修改package.json并运行npm install
 * use public/favicon.ico as tab icon, modify package.json & run $npm install to change version of serve-favicon
 * @see https://www.npmjs.com/package/serve-favicon
 */
var favicon = require('serve-favicon');
app.use(favicon(path.join(__dirname, 'public', 'favicon.ico')));

/**
 * 设置页面渲染引擎为HandleBars,模板文件位置为: ./views
 * 用渲染引擎为了
 * 1. 写HTML的时候能偷点懒(笑)
 * 2. 能够在服务器这边通过js脚本添点数据进去, 或者说"动态生成"页面吧
 * 但是注意这样会导致响应速度变慢哦! 因为服务器要多用N ms来把HandleBars模板转化成html!
 * 另外常见的Express页面渲染引擎还有pug(原Jade和某商标撞车了只好改名喽!),
 * ejs等,在建立项目时候通过express -h来查看额外的命令行参数,用这些参数来使用不同的页面渲染引擎!
 * set view engine to handlebars (view = page)
 * @see http://handlebarsjs.com/
 * @see https://www.npmjs.com/package/pug
 * @see https://www.npmjs.com/package/mustache
 */
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'hbs');

/**
 * 设置路由 (器? 不是! 其实就是告诉NodeJS收到HTTP请求的时候应该调用哪些脚本来响应啦,
 * 比如输入http://mysite.com/view/hr的时候,调用./routes/view/hr.js中定义的响应函数来返回用户一个页面)
 * setup routes
 */
// 主页 index page
app.use('/',          require('./routes/index.js'));
// 受试者和HR看到的页面, pages for subjects & HRs
app.use('/hr',       require('./routes/view/hr.js'));
app.use('/subject',  require('./routes/view/subject.js'));

// API
// 一些基本的操作,比如获得下一道题,获得用户信息之类的完全没必要渲染一个新的页面,JSON字符串足够了.所以这里允许前端
// 直接用AJAX发送请求,API会返回一个JSON字符串,然后前端就可以通过jQuery来显示这些数据了
// 另外之所以用v1是因为以后可能有version 2啊!  偶哈哈哈哈!!
app.use('/api/v1/',        require('./routes/api/v1/questions.js'));
app.use('/api/v1/',        require('./routes/api/v1/subjects.js'));

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  var err = new Error('Not Found');
  err.status = 404;
  next(err);
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};
  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;
