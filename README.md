## TokoJawahir - Jewelry Store Management & E-Commerce System

TokoJawahir is a full-stack web application built to digitalize the entire business process of a traditional jewelry store. This project was conceived after a direct interview with a store owner to address their real-world operational challenges. The system provides a comprehensive solution for product management, sales transactions, and a unique digital buy-back process.

## The Problem

Traditional jewelry stores often operate with manual, paper-based systems for sales and buy-backs. This leads to several critical issues:

* Inefficiency: Locating past transaction details for a customer's buy-back request is slow and cumbersome.
* Risk of Data Loss: Physical receipts can be lost by the customer or damaged, complicating the buy-back process.
* Lack of Digital Presence: The store has no online catalog, limiting its reach and preventing customers from browsing products from home.

TokoJawahir was built to solve these problems by creating a single, centralized, and efficient digital platform.

## Key Features

This application is divided into modules that reflect the real-world workflow of the jewelry store.

**1. Authentication & Authorization**
* Role-Based Access: Separate login and registration systems for Admin (Store Owner) and Customers.
* Secure authentication to protect user data and transaction history.

**2. Product & Catalog Management (Admin)**
* Full CRUD Functionality: The admin can easily Create, Read, Update, and Delete jewelry products in the catalog.
* Dynamic Pricing: Product details, especially prices, can be updated quickly to reflect fluctuating gold prices.
* Public Catalog: A beautifully displayed product list for customers, complete with images, weight, karat, and price details.

**3. E-Commerce & Sales Workflow**
* Shopping Cart System: Customers can add multiple items to their cart for a seamless shopping experience.
* Order Management: The admin has a dedicated dashboard to view incoming orders, manage stock, and confirm transactions upon successful payment.
* Customer Purchase History: Every customer has a personal dashboard to view their complete purchase history.

**4. Digital Buy-Back Module (Core Innovative Feature)**
* Digital Verification: Eliminates the need for physical receipts. The admin can securely look up a customer's entire purchase history simply by searching for their registered phone number.
* Streamlined Process: The admin can select the specific item to be bought back from the customer's history.
* Dynamic Price Calculation: The system allows for price deductions (e.g., for damage) to be entered manually, providing flexibility for the admin to determine the final buy-back price.
* Transaction Logging: All buy-back transactions are recorded digitally, ensuring transparency for both the store and the customer.

## Tech Stack

This project was built using a modern, full-stack approach with the TALL Stack:

* Back-End: PHP, Laravel
* Front-End / Full-Stack: Livewire, Alpine.js, Tailwind CSS
* Database: MySQL
* Version Control: Git

## Testing & Code Quality

This project was developed with a strong emphasis on code quality and reliability. It features a robust testing suite and automated tooling to ensure all business logic functions as expected.

* Unit & Feature Tests: Written using Pest/PHPUnit to cover critical components like user authentication, product management, and the transaction process.
* Test-Driven Approach: Key functionalities were developed following a Test-Driven Development (TDD) methodology to ensure code is predictable and maintainable.
* Code Style Consistency: Utilizes Laravel Pint to automatically enforce a clean and consistent code style across the entire codebase, improving readability and maintainability.
* High Code Coverage: The test suite aims for high code coverage to minimize bugs and allow for confident refactoring.

## Screenshots

*(This is where you will place your screenshots. A great README always includes visuals!)*

**Customer Product Catalog**
*(Replace this with a screenshot of your product page)*

**Admin Dashboard**
*(Replace this with a screenshot of the admin's order management view)*

**Digital Buy-Back Process**
*(Replace this with a screenshot of the buy-back feature in action)*

## Installation and Setup

To run this project locally, follow these steps:

1.  **Clone the repository:**
    git clone https://github.com/AtaKimi/TokoJawahir.git
    cd TokoJawahir

2.  **Install dependencies (PHP & JS):**
    composer install
    npm install

3.  **Setup your environment file:**
    * Copy .env.example to a new file named .env.
    * Run `php artisan key:generate`.
    * Configure your database details in the .env file.

4.  **Run database migrations:**
    php artisan migrate

5.  **(Optional) Seed the database with dummy data:**
    php artisan db:seed

6.  **Run the development server:**
    npm run dev
    And in a separate terminal:
    php artisan serve

The application should now be running on http://127.0.0.1:8000.
