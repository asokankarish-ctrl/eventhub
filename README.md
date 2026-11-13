# EventHub - Student Event Registration

A simple website where students can see upcoming events, register for one, and view, edit or delete registrations. It covers all four CRUD operations: Create, Read, Update and Delete.

Built with **HTML, CSS, JavaScript, PHP and MySQL** (no frameworks, no API).

## How to run it

1. Install XAMPP and start **Apache** and **MySQL**.
2. Copy the `eventhub` folder into `C:\xampp\htdocs\`.
3. Open `http://localhost/phpmyadmin`, click **Import**, choose `database.sql`, click **Import**.
4. Open `http://localhost/eventhub/`.

## Folder structure

```
eventhub/
├── index.php                 Events list (Read)
├── register.php              Registration form
├── save_registration.php     Validates and saves a registration (Create)
├── registrations.php         Table of registrations (Read with JOIN)
├── edit_registration.php     Edits a registration (Update)
├── delete_registration.php   Deletes a registration (Delete)
├── database.sql              Creates the database and sample events
├── includes/
│   ├── db.php                Database connection
│   ├── header.php            Top of every page + menu
│   └── footer.php            Bottom of every page
├── css/style.css             Styling
└── js/script.js              Search, form checks, delete confirm
```

## Team

| # | Name | Part | Files |
|---|------|------|-------|
| 1 | N.Dilakshan | Database | `database.sql`, `includes/db.php` |
| 2 | | Layout and navigation | `includes/header.php`, `includes/footer.php` |
| 3 |A.Anojan | Events list | `index.php` |
| 4 | | Registration form | `register.php` |
| 5 | R.Thushanan | Form processing | `save_registration.php` |
| 6 | | Registrations list | `registrations.php` |
| 7 | J.Athavan | Delete feature | `delete_registration.php` |
| 8 | S.Santhosan | Styling | `css/style.css` |
| 9 | T.Sangeethan | JavaScript | `js/script.js` |
| 10 | S.Narendran | Edit feature and GitHub | `edit_registration.php`, `README.md` |
