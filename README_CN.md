# 心理测试工具

一个用PHP和CodeIgniter框架写的心理测试网站。

## 展示

### 使用Excel创建并排列问题，另存为txt
![Excel](/doc/img/excel.png "Excel")
### 上传txt文件，自动写入数据库
![Questions](/doc/img/questions.png "Questions")
### 主页
![Home](/doc/img/home.png "Home")
### 答卷
![Testing](/doc/img/test.png "Testing")
### 使用管理员查看答案
![Answers](/doc/img/answers.png "Answers")

## 需求

* PHP 5+
* MySQL
* Apache

## 优缺点

### 优点
1. 问题用EXCEL编辑之后直接存成txt上传，方便小白用户
2. 只要记住系统分配给你的试卷代码，就可以在重启浏览器后继续从同一位置答题
3. 受试者不能更改已答的问题，更符合心理测试的需求
4. 也可以使用箭头和回车答题，提高速度

### 缺点
1. 目前只有中文版
2. UI目前有点太简单了，需要改善
3. 可能存在一些未修正的BUG

## 如何使用

1. 安装XAMPP        [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
2. 创建MySQL数据库，使用`/doc/sql`中的SQL文件来创建表结构
3. `cd`到阿帕奇的网站目录，`git clone`项目代码
4. 修改`/app/config/config.php`中的__base_url__为你的网站域名
5. 修改`/app/config/database.php`中的MySQL数据库连接设置
6. `/upload`文件夹权限应该为777，其他文件夹权限应为755，文件为644
7. 部署后别忘了删除`/doc`文件夹
8. 部署后别忘了更改`/index.php`中的状态名到__production__，以禁止Debug信息

如果你没有接触过CodeIgniter，可以戳这里
[http://www.codeigniter.com](http://www.codeigniter.com)

管理员登录的默认用户名:`admin`, 密码:`1234`
你可以在表`admin`中修改管理员用户名和密码

现在本项目支持单选和多选，请见管理员的上传页面了解更多Excel的编写规则

## 黑历史

在我面试亿阳信通的时候心理测试是用笔写的，要做三个小时很蛋疼。于是我在等通知的时候自己做了一个网站版的心理测试，觉得会节省后面的人不少的做题时间。

结果我给HR看了我的demo。
然后HR根本不鸟我……

所以我就把源代码发GitHub喽，虽然估计也木有人用但是总比烂在硬盘里好你说是吧 ：3

## 错误报告

非常欢迎报告错误！如果你想报告错误或者交个朋友请发邮件到relidin@126.com，或者直接在本项目的Issue里提交。

## 证书
MIT证书(随便用)

---
Beichen Li 于 2016-4-15
