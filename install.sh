#!/bin/bash

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RESET='\033[0m'

function success {
    echo -e "${GREEN}$1${RESET}"
}

function error {
    echo -e "\e[31m$1\e[0m"
}

function progress_bar {
    local duration=$1
    already_done() { for ((done=0; done<$elapsed; done++)); do printf "▇"; done }
    remaining() { for ((remain=$elapsed; remain<$duration; remain++)); do printf " "; done }
    percentage() { printf "| %s%%" $(( (($elapsed)*100)/($duration)*100/100 )); }

    for ((elapsed=1; elapsed<=duration; elapsed+=1)); do
        already_done; remaining; percentage
        printf "\r";
        sleep 0.1
    done
    printf "\n";
}

echo -e "${YELLOW}Do you want to install Docker and Docker Compose? [yes/no]${RESET}"
read installDocker
if [[ "$installDocker" == "yes" ]]; then
    echo "Installing Docker and Docker Compose..."

    if ! command -v docker &> /dev/null; then
        sudo apt-get update
        sudo apt-get install ca-certificates curl
        sudo install -m 0755 -d /etc/apt/keyrings
        sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
        sudo chmod a+r /etc/apt/keyrings/docker.asc
        sudo service docker start
        sudo systemctl enable docker

        success "Docker was successfully installed."

        echo \
          "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
          $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
          sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
        sudo apt-get update

        if ! getent group docker; then
            sudo groupadd docker
        fi
        sudo usermod -aG docker $USER
        success "User '$USER' was added to the docker group. Please log out and log back in for this change to take effect."
    else
        success "Docker is already installed."
    fi

    if ! command version docker compose &> /dev/null; then

        sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

        success "Docker Compose was successfully installed."
    else
        success "Docker Compose is already installed."
    fi
else
    echo "Docker installation was cancelled."
fi

echo -e "${YELLOW}Do you want to create the .env file? [yes/no]${RESET}"
read createEnv

if [[ "$createEnv" == "yes" ]]; then
    echo -e "${BLUE}Creating environment file...${RESET}"
    progress_bar 15
    if [ ! -f .env ]; then
        cp .env.example .env
        success "The .env file was successfully created."
    else
        success ".env file already exists."
    fi
else
    echo "Skipping .env file creation."
fi

echo -e "${YELLOW}Do you want to set up Basic Authentication for Nginx? [yes/no]${RESET}"
read setupAuth

if [[ "$setupAuth" == "yes" ]]; then
    echo -e "${BLUE}Creating .htpasswd file...${RESET}"
    htpasswd -c ./docker/nginx/.htpasswd webmaster
    success ".htpasswd file was successfully created."
else
    echo "Skipping Basic Authentication setup."
fi

echo -e "${BLUE}Generating JWT keys...${RESET}"
progress_bar 20
if [ ! -f api/config/jwt/private.pem ]; then
    mkdir -p api/config/jwt
    openssl genpkey -algorithm RSA -out api/config/jwt/private.pem -aes256 -pass pass:$(grep JWT_PASSPHRASE .env | cut -d '=' -f2)
    openssl rsa -pubout -in api/config/jwt/private.pem -out api/config/jwt/public.pem -passin pass:$(grep JWT_PASSPHRASE .env | cut -d '=' -f2)
    success "JWT keys were successfully generated."
else
    success "JWT keys already exist."
fi

echo -e "${BLUE}Starting Docker Compose containers...${RESET}"
progress_bar 25
if docker compose up -d; then
    success "Docker containers were successfully started."
else
    error "Failed to start Docker Compose containers."
    exit 1
fi

echo -e "${BLUE}Installing PHP dependencies...${RESET}"
progress_bar 20
if docker compose exec php composer install --ignore-platform-reqs --no-scripts; then
    success "Composer dependencies were successfully installed."
else
    error "Failed to install Composer dependencies."
    exit 1
fi

echo -e "${BLUE}Running database migrations...${RESET}"
progress_bar 15
if docker compose exec php console/yii migrate --interactive=0; then
    success "Migrations were successfully applied."
else
    error "Failed to apply migrations."
    exit 1
fi

echo -e "${BLUE}Running RBAC migrations...${RESET}"
progress_bar 15
if docker compose exec php console/yii rbac-migrate; then
    success "RBAC migrations were successfully applied."
else
    error "Failed to apply RBAC migrations."
    exit 1
fi

echo -e "${BLUE}Running RBAC permissions setup...${RESET}"
progress_bar 20
if docker compose exec php console/yii app/permission; then
    success "RBAC permissions were successfully applied."
else
    error "Failed to apply RBAC permissions."
    exit 1
fi

echo -e "${BLUE}Running application setup...${RESET}"
progress_bar 20
if docker compose exec php php console/yii app/setup; then
    success "Application setup was successfully completed."
else
    error "Failed to complete application setup."
    exit 1
fi

echo -e "${GREEN}Application was successfully installed and started!${RESET}"
echo -e "${GREEN}Your application is running at the following URLs:${RESET}"
echo -e "${BLUE}http://localhost${RESET}"
echo -e "${BLUE}http://api.localhost${RESET}"
echo -e "${BLUE}http://admin.localhost${RESET}"
