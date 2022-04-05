FROM php:7.4-cli
COPY . /usr/src/coding-challenge
WORKDIR /Documents/Code/Stuff/coding-challenge
CMD [ "php", "./main.php" ]

# Run command below to build the container
# docker build -t coding-challenge .

# Run command below to run the command
# docker run -it --rm coding-challenge