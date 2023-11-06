-- Table 1: Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

-- Table 2: Games
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    type VARCHAR(255)
);

-- Table 3: Game Scores
CREATE TABLE game_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    game_id INT,
    score INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (game_id) REFERENCES games(id)
);

-- Table 4: Ranks
CREATE TABLE ranks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    score INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table 5: Profile Images
CREATE TABLE profile_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    caption VARCHAR(255),
    image_path VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
