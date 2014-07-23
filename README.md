# Start Server
php app/console server:run

# Generate getters / setters
php app/console doctrine:generate:entities App/ManagerBundle/Entities/Model/Employee

# Update Database
php app/console doctrine:schema:update --force