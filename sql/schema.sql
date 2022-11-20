CREATE DATABASE Getaway;
USE Getaway;

-- Customer Accounts
CREATE TABLE Customer (
    ID              INT NOT NULL UNIQUE AUTO_INCREMENT,
    FirstName       VARCHAR(255) NOT NULL ,
    LastName        VARCHAR(255) NOT NULL,
    Email           VARCHAR(255) NOT NULL,
    PhoneNumber     VARCHAR(255) NOT NULL,
    AccountPassword VARCHAR(255) NOT NULL, -- This will be hashed
    PRIMARY KEY (ID)
);

-- Hotel listings shown on the website
CREATE TABLE Hotel (
    ID INT NOT NULL UNIQUE AUTO_INCREMENT,
    HotelName           VARCHAR(255) NOT NULL,
    HotelDescription    VARCHAR(1024) NOT NULL,
    ContactNumber       VARCHAR(255) NOT NULL,
    ContactEmail        VARCHAR(255) NOT NULL,
    StreetAddress       VARCHAR(255) NOT NULL,
    City                VARCHAR(255) NOT NULL,
    Postcode            VARCHAR(255) NOT NULL,
    Country             VARCHAR(255) NOT NULL,
    Price               FLOAT NOT NULL,
    AvailableRooms      INT NOT NULL,
    PRIMARY KEY (ID)
);

-- Table of hotel bookings made by customers
CREATE TABLE Booking (
    ID          INT NOT NULL UNIQUE AUTO_INCREMENT,
    CustomerID  INT NOT NULL,
    HotelID     INT NOT NULL,
    Datefrom    DATETIME NOT NULL,
    DateTo      DATETIME NOT NULL,
    Guests      TINYINT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY(CustomerID) REFERENCES Customer(ID),
    FOREIGN KEY(HotelID) REFERENCES Hotel(ID),
    CHECK (Guests > 0 AND Guests < 5) -- There can be no more than 4 guests in a room, and no less than 0 guests in a room
);

-- Reviews for the hotels listed on the website
CREATE TABLE Review (
    ID          INT NOT NULL UNIQUE AUTO_INCREMENT,
    CustomerID  INT NOT NULL,
    HotelID     INT NOT NULL,
    Rating      TINYINT NOT NULL,
    Review      TEXT(1024),
    PRIMARY KEY (ID),
    FOREIGN KEY(CustomerID) REFERENCES Customer(ID),
    FOREIGN KEY(HotelID) REFERENCES Hotel(ID),
    CHECK(Rating > 0 AND Rating <= 5) -- System uses a 5 star rating so value has to be between 1 and 5
);

-- The gallery stores image urls to be displayed for each hotel listing
CREATE TABLE Gallery (
    ID              INT NOT NULL UNIQUE AUTO_INCREMENT,
    HotelID         INT NOT NULL,
    ImageURL        VARCHAR(255) NOT NULL,
    PrimaryImage    BOOLEAN NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY(HotelID) REFERENCES Hotel(ID)
);

-- The admin can add/update/remove hotel listings and images from the gallery
CREATE TABLE Admin (
    ID              INT NOT NULL UNIQUE AUTO_INCREMENT,
    Email           VARCHAR(255) NOT NULL,
    AccountPassword VARCHAR(255) NOT NULL, -- This will be hashed
    PRIMARY KEY (ID)
);

CREATE TABLE SupportRequest (
    ID              INT NOT NULL UNIQUE AUTO_INCREMENT,
    Email           VARCHAR(255) NOT NULL,
    RequestSubject  VARCHAR(255) NOT NULL,
    RequestMessage  VARCHAR(2048) NOT NULL,
    Resolved        BOOLEAN NOT NULL,
    PRIMARY KEY (ID)
);