if [ -f '.env' ]
then
    composer install
    cd frontend
    npm i
    npm run build
    cd -
    cp -r frontend/build/* public/
else
    echo 'You need to create .env file in the root directory. Run: cp .env.example .env'
fi