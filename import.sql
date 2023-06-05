CREATE DATABASE IF NOT EXISTS project3;

USE project3;

CREATE TABLE productlines (
    productLine VARCHAR(255) PRIMARY KEY,
    textDescription TEXT,
    htmlDescription TEXT,
    image TEXT
);

CREATE TABLE products (
    productCode INT PRIMARY KEY,
    productName VARCHAR(255),
    productLine VARCHAR(255),
    productScale VARCHAR(255),
    productVendor VARCHAR(255),
    productDescription TEXT,
    quantityInStock INT,
    buyPrice INT,
    MSRP INT,
    FOREIGN KEY (productLine) REFERENCES productlines(productLine)
);

CREATE TABLE orders (
    orderNumber INT PRIMARY KEY,
    orderDate DATE,
    requiredDate DATE,
    shippedDate DATE,
    status VARCHAR(255),
    comments TEXT,
    customerNumber INT
);

CREATE TABLE customers (
    customerNumber INT PRIMARY KEY,
    customerName VARCHAR(255),
    contactLastName VARCHAR(255),
    contactFirstName VARCHAR(255),
    phone VARCHAR(255),
    addressLine1 VARCHAR(255),
    addressLine2 VARCHAR(255),
    city VARCHAR(255),
    state VARCHAR(255),
    postalCode VARCHAR(255),
    country VARCHAR(255),
    salesRepEmployeeNumber INT,
    creditLimit INT
);

CREATE TABLE orderdetails (
    orderNumber INT,
    productCode INT,
    quantityOrdered INT,
    priceEach INT,
    orderLineNumber INT,
    PRIMARY KEY (orderNumber, productCode),
    FOREIGN KEY (orderNumber) REFERENCES orders(orderNumber),
    FOREIGN KEY (productCode) REFERENCES products(productCode)
);

ALTER TABLE orders
ADD FOREIGN KEY (customerNumber) REFERENCES customers(customerNumber);

CREATE TABLE offices (
    officeCode INT PRIMARY KEY,
    city VARCHAR(255),
    phone VARCHAR(255),
    addressLine1 VARCHAR(255),
    addressLine2 VARCHAR(255),
    state VARCHAR(255),
    country VARCHAR(255),
    postalCode VARCHAR(255),
    territory VARCHAR(255)
);

CREATE TABLE employees (
    employeeNumber INT PRIMARY KEY,
    lastName VARCHAR(255),
    firstName VARCHAR(255),
    extension VARCHAR(255),
    email VARCHAR(255),
    officeCode INT,
    reportsTo INT,
    jobTitle VARCHAR(255),
    FOREIGN KEY (officeCode) REFERENCES offices(officeCode),
    FOREIGN KEY (reportsTo) REFERENCES employees(employeeNumber)
);

ALTER TABLE customers
ADD FOREIGN KEY (salesRepEmployeeNumber) REFERENCES employees(employeeNumber);

CREATE TABLE payments (
    customerNumber INT,
    checkNumber INT,
    paymentDate DATE,
    amount INT,
    PRIMARY KEY (customerNumber, checkNumber),
    FOREIGN KEY (customerNumber) REFERENCES customers(customerNumber)
);
