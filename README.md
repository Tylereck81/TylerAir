# TylerAir

Author: Tyler Edwardo Eck      
Class: Database Systems   
Professor: 吳秀陽  (Shiow-Yang Wu)     

## Introduction 
TylerAir is a website that was designed and implemented for my final project for the 2022 Database System class. TylerAir is a local airline company that aims to offer cheap and direct flights to and from the multiple airports located in Taiwan. These 13 airports are located all around Taiwan and have a unique airport ID that is globally recognized. Due to its locality, all the flights offered are in the same time zone and are flown in one day (no over night flights). Moreover, booking flights for users and adding flights for admin should be done at least one day in advance due to the complexities that are associated with flight systems. 

## Functionality
The TylerAir website allows for two views that each have their own seperate set of functionalities: User view and Admin View.

### Users of the TylerAir website can:  
1. Register/Sign Up - register and sign up by entering personal information for account
2. Login/Logout - login with username/email and password and logout of account
3. Query Flights - selecting departure city, departure date, return city, and return date
4. Book Tickets - confirm date with passport information along with baggage number
5. View Booked Tickets - view all booked tickets including previous, future, and cancelled tickets
6. Cancel Tickets - cancel tickets for upcoming flights
7. View/Update Personal Information - change password, address, phone number, etc.

### The Admin of TylerAir website can: 
1. Login/Logoout - must have admin privledges in order to login and view admin page
2. View Today's Flights - homepage shows a view of today's flights and cancelled flights
3. Add Flights - add a flight to the database with information such as departure/return cities, prices for first class/economy, and schedule
4. Query Flights - same as user's function for querying flights
5. Cancel Flights - cancel an upcoming  flight (would automatically cancel a user's ticket for that flight)
6. Change Flight Information - change flight number, schedule, and airplane for a flight

## Relational Schema 
![relational schema](https://github.com/Tylereck81/TylerAir/assets/68008817/87437bc9-e3cb-4e44-99b0-dda4d1fb3b43)

## ER/EER Diagram 
![ERD](https://github.com/Tylereck81/TylerAir/assets/68008817/4d8312bc-e85f-414a-9511-4839e86a2de2)

## Pictures 

