CREATE TABLE 'files' (
    'id' INT AUTO_INCREMENT PRIMARY KEY,
    'file_name' VARCHAR(200) NOT NULL,
    'file_size' INT NOT NULL,
    'file_type' VARCHAR(100) NOT NULL,
    'file_id' VARCHAR(200) NOT NULL,
    'file_viewLink' VARCHAR(200) NOT NULL,
    'file_downloadLink' VARCHAR(200) NOT NULL,
    'file_owner' VARCHAR(200) NOT NULL,
    'upload_date' TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `file_owner` (`file_owner`),
    UNIQUE KEY 'file_id' ('file_id')
);