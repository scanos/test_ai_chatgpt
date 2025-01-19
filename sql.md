CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    message TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE contacts ADD COLUMN username VARCHAR(255) NULL;

note that chatgpt recommended fields to be not not null but this threw errors even though the fields were populated
