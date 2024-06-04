# Microservice Architecture for Laravel

## Table of Contents

- [Overview](#overview)
- [Technologies](#technologies)
- [Getting Started](#getting-started)
- [Installation](#installation)
- [Configuration](#configuration)
- [Generate RSA Keys](#generate-rsa-keys)
- [Running the Services](#running-the-services)
- [Microservices](#microservices)
  - [Security](#security-service)
- [Contributing](#contributing)
- [License](#license)

## Overview

This project is a microservice-based architecture designed to provide scalable and maintainable solutions.
It includes various technologies for managing service discovery, messaging, and data integration.

## Technologies

- **Zookeeper**: Used for service discovery and coordination.
- **ZooNavigator**: A web-based UI for managing Zookeeper instances.
- **Kafka**: A distributed streaming platform used for building real-time data pipelines and streaming applications.
- **Schema Registry**: Manages and enforces schemas for Kafka topics.
- **Kafka Connect**: A tool for scalable and reliably streaming data between Apache Kafka and other systems.
- **Kafka UI**: A web-based UI for managing and monitoring Kafka clusters.
- **PostgreSQL**: A powerful, open source object-relational database system.

## Getting Started

Ensure you have the following software installed:
- Docker
- Docker Compose

To get a local copy of this project up and running, follow these simple steps.

## Installation

1. Clone the repository:
    ```shell
    git clone https://github.com/erayaydin/microservice-laravel.git
    cd microservice-laravel
    ```
2. Copy the sample `.env.example` to `.env`:
    ```shell
    cp .env.example .env
    ```
3. Edit necessary parts in `.env` file as needed.

## Configuration

The configuration settings are stored in the `.env` file. Customize the necessary parts as needed.

- **ZOOKEEPER_IMAGE**: Docker image name to use for zookeeper instances. Default: `confluentinc/cp-zookeeper`
- **ZOOKEEPER_IMAGE_VERSION**: Docker image version for _ZOOKEEPER_IMAGE_ image. Default: `7.6.1`
- **ZOONAVIGATOR_VERSION**: ZooNavigator UI image version to install with services. Default: `1.1.2`
- **KAFKA_IMAGE**: Docker image name to use for kafka instances. Default: `confluentinc/cp-kafka`
- **KAFKA_IMAGE_VERSION**: Docker image version for _KAFKA_IMAGE_ image. Default: `7.6.1`
- **SCHEMA_REGISTRY_IMAGE**: Docker image name to use for SchemaRegistry instances. Default: `confluentinc/cp-schema-registry`
- **SCHEMA_REGISTRY_IMAGE_VERSION**: Docker image version for _SCHEMA_REGISTRY_IMAGE_ image. Default: `7.6.1`
- **KAFKA_CONNECT_IMAGE**: Docker image name to use for kafka connect instances. Default: `confluentinc/cp-kafka-connect`
- **KAFKA_CONNECT_IMAGE_VERSION**: Docker image version for _KAFKA_CONNECT_IMAGE_ image. Default: `7.6.1`
- **WWWUSER**: User id for microservice instances. Default: `1000`
- **WWWGROUP**: Group id for microservice instances. Default: `1000`
- **APP_[SERVICE]_DB_IMAGE_VERSION**: PostgreSQL instance version for the `[SERVICE]` microservice. Default: `15`
- **APP_[SERVICE]_PORT**: External port of the `[SERVICE]` microservice. It will be increased 1 by 1 starting from
`8082`.
- **APP_[SERVICE]_XDEBUG_MODE**: Enable xdebug extension for the `[SERVICE]` microservice. Default: `off`
- **APP_[SERVICE]_XDEBUG_CONFIG**: If xdebug enabled, xdebug integration config. Edit for development environment needs.
Default: `-client_host=host.docker.internal`
- **APP_[SERVICE]_DB_PORT**: External port of the `[SERVICE]` microservice's database. It will be increased 1 by 1
starting from `5432`.

## Generate RSA Keys

You need to generate a pair of 4096-bit RSA private and public keys for inter-service authentication
and authorization. These keys will be shared between services.

```shell
openssl genrsa -out secrets/oauth-private.key 4096
openssl rsa -in secrets/oauth-private.key -pubout -out secrets/oauth-public.key
```

## Running the Services

To start all the services, run:

```shell
docker compose up -d
```

This command will start all the containers defined in the docker-compose.yml file.

Remember to run migrations and necessary adjustments before testing services. Like:

```shell
docker compose exec -u app security php artisan migrate
```

## Microservices

### Security Service

The Security Service is responsible for handling user authentication and authorization.
Authentication and authorization will be handled with OAuth2.

#### Endpoints

- `GET /health`: Health check endpoint. It'll respond with 200 status code.
- `GET /oauth/authorize`: Show authorization to the end user.
- `POST /oauth/authorize`: Approve authorization.
- `DELETE /oauth/authorize`: Deny authorization.
- `GET /oauth/clients`: Get oauth clients for the user.
- `POST /oauth/clients`: Create new oauth client.
- `PUT /oauth/clients/{client_id}`: Update an oauth client.
- `DELETE /oauth/clients/{client_id}`: Delete an oauth client.
- `GET /oauth/personal-access-tokens`: Get personal access token oauth clients for the user.
- `POST /oauth/personal-access-tokens`: Create new personal access token oauth client.
- `DELETE /oauth/personal-access-tokens/{token_id}`: Delete a personal access token oauth client.
- `GET /oauth/scopes`: Get all registered scopes.
- `POST /oauth/token`: Issue new token with specified strategy.
- `POST /oauth/token/refresh`: Refresh access token with refresh token.
- `GET /oauth/tokens`: Get authorized access token for the user.
- `DELETE /oauth/tokens/{token_id}`: Delete an access token.

#### Data Store

- **PostgreSQL**: The Security Service uses PostgreSQL to store user credentials and authorization data.

## Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any
contributions you make are **greatly appreciated.**

1. Fork the Project
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a pull request with detailed description.

## License

Distributed under the **MIT License**.
