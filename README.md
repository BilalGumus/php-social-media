# Project Name

Selçuk Sözlük -  PHP Social Media Application

# Table of Contents

- [Project Description](#project-description)
- [Features](#Features)
- [Installation](#installation)
  - [Requirements](#requirements)
  - [Installation Steps](#installation-steps)
  - [Getting Started](#getting-started)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)


## Project Description

Selçuk Sözlük is a simple social media platform built using PHP, TailwindCSS and MySQL. It allows users to create and publish posts by categories and interact with other users.

## Features

- User registration and authentication
![SignIn](https://github.com/BilalGumus/php-social-media/assets/57847805/d2d1a853-0f90-47a0-914c-28e51a98c154)
![SignUp](https://github.com/BilalGumus/php-social-media/assets/57847805/bab08d83-af2b-4f18-9c1a-b0a34c4b70a6)


- Create regular & image posts by categories
![Home](https://github.com/BilalGumus/php-social-media/assets/57847805/1e261a24-fc8d-4dd4-bc2e-bb6060320e23)
- Comment and like on posts
![Post_Detail](https://github.com/BilalGumus/php-social-media/assets/57847805/2d9ea3d5-6f3a-422a-b9a6-1954d83e3b02)
- User profile management
![Profile_Detail](https://github.com/BilalGumus/php-social-media/assets/57847805/866f4b2d-ac45-4a8a-97f8-72f8363a56ca)
![Profile_Edit](https://github.com/BilalGumus/php-social-media/assets/57847805/b102e8c6-e923-4993-a4b2-87a7154b9bdb)

## Installation
#### Requirements
* PHP
* Apache server
* MySQL Database
* SQL
* phpMyAdmin

> All of these requirements can be completed at once by simply installing a server stack like `Wamp` or `Xampp` etc. (`Xampp` is preferred)

#### Installation Steps
To install Selçuk Sözlük, follow these steps:

1. Clone the repository: `git clone https://github.com/BilalGumus/php-social-media.git`
2. Navigate to the project directory: `cd ./php-social-media`
3. Start a local Apache and MySQL development server.
3. Import the `database.sql` file in the `includes` folder into phpMyAdmin. There is no need for any change in the .sql file. This will create the database required for the application to function.
4. Edit the `db_connect.php` file in the `scripts` folder to create the database connection. Change the password and username to the ones being used within current installation of `phpMyAdmin`. There is no need to change anything else.
5. Open your web browser and visit `http://localhost/selcuk-sozluk`
#### Getting started
The database file already contains a lot of sample data and users. Most users in the database have the same password as "123456" except for admin. Although the admin & moderator user does not have any extra features in the project, admin password is set as "654321".

Therefore, you will have to create an account and manually go to the `role_id` table in the database to change the `role_id` of that account to `1``.
> 1 role id means a admin user
> 2 role id means a moderator user
> 3 role id means a regular user

## Usage

Once the installation is complete, you can use PHP Social Media Application as follows:

1. Register a new user account or log in with an existing account.
2. Fill in the required details and click "Gönderiyi Paylaş" button to publish your post.
3. Explore the different categories and view other users posts.
4. Leave comments and like on posts, follow other users and engage with the community.

## Contributing
Contributions to PHP Social Media Application are welcome! If you have any bug reports, feature requests, or improvements, please submit them as issues or create a pull request.

## License
PHP Social Media Application is released under the MIT License.

