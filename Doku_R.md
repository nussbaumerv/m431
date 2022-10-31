# Realisation
## Web Server and Domain Setup
For the Hosting Provider we choose a Hostinger VPS plan.
For the OS I installed Webmin on it because it has a great web panel and it’s free.
For the installation of Webmin I used this tutorial: [Webmin](https://www.digitalocean.com/community/tutorials/how-to-install-webmin-on-ubuntu-20-04-de).


Apache and Mysql are already installed by default.
For a better web panel for Mysql I installed phpmyadmin through the following command.

apt-get install phpmyadmin

With the GitHub education program I got the domain: edu-chat.me for free.
After I got the domain I changed the nameservers to cloudflare, because it is faster, more secure and has much more features than the DNS server from Namecheap.

After I switched to Namecheap DNS I created an A entry with the IP address of my server.

For an easy connection from my pc to the web server I did setup SSH. I had to enter a password and set a port for SSH. After that I was able to connect to my Webserver directly from vscode which enabled a very nice workflow.

Because the SSL certificate of cloudflare didn’t work releible, I got a free SSL certificate from the GitHub education pack. I installed the certificate with this tutorial: [SSL](https://www.namecheap.com/support/knowledgebase/article.aspx/9702/33/installing-an-ssl-certificate-on-webmin/). 

For the Email server I used the Email service from Hostinger. I had to create two MX records in cloudflare pointing to Hostinger. For pointing the MX records I used this tutorial: [Email MX](https://support.hostinger.com/en/articles/1583453-how-to-point-mx-records-for-emails-at-hostinger).


## Coding
The first thing I've worked on, was the creation of the SQL database and the coding of the file which loads the data from the database with PHP. After that i’ve worked on the file which inserts the messages in the Database. This first part of the coding was easy for me because I already had much experience with PHP and SQL. With AJAX, the next tool I've used, I didn't have any experience. So I had to learn it first. To learn the basics I used this tutorial: [AJAX](https://www.w3schools.com/xml/ajax_intro.asp). 
After I've learned the basics of AJAX I coded the sending and receiving of messages. [Bug 1](#bug-1)

The implementation of Email is also an important Feature. I used the PHPMailer Library, which makes sending emails with php easy and secure. For easy Email sending from every php file I created a function called send_mail() in the mail.php file. So that I can just include the mail.php file, call the function and an email to the in the parameter defined email address is sent. This makes everything much more clean. [Bug 2](#bug-2)

After this efficiently worked and the bugs were solved, I started working on the login and registration part. I created the SQL Database and coded the backend for the registration and login. For a more secure login I implemented a script, which sends an email every time you login. For an even secure registration implement 2FA authentication after the registration. With the implementation of PHP cookies I faced another problem. Because you shouldn't store the user's password in a cookie, I had to find a better solution. I’ve decided to generate a unique token after the registration so that the password never touches your device. On the server side I encrypt the passwords with php’s built in password encryption for even more security. 

After the login process was finished I started working on the frontend. I’ve started with the messaging window. After that I wrote the frontend for the registration and login. For the CSS styling in general I created my own framework, so that everything looks similar, and that I don't have to style everything separately. All of that with things like the favicon I integrated in the “header.html” file so that I only have to include this file through php. After the frontend finished for the beginning I started working on the room feutre.

With the room feature you can create a room, add people and mods to it and leave the room. 
I’ve started with the room creation feature. After this worked well I added a function with which a user can add another user to a room. When a user gets added to a room or promoted to a mod the send_mail() function gets called like in the login. To finish this major part of our product I added a feature with which you can leave a room.

For all of these room features I added the room settings. I created two separate settings. One setting for normal users who can just leave a room. And mod settings in which you can also add people to a room. In the user settings I created features with which you are able to change your email, username and password. You can also change your message color and activate desktop notifications. 




## Problems I faced
### Bug 1
In Product Development I faced many problems. One of the first was that after I implemented the Ajax library our Product got much more inefficient. Because it basically reloaded all the messages in the room every 2. Seconds from the database. This made the user experience very bad and my webserver was immediately overloaded. But I didn't want to do it without the auto message load feature. So I had to find a solution. Throw the handover of the amount messages the messages only update when new data is available. But it still checks every few seconds if there’s new data available, so that the auto message loading feature still works.

### Bug 2
Another mature problem I faced was the email server. The integration of email over SMTP is very important in our product and because of that I have to send many emails per day. In the beginning I used the email service of one of my hosting providers I already had. But after a few days it always blocked my email address because of spam. So I had to find another free service, because I didn't want to spend money on it. Gmail didn’t work with SMTP and everything else was a paid service or not scalable enough for our project. After hours of researching I decided to use my icloud email address. But after a few days my apple id got blocked, so this was also no option. In the end I decided to use the edu-chat.me domain as the email domain and pointed the mx records to one of my other hosting providers, which provides a great email service. I’m very happy that we chose this option because it looks much more professional and is much more reliable.


