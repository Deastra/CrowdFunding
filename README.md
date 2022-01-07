Crowd Funding Web Application

URL of the application: https://gismat.alwaysdata.net/back_end/crowdfunding/login.php

This project is made for investing the projects as called the CrowdFunding. There are numerous users, 
where some of them are project owners and investors and others just as investors.

NOTE:
All the database connections are local, to execute the application correctly download the crowdfunding database.
All queries are in MySQL format.

Overview of the project:
In the project PHP,MySQL,HTML,CSS,BOOTSTRAP5,JS,JQUERY,CanvasJS are used. The database are connected to 
phpmyadmin-mysql (gismat.alwaysdata.net). For the front part html, css and bootstrap classes and for the visualization 
of statistical graphs js-canvasjs are used. These graphs has animation effects.

The project starts with login page, with new session, if user desires to access main page (dashboard or any other particular pages)
he/she will be redirected to login page with the help of "auth.php". After succesful login, the user passes to main page 
which is our dashboard and can find information about own profile and projects table. 
With the bar graph below in the main page, user can see the percentage of investments to all the projects.
If user desires to invest to any of the available projects, clicking the invest button will direct him to investment page where 
user can specify the investment amount which can not be less than 0.01 and more than remaining fund (requested-total_invested)
and the date of the investment. For date input datepicker from jquery are implemented and in the calendar of the input,
dates before the start time and dates after the end time of the project can not be selected. Below the investment form, user can
find the pie-chart of the requested and total_investment fund of the current project. After investing succesfully, user 
will be redirected to the details page where he can access from dashboard too. In this page user can see only his own investment 
to this project as a slice of the table and below with pie-chart, similar with the one in invest page, 
but added the users own investment percentage.
Back in the dashboard projects table, in front of some projects you can see invest button and in others details button.
Details button redirects to the same page after investment as the invest to the same project twice is not possible. 
So, after investment to the project, its invest button in the table is converted to details button.
In main page user can see his own projects with "My Projects" button. If user has no projects, this button is disabled.
my_projects page contains the table of the owned projects and bar-chart of these projects describing the percentage ratio
of the requested and invested funds. In the table of projects, in front of the each project INVESTORS button can be found,
which leads to the page where all the investors to that project, details of their investment are shown and in the pie-chart below 
investment share of the investors are described.

SECURITY:
As the endpoints in hyperlinks are used for invest, details and my_projects page, these endpoints can be misused.
For example, owner can donate to his own project by changing the id in the end of the link, 
of investor can donate to one project twice by doing the same procedure.
However, these problems are considered and avoided with relevant checking in the php scripts. 
So, if the user already invested to the project, even he changes the nedpoint 
of the invest link, he will be redirected to the details page where he can see 
the details of his investment or if users desired to invest to his own project,
he will be leaded to the main page. And if owner changes the id in the of the details 
page link to his own project id, then he will be directed to the page of 
this projects investors (my_projects->investors). 



