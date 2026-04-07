# CSC 4370 Project 2

## Final Answer
Final Answer is a web-based game inspired by *Who Wants to Be a Millionaire?*. Players compete in a turn-based multiplayer trivia game, answering multiple-choice questions that increase in difficulty to earn money. The game includes session-based state management, lifelines, and a live leaderboard. We chose this topic because it allowed us to combine game logic, session handling, and interactive UI design into a cohesive project while adding our own spin.

---

## Setup Instructions

### Requirements
- PHP 8.1.33
- Web browser

### Installation (CODD Server)
1. Download or clone this repository
2. Upload the project folder (`final-answer`) to your CODD directory
3. Navigate to the live URL using: ```https://codd.cs.gsu.edu/~[your_username]/[directory]/final-answer/index.php```

### Project Structure
```
final-answer/
├── assets/             <-- CSS and UI Images
├── data/               <-- User Data & Text-based question bank (Easy, Medium, Hard)
├── includes/           <-- Reusable PHP & game logic
├── index.php           <-- Landing 
├── login.php           <-- Login
├── registration.php    <-- Registration
├── game.php            <-- Game loop
├── results.php         <-- Results 
├── leaderboard.php     <-- High scores
```

---

## Usage Guide

### Live URL
https://codd.cs.gsu.edu/~dkennedy18/WP/PW/2/final-answer/index.php

### How to Play
1. Register a new account from the home page
2. Log in using your credentials
3. Click **Play** to start the game
4. Answer multiple-choice questions to progress and earn money
5. Use lifelines (50:50, hint, pass) strategically
6. The game ends when a question is answered incorrectly or all questions are completed
7. View your results and compare scores on the leaderboard

### Navigation
- **Login/Register** → Account access  
- **Play** → Start game session  
- **Question** → Core gameplay screen  
- **Results** → End-of-game summary  
- **Leaderboard** → View top scores  

---

## Team Members
- Dandre Kennedy
  - Student ID: 002707942
  - PHP Contribution:
- Daviss Le
  - Student ID: 002650740
  - PHP Contribution: 