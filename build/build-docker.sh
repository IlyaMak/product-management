if [ -f '.env' ]
then
    docker compose down
    docker compose build
    docker compose up -d
    docker compose exec php composer install
    docker compose exec php bash -c "cd frontend && npm i && npm run build && cd - && cp -r frontend/build/* public/"
else
    echo 'You need to create the .env file in the root directory. Run: cp .env.example .env'
fi