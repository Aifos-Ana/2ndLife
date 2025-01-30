# 2ndLife

## Group ltw00g00

- Ana Sofia Pinto (up202004606) 100%
- Daniel Novais (201909711) 0%

## Install Instructions

    git clone https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw02g09.git
    git checkout final-delivery-v1
    cd ./database
    sqlite foo.db < create.sql
    cd ..
    php -S localhost:8000

## Screenshots

**Homepage:**
![Homepage](https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw02g09/blob/master/docs/homepage.png "Homepage")

**Profile page:**
![Profile](https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw02g09/blob/master/docs/profile.png "Profile")

**Item page:**
![Item](https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw02g09/blob/master/docs/item.png "Item")

## Implemented Features

**General**:

- [&check;] Register a new account.
- [&check;] Log in and out.
- [&check;] Edit their profile, including their name, username, password, and email.

**Sellers** should be able to:

- [&check;] List new items, providing details such as category, brand, model, size, and condition, along with images.
- [&check;] Track and manage their listed items.
- [ ] Respond to inquiries from buyers regarding their items and add further information if needed.
- [ ] Print shipping forms for items that have been sold.

**Buyers** should be able to:

- [&check;] Browse items using filters like category, price, and condition.
- [ ] Engage with sellers to ask questions or negotiate prices.
- [&check;] Add items to a wishlist or shopping cart.
- [&check;] Proceed to checkout with their shopping cart (simulate payment process).

**Admins** should be able to:

- [ ] Elevate a user to admin status.
- [&check;] Introduce new item categories, sizes, conditions, and other pertinent entities.
- [ ] Oversee and ensure the smooth operation of the entire system.

**Security**:
We have been careful with the following security aspects:

- [&check;] **SQL injection**
- [&check;] **Cross-Site Scripting (XSS)**
- [ ] **Cross-Site Request Forgery (CSRF)**

**Password Storage Mechanism**: hash_password&verify_password

**Aditional Requirements**:

We also implemented the following additional requirements (you can add more):

- [ ] **Rating and Review System**
- [ ] **Promotional Features**
- [ ] **Analytics Dashboard**
- [ ] **Multi-Currency Support**
- [ ] **Item Swapping**
- [ ] **API Integration**
- [ ] **Dynamic Promotions**
- [ ] **User Preferences**
- [ ] **Shipping Costs**
- [ ] **Real-Time Messaging System**

## Credentials

- **Admin** : jane.smith@example.com / password2
- **Seller** : john.doe@example.com / password1
- **Buyer** : buyer1@example.com / password3 <br>
  buyer2@example.com / password4
