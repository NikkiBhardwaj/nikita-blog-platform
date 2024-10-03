-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create blog_posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    tags VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_draft BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample users
INSERT INTO users (username, password, email) VALUES 
('user1', 'hashed_password1', 'user1@example.com'),
('user2', 'hashed_password2', 'user2@example.com');

-- Insert sample blog posts
INSERT INTO blog_posts (title, content, user_id, status, tags, is_draft) VALUES 
('First Post', 'Content of the first post', 1, 'published', 'tag1, tag2', FALSE),
('Second Post', 'Content of the second post', 1, 'draft', 'tag3', TRUE),
('Third Post', 'Content of the third post', 2, 'published', 'tag1', FALSE);
