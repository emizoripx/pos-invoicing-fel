# POS INVOICING FEL PACKAGE v1.0.4

## Library manage electronic invoices from a POS

## Installation

- Only if not installed
    
    `composer require emizoripx/pos-invoicing-fel`
### STEP 1
- `php artisan migrate` for creating new tables of package

## Instructions for development
for development in a local environment
- create a folder named `package` in the project directory
- Enter the directory created and clone the repository `https://github.com/emizoripx/pos-invoicing-fel.git`
- Add the following line to the `composer.json` file of the project
```json
    "autoload": {
        "psr-4": {
            ...
            "EmizorIpx\\PosInvoicingFel\\" : "package/pos-invoicing-fel/src/"
        }
    },
```
- Then in the terminal run the command
```
    docker-compose exec app composer dumpautoload
```
```
    docker-compose exec app php artisan optimize
```