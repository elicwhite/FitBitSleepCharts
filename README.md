FitBit SleepCharts
------------------

A free open source solution to Fitbit's outrageous premium subscription model. Why pay $50+ a year for something so simple?
Either find an installation of this, or simply deploy it yourself to heroku. Quick, easy, painless.

Sign up for a new fitbit api key.
=================================
https://dev.fitbit.com/apps/new
Callback URL doesn't matter. And you only need Read-only access.

Set Environment Variables in a .htaccess file
=============================================
```
SetEnv ROOT http://localhost/FitBitSleepCharts/www/
SetEnv DB_DSN mysql://root@localhost/fitbit
SetEnv FITBIT_CLIENT **CLIENT STRING**
SetEnv FITBIT_SECRET **CLIENT SECRET**
SetEnv PRODUCTION 0  # Set this to 1 when you are on a production server
```

Deploying to Heroku
================
```
>heroku create --buildpack https://github.com/TheSavior/heroku-buildpack-php
Creating gentle-river-5868... done, stack is cedar
BUILDPACK_URL=https://github.com/TheSavior/heroku-buildpack-php
http://gentle-river-5868.herokuapp.com/ | git@heroku.com:gentle-river-5868.git

>heroku addons:add cleardb:ignite
Adding cleardb:ignite on gentle-river-5868... done, v5 (free)

>heroku config
=== gentle-river-5868 Config Vars
BUILDPACK_URL:        https://github.com/TheSavior/heroku-buildpack-php
CLEARDB_DATABASE_URL: mysql://...:...@....cleardb.com/...?reconnect=true

>heroku config:add DB_DSN=mysql://...:...@....cleardb.com/...?reconnect=true
Setting config vars and restarting gentle-river-5868... done, v6
DB_DSN: mysql://...:...@....cleardb.com/...?reconnect=true

>heroku config:add ROOT=http://gentle-river-5868.herokuapp.com/
Setting config vars and restarting gentle-river-5868... done, v7
ROOT: http://stark-headland-5971.herokuapp.com/

>heroku config:add FITBIT_CLIENT=**CLIENT STRING**
Setting config vars and restarting gentle-river-5868... done, v8
FITBIT_CLIENT: d309d935df0b415e84721ef9c40c2379

>heroku config:add FITBIT_SECRET=**CLIENT SECRET**
Setting config vars and restarting gentle-river-5868... done, v9
FITBIT_SECRET: 64cff6931e0547a8b403dad81c5ba664
```

Then, to configure your database hit the url:

```
http://blah-blah-num.herokuapp.com/Setup/install (with your own herokuapp)
```

Now we need to turn production mode on so that other people can't hit that url later
```
>heroku config:add PRODUCTION=1
Setting config vars and restarting gentle-river-5868... done, v10
PRODUCTION: 1
```
