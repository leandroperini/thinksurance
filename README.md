# Thinksurance

This is a thech demo for Thinksurance

---

1. [Installing](#installing)

1. [How to use](#how-to-use)

    1. [Exchange Rates API](#exchange_rates_api)
        1. [Get latest](#get_latest)
        1. [Get by date](#get_by_date)
        1. [Get in history by date range](#get_in_history)

    1. [PigLatin Suite](#piglatin_suite)
        1. [Check if the word is PigLatin](#check_the_word)
        1. [Translate the word to PigLatin](#translate_the_word)
        1. [Analyze the word in relation to PigLatin](#analyze_the_word)

    1. [Login, Role and Permissions](#login_role_permissions)
        1. [Sign up](#sign_up)
        1. [Listing Users](#list_users)
        1. [Login](#login)
        1. [Check user info (E.g. Roles and Permissions)](#check_user_info)

1. [Code Considerations and Thoughts](#considerations)

---

## <a id="installing"></a>Installing

To install the project is necessary to have installed the following:

- [docker](https://docs.docker.com/get-docker/)
- [docker-compose](https://docs.docker.com/compose/install/)

If all prerequisites are addressed, go to the git clone destination and run:

```
    docker-compose up -d
```

After Docker is done creating the containers, that's required to download all dependencies, setup the database and create
the dummy data.

```
    docker-compose exec php composer install && \
    docker-compose exec php symfony console doctrine:migrations:migrate && \
    docker-compose exec php symfony console doctrine:fixtures:load
```

Answer `yes` to every question asked.

When everything is done, add to the hosts file, the site domain, like so:

```
    127.0.0.1 thinksurance.local
```

---

## <a id="how_to_use"></a>How to use

### <a id="exchange_rates_api"></a>Exchange Rates API

All the endpoints available at this section follows the rules and accepts the params described at the source API page:

> [https://exchangeratesapi.io/](https://exchangeratesapi.io/)

#### <a id="get_latest"></a>Get latest

> [http://thinksurance.local:8080/exchange/rates/latest](http://thinksurance.local:8080/exchange/rates/latest)

#### <a id="get_by_date"></a>Get by date

> [http://thinksurance.local:8080/exchange/rates/2021-01-01](http://thinksurance.local:8080/exchange/rates/2021-01-01)

#### <a id="get_in_history"></a>Get in history by date

> [http://thinksurance.local:8080/exchange/rates/history?start_at=2021-01-01&end_at=2021-01-22](http://thinksurance.local:8080/exchange/rates/history?start_at=2021-01-01&end_at=2021-01-22)

---

### <a id="piglatin_suite"></a>PigLatin Suite

A suite to analyze, check and convert words to PigLatin, following the rules described at
the [PigLatin Wiki](https://en.wikipedia.org/wiki/Pig_Latin)

#### <a id="get_in_history"></a>Check if the word is PigLatin

This will check if the word `example` is in PigLatin

> [http://thinksurance.local:8080/pig-latin/check/example](http://thinksurance.local:8080/pig-latin/check/example)

#### <a id="translate_the_word"></a>Translate the word to PigLatin

This will translate the word `example` to PigLatin

> [http://thinksurance.local:8080/pig-latin/convert/example](http://thinksurance.local:8080/pig-latin/convert/example)

#### <a id="analyze_the_word"></a>Analyze the word in relation to PigLatin

This will analyze and return all information about the word `example` related to PigLatin such as if it is or not in
PigLatin and in case of not, it's translation.

> [http://thinksurance.local:8080/pig-latin/example](http://thinksurance.local:8080/pig-latin/example)

---

### <a id="login_role_permissions"></a>Login, Roles and Permissions
    
This section allows the access, only through login, the visualization of the roles and permissions of the logged-in user

#### <a id="sign_up"></a>Sign up

Allow to register a new user with the default role, and it's permissions.

> [http://thinksurance.local:8080/register](http://thinksurance.local:8080/register)

#### <a id="login"></a>Login

Do the login in the system, allowing access to restricted pages

> [http://thinksurance.local:8080/login](http://thinksurance.local:8080/login)

#### <a id="list_users"></a>Listing Users

Lists all usernames available in the database in the format of `user_{password}` to allow testing the roles and permissions listing of the selected user

> [http://thinksurance.local:8080/user/list](http://thinksurance.local:8080/user/list)

#### <a id="check_user_info"></a>Check user info (E.g. Roles and Permissions)

This is the restricted page that shows all access info for the logged-in user

> [http://thinksurance.local:8080/user/admin](http://thinksurance.local:8080/user/admin)

---

## <a id="considerations"></a>Code Considerations and Thoughts

All over the code there are comments prefixed with `-note:` those are messages and development thoughts to explain why something is the way it is, those comments also show some improvements that could be made. Most of the comments are auto generated by the IDE, and I kept the most part of it because it makes intellisense and Go To more accurate.

This project was made using Symfony to better show some coding habilites that could help Thinksurance  to achieve its goals and to help to reduce some time in non-relevant areas, such as the front-end and migrations. The database chosen was MySQL because it's free, widely used, and I have great knowledge and experience using it. 

I would like that I've had more time to make more tests to show up some mocking in action. It would also have been nice if I've used some AWS integrations such as DynamoDB for NoSQL, Python lambdas for the PigLatin portion, and using some cache such Redis.

There is also a huge space for improvement security-wise, specially about the credentials on Docker and env files. The exception handling could also be more implemented and wide.

This project's UX is poor, I would have made different if there were more time in my day to focus on this project.

I hope you like this teaser of my work and feel free to critique it.

My contacts are:

 - Email: perini105@gmail.com
   
 - Skype: leandro.perini.it

