### PHP Test Application Using Lumen
#### Todo
Please write a PHP web application and send it back a github link to us.

- Wait for a user action, like clicking buttons. According to these actions some data (see further below) should be:
    - either shown nicely formatted on the screen
    - or downloaded as CSV file
- You can either download the data on each request during the runtime of your PHP program or load the data from a database (in this case do NOT provide a DB dump, but a script which automatically transfers the data from the remote location to the DB)
- preferably the implementation should be written in "clean code", separate concerns using pattern like MVC, be object oriented, very good testable, best even already contain Unit tests and maybe even follow the KISS and SOLID principles

AND

Country List
- the data should be a list of countries with their country code
- Please download the base data from https://gist.github.com/ivanrosolen/f8e9e588adf0286e341407aca63b5230
- afterwards you will have to change the whole list from "Country code - Country name" to "CountryName - CountryCode" and sorts the list by CountryName
