FROM node:lts-alpine
WORKDIR /app

COPY package*.json ./
RUN npm install
RUN npm install bootstrap

COPY . . 

CMD ["npm", "run", "dev", "--", "--host"]
