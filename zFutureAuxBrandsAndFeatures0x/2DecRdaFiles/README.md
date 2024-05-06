# RdaDev

## Main Features

- Ask question
- Questions
- Messages

## Developer Notes

Most of the code has been written in procedural style especially for the main pages of the core functionality of the platform. 

There are some functionalites that have been written with the MVC coding paradigm in mind.

## Configuration

Inside the file _config.php_ you can find all the configuration parameters.

## Controllers
The folder 'controllers' contains these major files which handle the main functionality of the main features:

- bids_controller.php ( interaction of the bidding process , bid, accept, reject )
- question_controller.php ( ask questions, list )
- chat_controller.php (list messages, lists chat channels, send_message)
- upload_controller.php (upload a file as an atatchment to a question, create secure folder structure)

## Models

Inside the models folder there is a class to handle most common sql actions

## Views

This folder contains repetitive HTML snippets of various HTML pages. The code is pure HTML and inside it it has pre-define placeholders. Inside the controller after we get the data we do a replacement of these placeholders with the real data.
Keep it as simple as possible.
You might find more than one file for the same purpose. Usually the one with the placeholders is used.

## Assets

Inside the assets folder there are the main styling files:

- css folder has all the css files, for each main feature
- js folder has all the individual js scripts
- images fodler has all related images

## Admin Panel

All the related code is inside the 'admin' folder.

## Tutor Panel

All the related code is inside the 'tutor' folder.

## Database

Since there is no 3rd party script handling the evolution of the database we have created a static list of sql file with changes to the db. 

## uploads

The uploaded files are stored in this folder