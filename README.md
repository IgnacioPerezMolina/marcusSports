# Marcus Sports

A customizable e-commerce platform where users can build products like bicycles by selecting individual parts. Each
configuration has dynamic pricing and compatibility rules. Built with Symfony (backend) and Vue + PrimeVue (frontend),
following DDD and Hexagonal Architecture for scalability and maintainability.

## Table of Contents

1. [Introduction](#introduction)
2. [Architecture Overview](#architecture-overview)
    - [Layers](#layers)

## Introduction

I intentionally embraced a degree of overengineering in this project because I wanted to demonstrate my proficiency with
design patterns, domain‑driven design and a layered architecture that cleanly separates responsibilities. Although I
could have relied on a simpler, framework‑centric approach to deliver more quickly, I felt it was important to showcase
abilities that go beyond any specific language or framework.

## Architecture Overview

### Root Directory Structure

At the top level, the project is laid out into three main folders plus the usual solution files:

- **docker/**  
  Contains the `docker-compose.yml` and related config for building and orchestrating all containers (database, PHP,
  Node, etc.).

- **backend/**  
  The Symfony 7.2 application—this is the “star” of the project. It implements DDD and Hexagonal Architecture across the
  bounded contexts and modules, with clear separation of layers (Application, Domain, Infrastructure).

- **frontend/**  
  A Vue 3 + PrimeVue single‑page app that consumes the backend APIs. Organised by views and feature modules, with global
  state (Pinia) and reusable UI components.

---

### Bounded Contexts & Modules

- **BackOffice**
    - Manage the catalog (create/edit products and their parts)
    - View orders
    - Administer stock
    - Oversee users

- **Catalog**
    - Core domain for:
        - Products
        - Parts
        - Configurations

- **Payment**
    - Encapsulates all integrations with external payment gateways

- **Sales**
    - Handles:
        - Shopping cart operations
        - Order processing

- **Users**
    - Manages everything related to user accounts and profiles

### Shared

- A single **Shared** folder is referenced by every Bounded Context and module
- Contains common utilities, value objects, helper services and other framework‑agnostic components

## Layered Architecture

Each module in the **backend** follows a three‑layer structure—**Domain**, **Application**, and **Infrastructure**—to enforce separation of concerns and align with Domain‑Driven Design and Hexagonal Architecture.

### Domain Layer
- The heart of the business model:
    - **Entities**, **Value Objects**, **Aggregates**
    - **Domain Services** and **Domain Events**
    - Encapsulates all core business rules with **no external dependencies**

### Application Layer
- Orchestrates use cases and workflows:
    - **Application Services** (command handlers, query handlers)
    - **Data Transfer Objects (DTOs)** and **Ports/Interfaces**
    - Coordinates Domain objects to fulfill specific actions
    - Depends **only** on the Domain Layer

### Infrastructure Layer
- Provides technical implementations and integrations:
    - **Repository** implementations (e.g. Doctrine ORM)
    - External API clients (payment gateways, email/SMS providers)
    - Messaging/event publishers, file storage, caching, etc.
    - Symfony service configuration, DI wiring and bootstrapping

#### Directory Structure Example

```
backend/
└── src/
    └── <BoundedContext>/
        ├── Domain/
        ├── Application/
        └── Infrastructure/
```

## Local Development

Use the included Makefile to manage containers, access the backend, and run tests.

- `make build` to build the containers
- `make start` to start the containers
- `make stop` to stop the containers
- `make restart` to restart the containers
- `make test` to run the full test suite inside the backend container
- `make logs` to see application logs
- `make ssh` to SSH into the application container

## How I worked in this repository

In the beginning, I try to implement a type of DDD following this process:
 
- Contract with the costumer
- Controllers
- Use Case (Application)
- Repository
- Aggregated, domain, value Objects
- Infrastructure is the last to avoid contamination (Persistence is an implementation detail)


## Design Patterns
- Repository Patterns


## Testing

You can find them in the folder /backend/tests

I made only a few tests, but cover acceptance (end to end), integration and unit.

### Mothers

I use this to improve the manteinemet of the tests. If you want to modify a Model and you use a Mother you only need to update in that place.




## Special Use Cases
- Value Object (UUID infrastructure inside Domain and explication)
- el tema de guardar la información de los pedidos - About, "save unfinished order into a database or what", I discovered a use case to uso that information to send a help
  email to support the order and finish it. I’m not sure if later I’m going to delete data from database or maybe set an
  state (Depends on product decisions and metrics that we want to measure)
- clone of DateTimeValueObject, to keep immutability
- DECISION - I create a PartType as AggregatedRoot because maybe Marcus wants to sell parts, and it doesn't depend on a
  Product


### Entities and Doctrine (ORM) 
- mappeo de entidades
- doctrine custom type
- Explain how we can add different entity Managers using doctrine.yaml, if we need to use different databases, etc
- orm / dbal (Query builder)/ PDO
- DSL into validations for json fields


## Resources:

- Database Sketch: https://drive.google.com/file/d/1kwxwLtPBegcwcSPHlR8rV8D6S4RFW33I/view?usp=sharing
- Postman Example endpoints: 

![resume](database-sketch.png)

# Cosas que no he hecho y me hubiera gustado hacer
- Explain why I dont add more complexity to Roles and how can I make it with permissions, Casbin
- stock, ya sea añadiendo un campo a casa partitem.
- eventos de dominio, ya fueran síncronos o en una cola
- algo de arquitectura de docker
- carrito de la compra (hacer estimación de tablas y como lo haria)


# Cosas de las que podemos hablar con el entrevistador
- health check. - Ask to interviewer
- Speak about keycloak as a service instead of Symfony authorization
+ DECISION - I create a PartType as AggregatedRoot because maybe Marcus wants to sell parts, and it doesn't depend on a
  Product
- orm / dbal (Query builder)/ PDO
- acercamiento de negocio a solución técnica, traer tierra a producto.
- nm entre product y parttypes (iluminación que sirve para bicis y otro tipo de material deportivo)






















