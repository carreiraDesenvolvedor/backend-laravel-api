<h1 align="center">
  News Feed App
</h1>

## 🚀 Demo

<p align="left">
    <a href="" target="_blank"><b>Clique here to see a Live Demo</b></a>
</p>

## 🛠️ Installation Steps

1. Clone the repository

```bash
git clone https://github.com/carreiraDesenvolvedor/backend-laravel-api.git
```

2. Change the working directory

```bash
cd backend-laravel-api
```

3. Install dependencies

```bash
php composer.phar install
```

4. Setup the .env file and application key

```bash
 cp .env.example .env
 php artisan key:generate
```

5. Run the Containers(Using Sail)

```bash
./vendor/bin/sail up
```

5. Open a new terminal to generate the JWT Secret

```bash
  #Only run this command if you are not inside the project folder after opened a new terminal
  cd backend-laravel-api
  
  #creating the JWT Secret
  ./vendor/bin/sail php artisan jwt:secret
```

🌟 You are all set the api is running over the port 80!

## 💻 Built with

- [Laravel](https://laravel.com/docs/10.x)
- [Mysql](https://www.mysql.com/): For Database
- [Laravel Sail](https://laravel.com/docs/10.x/sail): For Docker Containerization

<hr>
<p align="center">
Developed by Jonathan Melo
</p>
