FROM node:20.15.1

# Actualizar e instalar dependencias básicas
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y git bash && \
    rm -rf /var/lib/apt/lists/*

# Definir el directorio de trabajo
WORKDIR /usr/src

# Pasar argumentos para parametrizar la UID (por defecto 1000)
ARG UID=1000

# Ajustar la UID del usuario node y asignarle la propiedad del directorio de trabajo
RUN usermod -u ${UID} node && chown -R node:node /usr/src

# Usar al usuario node para las siguientes operaciones
USER node

EXPOSE 5173

# Se puede definir el comando por defecto, o usar el comando en docker-compose
CMD ["bash", "-c", "npm install && npm run dev"]
