# 2ndLife

## Install Instructions

    git clone https://github.com/Aifos-Ana/2ndLife.git
    git checkout final-delivery-v1
    cd ./database
    sqlite foo.db < create.sql
    cd ..
    php -S localhost:8000

## Screenshots

**Homepage:**
![Homepage](https://github.com/Aifos-Ana/2ndLife/blob/final-delivery-v1/docs/homepage.png "Homepage")

**Profile page:**
![Profile](https://github.com/Aifos-Ana/2ndLife/blob/final-delivery-v1/docs/profile.png "Profile")

**Item page:**
![Item](https://github.com/Aifos-Ana/2ndLife/blob/final-delivery-v1/docs/item.png "Item")

## Implemented Features

**General**:

- [&check;] Register a new account.
- [&check;] Log in and out.
- [&check;] Edit their profile, including their name, username, password, and email.

**Sellers** should be able to:

- [&check;] List new items, providing details such as category, brand, model, size, and condition, along with images.
- [&check;] Track and manage their listed items.

**Buyers** should be able to:
- [&check;] Browse items using filters like category, price, and condition.
- [&check;] Add items to a wishlist or shopping cart.
- [&check;] Proceed to checkout with their shopping cart (simulate payment process).

**Admins** should be able to:
- [&check;] Introduce new item categories, sizes, conditions, and other pertinent entities.


**Security**:
We have been careful with the following security aspects:

- [&check;] **SQL injection**
- [&check;] **Cross-Site Scripting (XSS)**

**Password Storage Mechanism**: hash_password&verify_password

## Credentials

- **Admin** : jane.smith@example.com / password2
- **Seller** : john.doe@example.com / password1
- **Buyer** : buyer1@example.com / password3 <br>
  buyer2@example.com / password4
