FitBit SleepCharts is a free open source solution to Fitbit's outrageous premium subscription model. Why pay $50+ a year for something so simple?
Either find an installation of this, or simply deploy it yourself to heroku. Quick, easy, painless.

```
SetEnv ROOT http://localhost/FitBitSleepCharts/www/
SetEnv DB_DSN mysql://root@localhost/fitbit
SetEnv FITBIT_CLIENT **CLIENT STRING**
SetEnv FITBIT_SECRET **CLIENT SECRET**
SetEnv PRODUCTION 0  # Set this to 1 when you are on a production server
```

```
heroku create --buildpack https://github.com/TheSavior/heroku-buildpack-php
```