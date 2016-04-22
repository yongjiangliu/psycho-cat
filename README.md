# PsychTest

A psychological testing tool implemented in PHP, CodeIgniter
中文版说明请点[这里](README_CN.md)

## Showcase

### Create questions from Excel template, then save as txt
![Excel](/doc/img/excel.png "Excel")
### Upload to add questions to database
![Questions](/doc/img/questions.png "Questions")
### Home Page
![Home](/doc/img/home.png "Home")
### Testing
![Testing](/doc/img/test.png "Testing")
### Admin view of answers
![Answers](/doc/img/answers.png "Answers")

## Require

* PHP 5+
* MySQL
* Apache

## Pros & Cons

### Pros
1. Fast editing/uploading questions by EXCEL
2. Test can be interrupted (close browser), then resumed by entering provided `test code`
3. Can't change answered questions, good for psycho test
4. You can also use arrow keys + enter to speed up your progress

### Cons
1. Right now it's Chinese only
2. May have some hidden bugs
3. Kind of hard to set up for Noobs, will try to make a installation wizard page later.

## How to use

1. Install XAMPP [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
2. Create MySQL database for this project, execute SQLs (`/doc/sql`) for table structures
3. `cd` to to apache site path and `git clone`
4. Change the value of __base_url__ in `/app/config/config.php` to your domain name
5. Set the database connection parameters in `/app/config/database.php`
6. Set directory permission of `/upload` to 777 to allow uploading, besides that, all directories should have permission of 755 and files 644.
7. Don't forget to delete `/doc` upon deployment
8. Don't forget to change the CodeIgniter status to __production__ in `/index.php` upon deployment

For people who are not familiar with CodeIgniter FrameWork
[http://www.codeigniter.com](http://www.codeigniter.com)

Use username: `admin`, password:`1234` to login as an admin,
you can change admin username/password in MySQL table `admin`

Right now PsychTest supports single and multi-choice questions. See upload page for more information.

## History

During my job interview at BOCO, Beijing, I have to take a psycho test by a pen and paper, which almost drove me mad. After that, I just kept asking why couldn't you guys use a web app to make life easier?
So I made BOCO a web psycho test demo, and...

And they don't give me a sh*t....

That's why you are seeing this now on GitHub.

The demo of PsychTest is running now on my Raspberry Pi 1, while the performance is completely acceptable.

## Bug reporting

Bug reports & forks are always welcome. Just drop an email to relidin@126.com. You can also submit an issue in Issue panel above. I'm new to GitHub and always want to make new friends :3

## License

MIT License(free to use in any where)
---
Best,
Beichen Li
2016-4-15
