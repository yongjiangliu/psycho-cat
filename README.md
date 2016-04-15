# PsychTest
---
A psychological testing tool implemented in PHP, CodeIgniter

## Showcase
---
### Home Page
![Home](/doc/img/home.png "Home")
### Testing
![Testing](/doc/img/test.png "Testing")
### Admin: Answer List
![Answers](/doc/img/answers.png "Answers")
### Admin: Question List
![Questions](/doc/img/questions.png "Questions")

## Require
---
* PHP 5+
* MySQL

## Pros & Cons
---
### Pros
1. Fast editing/uploading questions by EXCEL
2. Test can be interrupted (close browser), then resumed by entering provided `test code`
3. Can't change answered questions, good for psycho test

### Cons
1. Right now it's in Chinese only
2. Don't have enough users for debuging

## How to use
---
1. Download the source code
2. Install XAMPP [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
3. Create MySQL database for this project, execute SQLs (`/doc/sql`) for table structures
4. Copy the source code to apache site path
5. Change the value of __base_url__ in `/app/config/config.php` to your domain name
6. Set the database connection parameters in `/app/config/database.php`
7. For FTP users, set directory permission of `/upload` to 777 to allow uploading, besides that, all directories should have permission of 755 and files 644.
8. Don't forget to delete `/doc` upon deployment
9. Don't forget to change the CodeIgniter status to __production__ in `/index.php` upon deployment

For people who are not familiar with CodeIgniter FrameWork
[http://www.codeigniter.com](http://www.codeigniter.com)

Use username: `admin`, password:`1234` to login as an admin,
you can change admin username/password in MySQL table `admin`

Right now PsychTest supports single and multi-choice questions. See upload page for more information.

## History
---
During my job interview at BOCO, Beijing, I have to take a psycho test by a pen and paper, which almost drove me mad. After that, I just kept asking why couldn't you guys use a web app to make life easier?
So I made BOCO a web psycho test demo, and...

And they don't give me a sh*t....

That's why you are seeing this now on GitHub.

The demo of PsychTest is running now on my Raspberry Pi 1, while the performance is completely acceptable.

## Bug reporting
---
Bug reports & forks are overwelmingly welcome. Just throw an email to relidin@126.com then I can answer it on my Cell. I'm new to GitHub and want to make some friends :3

Best,
Beichen Li
2016-4-15
