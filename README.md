<p align="center">
  <h3 align="center">Guthand Payment App</h3>
  <p align="center">
    A mock banking / finance webapp written in PHP
  </p>
</p>

<br>

<!-- TABLE OF CONTENTS -->
## Table of Contents

- [Table of Contents](#table-of-contents)
- [About The Project](#about-the-project)
- [Installation](#installation)
  - [Install dependencies and build](#install-dependencies-and-build)
  - [Database](#database)
- [Contact](#contact)

<br><br>

<!-- ABOUT THE PROJECT -->
## About The Project

![Screen Shot][screenshot]

<br>

## Installation

To get a local copy up and running clone this repo.
If you intend to run it inside an apache2 environment,
you need to create a virtual host and set the `DocumentRoot`
to the `public` directory.

### Install dependencies and build

1. Clone the repo
```sh
git clone https://github.com/FlmBus/guthand-payment-app.git
```
2. Install NPM packages and build frontend
```sh
npm install
npm run build
```
3. Install composer dependencies
```sh
composer install
```

### Database

Inside the database.sql file in the root directory of this project
is the structure of the MySQL database, as well as some test data.
Just import that into your database. All users have `'secret'` as their password

## Contact

Project Link: [https://github.com/FlmBus/guthand-payment-app](https://github.com/FlmBus/guthand-payment-app)

[screenshot]: docs/screenshot.png
