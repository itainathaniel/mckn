## Me

Hi, I'm Itai Nathaniel. I'm doing PHP for ~25 years now, and Laravel for ~10 years.

## Installation

I've attached a `.env.example` file with all the relevant data. You will only have to setup the DB name, user and password and save it as a `.env` file, using a command like

```
cp .env.example .env
```

or with some mouse and keyboard clicks.

After that, you'll have to run the migrations using the following command:

```
php artisan migrate
```

## The Project

I ran it with Larael Valet, but then remembered I can't trust you have it so I used these two commands to run the project:

```
php artisan serve --host=meckano.test
npm run dev
```

It should run on port 8000. You can then go to the URL http://meckano.test:8000. You'll have to register first on http://meckano.test:8000/register, but other than that - all good.
