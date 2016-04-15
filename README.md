# PsychTest
A Psycho Test tool based on PHP, CodeIgniter and MySQL.
This tool was designed for psychological test.

##Goal
---
During my job interview at BOCO, Beijing, answering their psycho test by a pen was really driving me mad.
I just kept asking why couldn't you guys use a web app instead? So I made this for them as a demo, and they don't give it a sh*t...

That's why it's on GitHub right now...

Currently I've tried to run this site (still running) on my Raspberry Pi 1 (note, it's Rpi __1__!) . The performance is completely acceptable.

##But
---
1. It's in Chinese only (english ver will be added soon)
2. The GUI is simple, but OK
3. I don't have time & user to fully debug it, so please feel free to contact me by relidin@126.com

##Usage
---
### DB
For people who are not familiar with CodeIgniter,
Database settings are at `/app/config/database.php`
See their official website to know more.
[http://www.codeigniter.com](http://www.codeigniter.com)

### Permissions
Remember to change `/upload` directory's permission to 777 to allow file uploads, other than that,
make sure directory permissions are 755 and file permissions are 644.

### SQL
Use SQL files in `/sql` to import database structures

### Admin
Default admin username: `admin`, password:`1234`, you can change it in table `admin`

### Questions
Single/Multi choice questions are supported, but the max options are limited to 5

##Envi
---
For the sake of simplicity, you can just install XAMPP (win/mac/linux apache + mysql + php + ftp)
as the default environment.
Download & install XAMPP at [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
and place project folder under a correct path (see XAMPP configuration for more details).

##Bug reporting
---
Bug reporting & cooperations are always welcomed. Just throw me an email by relidin@126.com
I'm new on GitHub and always want to make more friends :)

---
Cheers,
Beichen Li
