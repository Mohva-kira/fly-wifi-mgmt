# RUN
FROM node:12-alpine AS build

ARG envType=staging

RUN echo ${envType}

RUN mkdir /app

WORKDIR /app

COPY app/ /app
RUN npm install


CMD ["npm", "start"]

EXPOSE 3000
