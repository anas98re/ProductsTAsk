# ProductsTAsk
To set up and run the "ProductsTask" project, please follow these steps:

1: Install Dependencies:

Run the following command to install the project dependencies:

composer install

2: Create a Database:

Using PHPMyAdmin or any other MySQL database management tool, create a new database for the project.

3: Configure Database Connection:

Rename the .env.example file in the project root directory to .env.
Open the .env file and update the following variables to match your database configuration:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
Replace your_database_name, your_username, and your_password with your actual database credentials.

4: Run Database Migrations:

Run the following command to create the necessary database tables:

php artisan migrate

5: Start the Server:

Run the following command to start the development server:

php artisan serve

6: Create Symbolic Link for Images:
Run the following command to create a symbolic link for the storage directory to the public directory:

php artisan storage:link

This command will create a symbolic link that allows access to files stored in the storage/app/public directory from the public/storage directory.
This step is necessary if you plan to store and serve images or other files from the storage directory.
