# PagePulse - Book Recommendation System

PagePulse is a book recommendation system that suggests books based on the most read pages entered by the user. This system aims to provide personalized book recommendations to users, helping them discover new books based on their reading preferences.

## Table of Contents

-   [About PagePulse](#about-pagepulse)
-   [Getting Started](#getting-started)
-   [Usage](#usage)
-   [Unit Tests](#unit-tests)
-   [API Documentation](#api-documentation)
-   [License](#license)

## About PagePulse

PagePulse is built using Laravel, a web application framework with expressive and elegant syntax. It leverages Laravel's powerful features such as routing, dependency injection, database ORM, and background job processing to create a seamless and enjoyable user experience.

## Getting Started

To run the PagePulse project locally, follow these steps:

1. Clone the repository:

    ```bash
    git clone https://github.com/NourhanAymanElstohy/page-pulse
    ```

2. Install the project dependencies using Composer:

    ```bash
    composer install
    ```

3. Create a copy of the `.env.example` file and rename it to `.env`. Update the necessary configuration values such as database credentials.

4. Generate an application key:

    ```bash
    php artisan key:generate
    ```

5. Run the database migrations:
    ```bash
    php artisan migrate
    ```
6. Run the database seeds:

    ```bash
    php artisan db:seed
    ```

7. Start the development server:

    ```bash
    php artisan serve
    ```

8. Access the application in your web browser at `http://localhost:8000`.

## Usage

Once the PagePulse application is up and running, you can start using it to get book recommendations based on the most read pages. Here's how:

1. Enter the most read pages of the book that you have read..

2. PagePulse will analyze your reading preferences and recommend the 5 books that have the most unique pages read.

This happens using below apis:

-   **POST /submit-user-interval**: This API allows you to submit the reading interval of a user. It expects a JSON payload with the following structure:

    ```json
    {
        "user_id": "1",
        "book_id": "1",
        "start_page": 10,
        "end_page": 30
    }
    ```

    The API will store the user's reading interval for future recommendation calculations.

-   **GET /get-recommended-books**: This API returns the most 5 recommended books based on the most read unique pages entered by the user. Example usage:
    ```
    GET /get-recommended-books
    ```
    The API will return a JSON response with the recommended books.

## Unit Tests

PagePulse includes a comprehensive suite of unit tests to ensure the stability and correctness of the codebase. To run the unit tests, follow these steps:

1. Open a terminal or command prompt.
2. Navigate to the root directory of the PagePulse project.
3. Run the following command to execute the unit tests:

    ```bash
    php artisan test
    ```

    This command will run all the unit tests defined in the `tests` directory and display the test results in the terminal.

    Note: Make sure you have already installed the project dependencies using Composer (step 2 in the "Getting Started" section) before running the tests.

## API Documentation

The API documentation for PagePulse is available [here](http://127.0.0.1:8000/api/documentation).

You can also access the Postman collection for the API [here](https://drive.google.com/file/d/1GqrN18X90UclwayUkVNHkNRqvv301569/view?usp=sharing).

## License

PagePulse is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). Feel free to use, modify, and distribute the code as per the terms of the license.
