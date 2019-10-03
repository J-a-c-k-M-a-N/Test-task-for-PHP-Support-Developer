### Install

Step inside project directory:
`
cd <project_dir>/test-task-for-php-support-developer
`

Start application docker containers:
`
docker-compose up -d
`

Database migrations install:
`
docker exec -it test-app-two php -f database/migration/db_start.php
`

Application server should be ready on http://0.0.0.0:80
and Adminer server on http://0.0.0.0:6080

Database access: 
- System `PostgreSQL`
- Server `db`
- Username `test`
- Password `test`
- Database `wallet`