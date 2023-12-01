# Write Data to Database with CLI

## Introduction

This Laravel project includes a custom Artisan command, `XmlStructure`, designed to inspect an XML file, transform its structure, and store the data in a database. This can be particularly useful for handling XML data seamlessly in a Laravel application.

## Prerequisites

Before using the `XmlStructure` command, make sure to follow these steps:

1. Upload the XML file you want to process into the `storage/app/uploads/` directory.
2. Ensure your Laravel environment is properly configured, and the database connection details are set in the `.env` file.

## Installation

No additional installation steps are required. The command is ready to use once you've uploaded your XML file.

## Usage

Execute the following command in your terminal to see the uploaded file content in JSON format:

```bash
php artisan xml:inspect {filename}

# Example:
php artisan xml:inspect feed.xml

```

## Ensure the database connection details in your .env file are accurate:

DB_CONNECTION=mysql                       # Database connection type (e.g., mysql)
DB_HOST=localhost                         # Database host (e.g., localhost)
DB_PORT=3306                              # Database port (usually 3306 for MySQL)
DB_DATABASE=laravel_project               # Database name
DB_USERNAME=root                          # Database username
DB_PASSWORD=                              # Database password
