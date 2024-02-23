# TylerAir   

![Screenshot_20230109_095726](https://github.com/Tylereck81/TylerAir/assets/68008817/cf1d4aef-055c-4a61-b3f9-24a8035b62ac)


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

## User View 
### TylerAir Homepage 
![1](https://github.com/Tylereck81/TylerAir/assets/68008817/53463462-6fc1-4451-b260-6d6673afd35a)

### Query Flights
![2](https://github.com/Tylereck81/TylerAir/assets/68008817/3bfdd327-1311-432e-be69-15d12aab446f)

### Sign up -  * Users must have an account to book tickets *
![3](https://github.com/Tylereck81/TylerAir/assets/68008817/5767c8b0-f869-4307-a567-06056533cc96)

![4](https://github.com/Tylereck81/TylerAir/assets/68008817/f5fdaf66-142d-4e93-90dd-af497aa7d647)

### Confirmation of Ticket
![5](https://github.com/Tylereck81/TylerAir/assets/68008817/bf8b168e-64ea-4b5a-8a50-98830d6ff2af)

### My Flights 
![6](https://github.com/Tylereck81/TylerAir/assets/68008817/e2127de9-7890-4e21-9e26-279633d09a60)

### Cancel Flights 
![7,1](https://github.com/Tylereck81/TylerAir/assets/68008817/65898e81-7200-4a34-a938-3ea85b1f6bd4)

## Admin View   
### Admin Login
![a1](https://github.com/Tylereck81/TylerAir/assets/68008817/8a444609-f2ee-4652-b28d-9f82e1c6893f)

### Admin Homepage 
![a2](https://github.com/Tylereck81/TylerAir/assets/68008817/0569c592-62f4-4333-bf89-1921c3c94feb)

### Add Flights
![a3](https://github.com/Tylereck81/TylerAir/assets/68008817/dc944ef0-114a-46e7-a5d3-f9717823b702)

### Manage Flights (Query/Cancel Flights) 
![a4](https://github.com/Tylereck81/TylerAir/assets/68008817/f5b2b3bb-ad2c-4008-817e-f752c9b2f974)

### Successful Cancelling of Flight 
![a5](https://github.com/Tylereck81/TylerAir/assets/68008817/7d6b8982-a930-4b22-9761-c2db9d986049)
![a6](https://github.com/Tylereck81/TylerAir/assets/68008817/6b6bb775-896f-4c79-b800-8528f827b6ea)





