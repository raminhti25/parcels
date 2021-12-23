FROM node:latest
WORKDIR /app
COPY parcel-ui/package.json ./
RUN npm install
COPY . .
CMD ["npm", "start"]