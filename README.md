# Am API Plugin

This plugin is an assignment test for an Awesome Motive's WordPress Developer role.

## Get Started

Before anything, you have to install all the dependencies. To do so, just run:

``
    npm install && composer install
``

### Development mode

To start working on development mode, make sure to have set the .env file like this:

```
AM_MODE = "dev" 

AM_DEV_PORT = 3030
AM_DEV_SERVER = "http://localhost:${AM_DEV_PORT}/"
```

Note that `AM_MODE` is set to `dev`. Then run `npm run dev` in your terminal

### Production mode

To have the production mode ready, just run `npm run build`, then make sure to change your .env like this:


```
AM_MODE = "prod" 

AM_DEV_PORT = 3030
AM_DEV_SERVER = "http://localhost:${AM_DEV_PORT}/"
```